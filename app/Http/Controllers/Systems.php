<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Validator;
use Illuminate\Http\Request;
use Redirect;
use Log;
use App;
use DB;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Systems extends BaseController
{

    public $sysdb;

    public function __construct() {
        $this->sysdb = DB::connection('mysql');
        App::setLocale('ru');
        date_default_timezone_set('Europe/Moscow');

        $this->middleware(function ($request, $next) {
            $this->auth = session()->get('auth');
            if(!$this->auth) {
                $this->auth = 0;
            } else {
                $email = session()->get('email');
                $username = $this->sysdb->table('accounts')->where('email', $email)->get();
                if(count($username) >= 1) {
                    $this->sysperson[0] = $username[0]->email;
                    $this->sysperson[1] = $username[0]->balance;
                    $this->sysperson[2] = $username[0]->moder;
                }
                $date = new \DateTime();
                $date_format = $date->format('Y-m-d H:i:s');
                $this->sysdb->table('accounts')->where('id', $username[0]->id)->update(['last_online' => $date_format]);
            }
            return $next($request);
        });
    }

    public function WalletGenerate($id) {
        if($id == 1) {
            if($_POST['value_2'] >= 50) {
                $secret_key = "aqlKZndlFCifZq6c";
                $get_num = $this->sysdb->table('payments')->where('interkassa', 'like', '%SAMPB5%')->count();
                $get_num++;
                $sign_hash = "";
                $sum = money_format("%.2n", $_POST['value_2']);
                $dataSet = array(
                    "ik_co_id" => "5e2b96de1ae1bd0d008b456e",
                    "ik_pm_no" => 'SAMPB5_'.$get_num,
                    "ik_am" => $sum,
                    "ik_cur" => $_POST['value_3'],
                    "ik_desc" => "Пополнение баланса SAMP-BET.RU"
                );
                ksort($dataSet, SORT_STRING);
                $json = $dataSet;
                array_push($dataSet, $secret_key);
                $signString = implode(':', $dataSet);
                Log::debug('1: '.$signString);
                $sign = base64_encode(md5($signString, true));
                $sign_hash = $sign;
                $sign = array('ik_sign'=>$sign);
                array_push($json, $sign);
                $json = json_encode($json);
                $date = new \DateTime();
                $date_format = $date->format('Y-m-d H:i:s');
                $get_email = $this->sysdb->table('accounts')->where('email', $_POST['value_1'])->get();
                if(count($get_email) == 1) {
                    $this->sysdb->table('payments')->insert(['interkassa' => $dataSet['ik_pm_no'], 'hash' => $sign_hash, 'email' => $get_email[0]->email, 'type' => '0', 'username' => $_POST['value_1'], 'content' => 'Пополнение баланса', 'sum' => $_POST['value_2'], 'cur' => $_POST['value_3'], 'datefirst' => $date_format]);
                    return $json;
                } else {
                    return 1;
                }
            } else {
                return 0;
            }
        }
    }

    public function AuthProcess(Request $request) {

        $rules = array(
            'email'    => 'required|email|min:10',
            'password' => 'required|alphaNum|min:5'
        );
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('panel')
                ->withErrors($validator);
        } else {

            $userdata = array(
                'email'     => $request['email'],
                'password'  => $request['password']
            );

            $login = $this->sysdb->table('accounts')->where('email', $userdata['email'])->get();

            if(count($login) == 1) {
                $password = hash('sha256', $userdata['password']);
                if($password == $login[0]->password) {
                    session(['auth' => 1, 'email' => $login[0]->email]);
                    return redirect('panel');
                } else {
                    return redirect('panel')->with('system', 'Неверный пароль');
                }
            } else {
                return redirect('panel')->with('system', 'Таких не знаем');
            }

            // Good Auth
        
        }
    }

    public function VerifProcess($code) {
        $unixtime = time();
        $verif = $this->sysdb->table('storage')->where('verif_code', $code)->get();
        if(count($verif) >= 1) {
            $calc_time = $unixtime - $verif[0]->unixtime;
            if($calc_time <= 3600) {
                if($verif[0]->verif == 0) {
                    $this->sysdb->table('storage')->where('verif_code', $code)->update(['verif' => '1']);
                    $userdata = json_decode($verif[0]->data);
                    $keygen = time().$userdata->email.rand(10000000,99999999);
                    $keygen = hash('sha256', $keygen);
                    $password = hash('sha256', $userdata->password);
                    $this->sysdb->table('accounts')->insert(['email' => $userdata->email, 'password' => $password, 'ip' => $verif[0]->ip, 'keydash' => $keygen, 'promo' => $userdata->invite]);
                    return redirect('panel')->with('system', 'Регистрация подтверждена. Приятного использования сервиса :)');
                } else {
                    return redirect('panel')->with('system', 'Данный код уже активирован для учетной записи');
                }
            } else {
                return redirect('panel')->with('system', 'Код истек и является неактуальным');
            }
        } else {
            return redirect('panel')->with('system', 'Неизвестный код');
        }
    }

    public function RegisterProcess(Request $request) {
        $rules = array(
            'email'    => 'required|email|min:10',
            'password' => 'required|alphaNum|min:5',
            'password_repeat' => 'required|alphaNum|min:5|same:password',
        );

        /*             'invite' => 'required|string|min:3', */
        
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator);
        } else {

            $userdata = array(
                'email'     => $request['email'],
                'password'  => $request['password'],
                'password_repeat'  => $request['password_repeat']
            );

            $userdata['invite'] = session()->get('referal');
            if($userdata['invite']) {
                $userdata['invite'] = $userdata['invite'];
            } else {
                $userdata['invite'] = 1;
            }

            if($userdata['invite'] || !$userdata['invite']) {
                $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
                $user = $this->sysdb->table('accounts')->where('email', $userdata['email'])->get();
                if(count($user) == 0) {
                    $unixtime = time();
                    $checktime = 0;
                    $email = $this->sysdb->table('storage')->where('email', $userdata['email'])->get();
                    if(count($email) == 1) {
                        $checktime = $email[0]->unixtime;
                        $checktime = $unixtime - $checktime; 
                    }
                    if(count($email) == 0 && $checktime == 0 || count($email) == 1 && $checktime >= 3600) {
                        $json_generate = json_encode($userdata);
                        if(count($email) >= 1) {
                            $this->sysdb->table('storage')->where('email', $userdata['email'])->delete();
                        }
                        $keydash = 'tellarion'.$userdata['email'].$userdata['password'].rand(10000,99999);
                        $keydash = hash('sha256', $keydash);
                        $mail = new PHPMailer;
                        $mail->isSMTP();
                        $mail->Host = 'smtp.yandex.ru';
                        $mail->SMTPAuth = true;
                        $mail->CharSet = "utf-8";
                        $mail->Username = 'support@samp-bet.ru';
                        $mail->Password = '';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        $mail->setFrom($mail->Username, "SAMP-BE? - Регистрация");
                        $mail->addReplyTo($mail->Username, "SAMP-BE? - Регистрация");
                        $mail->addAddress($userdata['email'], $userdata['email']);
                        $mail->WordWrap = 50;
                        $mail->isHTML(true);
                        $mail->Subject = 'Регистрация «SAMP-BE?»';
                        $mail->Body    = 'Приветствуем тебя, '.$userdata['email'].'. Для подтверждения регистрации на сайте «SAMP-BE?»<br>Перейдите по ссылке: /register/verif/'.$keydash.'';
                        if(!$mail->send()) {
                            Log::debug('Message could not be sent.'.$mail->ErrorInfo);
                            Log::debug('Mailer Error: ' . $mail->ErrorInfo);
                            return redirect()->back()->with('system', 'Сервис временно недоступен '.$mail->ErrorInfo);
                         } else {
                            Log::debug('Message has been sent '.$mail->ErrorInfo);
                            $this->sysdb->table('storage')->insert(['email' => $userdata['email'],'data' => $json_generate, 'ip' => $ip, 'unixtime' => $unixtime, 'verif' => '0', 'verif_code' => $keydash]);
                            return redirect('panel')->with('system', 'Регистрация завершена. Проверьте почтовый ящик и подтвердите регистрацию.');
                        }
                    } else {
                        return redirect()->back()->with('system', 'На данный почтовый адрес уже было отправлено письмо, если оно не пришло, попробуйте через один час');
                    }
                } else {
                    return redirect()->back()->with('system', 'Пользователь с таким электронным адресом уже зарегистрирован');
                }
            } else {
                return redirect()->back()->with('system', 'Такого инвайта нет');
            }
        
        }
    }

    public function SettingsProcess(Request $request, $id) {

        if($id == 1) {

            $rules = array(
                'ident' => 'required|string|min:8',
            );
            
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return Redirect::to('panel/settings')
                    ->withErrors($validator);
            } else {

                $userdata = array(
                    'ident'  => $request['ident']
                );

                $email = session()->get('email');

                $check_busy = $this->sysdb->table('accounts')->where('username', strtolower($userdata['ident']))->get();

                if(count($check_busy) == 0) {
                    $this->sysdb->table('accounts')->where('email', $email)->update(['username' => strtolower($userdata['ident'])]);
                    return redirect('panel/settings')->with('system', 'Настройки сохранены');
                } else {
                    if($check_busy[0]->email == $email) {
                        $this->sysdb->table('accounts')->where('email', $email)->update(['username' => strtolower($userdata['ident'])]);
                        return redirect('panel/settings')->with('system', 'Настройки сохранены');
                    } else {
                        return redirect('panel/settings')->with('system', 'Данный идентификатор уже занят другим участником системы');
                    }
                }
            }
        } else if($id == 2) {
            $rules = array(
                'welcome'   =>  'required|string|min:10|max:156',
                'color' => 'required|string|min:3|max:7',
                'sum' => 'required|between:0,1000.0'
            );
            
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return Redirect::to('panel/personalization')
                    ->withErrors($validator);
            } else {

                $userdata = array(
                    'welcome'  => Input::get('welcome'),
                    'color'  => Input::get('color'),
                    'sum'  => Input::get('sum')
                );

                $email = session()->get('email');

                //$get_user = $this->sysdb->table('accounts')->where('email', $email)->get();
                $this->sysdb->table('accounts')->where('email', $email)->update(['welcome' => htmlspecialchars($userdata['welcome']), 'background' =>  $userdata['color'], 'sum' => $userdata['sum']]);
                return redirect('panel/personalization')->with('system2', 'Новая персонализация сохранена');
            }
        } else {
            return redirect('panel/personalization')->with('system', 'Неизвестный ID для выполнения запроса в систему');
        }
    }

    public function WithdrawInterkassa() {
        $ch = curl_init();
        $url = "https://api.interkassa.com/v1/withdraw";
        $auth_login = '5bb32b183c1eaff7728b4568';
        $auth_password = '';
        $auth_data = $auth_login.':'.$auth_password;
        $headers = ['Authorization: Basic '.$auth_data, 'Ik-Api-Account-Id: ************************', 'content-type: multipart/form-data'];
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $token_passport);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $response = json_decode($response);
        curl_close($ch);
    }

    public function WithdrawProcess(Request $request, $id) {

        if($id == 1) {

            $rules = array(
                'method' => 'required|string',
                'addr' => 'required|string|min:10|max:156',
                'sum' => 'required|between:0,10000.00'
            );
            
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return redirect('panel/withdraw')
                    ->withErrors($validator);
            } else {

                $userdata = array(
                    'method'  => $request['method'],
                    'addr'  => $request['addr'],
                    'sum'  => $request['sum']
                );

                $email = session()->get('email');

                $user = $this->sysdb->table('accounts')->where('email', $email)->get();

                if($user[0]->balance >= $userdata['sum']) {
                    if($userdata['sum'] >= 100) {
                        $sum = $userdata['sum'];
                        $commission = 100 - $user[0]->commission_withdraw; // service + interkassa
                        $commission = ($userdata['sum'] / $commission * 100);
                        $commission = $commission - $userdata['sum'];
                        $userdata['sum'] = $userdata['sum'] - $commission;
                        $date = new \DateTime();
                        $date_format = $date->format('Y-m-d H:i:s');
                        $get_num = $this->sysdb->table('withdraw')->count();
                        $get_num++;
                        $tester = "";
                        $ch = curl_init();
                        $url = "https://api.interkassa.com/v1/withdraw";
                        $auth_login = '5bb32b183c1eaff7728b4568';
                        $auth_password = '';
                        $auth_data = base64_encode($auth_login.':'.$auth_password);
                        $auth_user = '5cab3f203b1eaf72038b456b';
                        $headers = array(
                            'Authorization: Basic '.$auth_data,
                            'Ik-Api-Account-Id: '.$auth_user
                        );
                        // purse = 404020965768
                        $data = array(
                            'amount' => $userdata['sum'],
                            "paywayId" => "520500478f2a2d081000000a",
                            'details' => array(
                                'phone' => $userdata['addr'], 
                            ),
                            'purseId' => '403286074137',
                            'calcKey' => 'ikPayerPrice',
                            'action' => 'process',
                            'paymentNo' => 'SAMPBET_'.$get_num
                        );
                        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        $data = json_decode($response);
                        Log::debug($response);
                        if($data->status != "error") {
                            $this->sysdb->table('payments')->insert(['email' => $email, 'type' => '1', 'username' => $email, 'content' => 'Вывод средств', 'sum' => $sum, 'cur' => 'RUB', 'status' => '1', 'datefirst' => $date_format]);
                            $this->sysdb->table('withdraw')->insert(['email' => $email, 'interkassa' => 'SAMPBET_'.$get_num, 'method' => 'qiwi', 'addr' => $userdata['addr'], 'input' => $sum, 'sum' => $userdata['sum'], 'datefirst' => $date_format]);
                            $money = $user[0]->balance - $sum;
                            $this->sysdb->table('accounts')->where('email', $email)->update(['balance' => $money]);
                            // update com balance haben
                            $user2 = $this->sysdb->table('accounts')->where('id', 1)->get();
                            $money = $user2[0]->balance + $commission;
                            $this->sysdb->table('accounts')->where('id', 1)->update(['balance' => $money]);
                            $this->sysdb->table('payments')->insert(['email' => $user2[0]->email, 'type' => '0', 'username' => $user2[0]->email, 'content' => 'Доход с комиссии [В:'.$user[0]->id.']', 'sum' => $sum, 'cur' => 'RUB', 'status' => '1', 'datefirst' => $date_format, 'datesecond' => $date_format]);
                            return redirect('panel/withdraw')->with('system', 'Выплата создана');
                        } else {
                            return redirect('panel/withdraw')->with('system', 'Сервис временно недоступен');
                        }
                    } else {
                        return redirect('panel/withdraw')->with('system', 'Сумма должна быть свыше 100 РУБ для создания выплаты');
                    }
                } else {
                    return redirect('panel/withdraw')->with('system', 'Недостаточно суммы для создания выплаты');
                }
            }
        }

    }

    public function result_json($type, $code, $data = null) {
        $return = array();
        if($type == 0) {
            switch($code) {
                case 0: { $return['success'] = "Выполнено"; $return['callback'] = $data; } break;
            }
        } else if($type == 1) {
            switch($code) {
                case 0: $return['error'] = "Неизвестный метод API"; break;
                case 1: $return['error'] = "Недостаточно аргументов или же отсутствуют необходимые аргументы"; break;
                case 2: $return['error'] = "Ничего нет..."; break;
                case 3: $return['error'] = "Нет сообщений..."; break;
                case 4: $return['error'] = "Для выполнения данного действия, необходимо авторизоваться"; break;
                case 5: $return['error'] = "Пользователь не найден в системе, обратитесь в поддержку"; break;
                case 6: $return['error'] = "Сообщение не должно быть пустым"; break;
                case 7: $return['error'] = "Сумма ставки должны быть больше минимальной"; break;
                case 8: $return['error'] = "У вас нет столько средств на балансе"; break;
            }
        } else if($type == 2) {
            switch($code) {
                case 0: $return['error'] = "Для выполнения данного действия, необходимо авторизоваться"; break;
                case 1: $return['error'] = "Пользователь не найден в системе, обратитесь в поддержку"; break;
                case 2: $return['error'] = "Сессия ненайдена"; break;
                case 3: $return['error'] = "Ставки еще запрещены на данной сессии"; break;
                case 4: $return['error'] = "Сумма ставки должны быть больше минимальной"; break;
                case 5: $return['error'] = "У вас нет столько средств на балансе"; break;
                case 6: $return['error'] = "Вы уже делали ставку на этой сессии"; break;
                case 7: $return['error'] = "Непредвиденная ошибка, обновите страницу"; break;
            }
        } else if($type == 3) {
            switch($code) {
                case 0: $return['error'] = "Необходима базовая oAuth авторизация"; break;
                case 1: $return['error'] = "Для работы с данным API, необходим доступ модератора"; break;
                case 2: $return['error'] = "Неизвестный метод API"; break;
                case 3: $return['error'] = "Ничего нет..."; break;
            }
        }
        return json_encode($return);
    }

    public function API(Request $request, $name) {
        if($name == "get_category") {
            $array = array();
            $array = $this->sysdb->table('category')->get();
            if(count($array) >= 1) {
                return $this->result_json(0,0,$array);
            } else {
                return $this->result_json(1,2);
            }
        } else if($name == "get_category2") {
            $array = array();
            $array = $this->sysdb->table('category')->where('id')->get();
            $email = session()->get('email');
            if($email) {
                $email = $this->sysdb->table('accounts')->where('email', $email)->get();
                if(count($email) >= 1) {
                    $array = array();
                    $array = $this->sysdb->table('category')->where('id', $email[0]->moder_catid)->get();
                    if(count($array) >= 1) {
                        return $this->result_json(0,0,$array);
                    } else {
                        return $this->result_json(1,2);
                    }
                }
            }
        } else if($name == "get_online") {
            $array = array();
            $date = new \DateTime();
            $get_timestamp = $date->getTimestamp()-300;
            $date = $date->setTimestamp($get_timestamp);
            $date_format = $date->format('Y-m-d H:i:s');
            Log::debug($date_format);
            $array = $this->sysdb->table('accounts')->select('id','username','moder','moder_catid')->where('last_online', '>=' , $date_format)->orderBy('last_online', 'DESC')->get();
            if(count($array) >= 1) {
                return $this->result_json(0,0,$array);
            } else {
                return $this->result_json(1,2);
            }
        } else if($name == "get_sessions") {
            $get_id = $request['session_id'];
            if($get_id) {
                $array = array();
                $array = $this->sysdb->table('sessions')->where('category', $get_id)->where('status', '!=', '2')->orderBy('date_start', 'DESC')->get();
                if(count($array) >= 1) {
                    return $this->result_json(0,0,$array);
                } else {
                    return $this->result_json(1,2);
                }
            } else {
                return $this->result_json(1,1);
            }
        } else if($name == "get_chat") {
            $get_id = $request['session_id'];
            $array = array();
            $array = $this->sysdb->table('sessions_chat')->where('session_id', $get_id)->orderBy('date_post', 'DESC')->get();
            if(count($array) >= 1) {
                return $this->result_json(0,0,$array);
            } else {
                return $this->result_json(1,3);
            }
        } else if($name == "send_chat") {
            $get_id = $request['session_id'];
            $email = session()->get('email');
            if($email) {
                $email = $this->sysdb->table('accounts')->where('email', $email)->get();
                if(count($email) >= 1) {
                    $message = $request['message'];
                    if($message) {
                        $message = strip_tags($message);
                        $date = new \DateTime();
                        $date_format = $date->format('Y-m-d H:i:s');
                        $username = $email[0]->username;
                        $this->sysdb->table('sessions_chat')->insert(['session_id' => $get_id, 'user_id' => $email[0]->id, 'username' => $username, 'message' => $message, 'date_post' => $date_format]);
                        $array = array();
                        $array = $this->sysdb->table('sessions_chat')->where('session_id', $get_id)->get();
                        if(count($array) >= 1) {
                            return $this->result_json(0,0,$array);
                        } else {
                            return $this->result_json(1,3);
                        }
                    } else {
                        return $this->result_json(1,6);
                    }
                } else {
                    return $this->result_json(1,5);
                }
            } else {
                return $this->result_json(1,4);
            }
        } else if($name == "get_session") {
            $get_id = $request['session_id'];
            $array = array();
            $array = $this->sysdb->table('sessions')->where('id', $get_id)->get();
            if(count($array) >= 1) {
                return $this->result_json(0,0,$array[0]);
            } else {
                return $this->result_json(1,3);
            }
        } else if($name == "add_bet") {
            $get_id = $request['session_id'];
            $email = session()->get('email');
            if($email) {
                $email = $this->sysdb->table('accounts')->where('email', $email)->get();
                if(count($email) >= 1) {
                    $sum = $request['sum'];
                    $side = $request['side'];
                    Log::debug('mysum:'.$sum);
                    $session = $this->sysdb->table('sessions')->where('id', $get_id)->get();
                    if(count($session) >= 1) {
                        if($session[0]->status == 1) {
                            if($sum >= $session[0]->min_value) {
                                if($email[0]->balance >= $sum) {

                                    $get_all_bets = json_decode($session[0]->bets);
                                    Log::debug(print_r($get_all_bets, true));
                                    $get_all_bets_count = count($get_all_bets);
                                    Log::debug('Set bet');
                                    Log::debug($email[0]->email.':'.$sum);
                                    Log::debug($get_all_bets_count);
                                    
                                    if($get_all_bets_count >= 1) {
                                        for($i = 0; $i < $get_all_bets_count; $i++) {
                                            if($get_all_bets[$i]) {
                                                if($get_all_bets[$i]->user_id == $email[0]->id) {
                                                    return $this->result_json(2,6);
                                                }
                                                $get_all_bets[$get_all_bets_count] = array();
                                                $get_all_bets[$get_all_bets_count]['user_id'] = $email[0]->id;
                                                $get_all_bets[$get_all_bets_count]['sum'] = $sum;
                                                $get_all_bets[$get_all_bets_count]['side'] = $side;
                                                $get_all_bets = json_encode($get_all_bets);
                                                $this->sysdb->table('sessions')->where('id', $get_id)->update(['bets' => $get_all_bets]);
                                                //
                                                $money = $email[0]->balance - $sum;
                                                $this->sysdb->table('accounts')->where('email', $email[0]->email)->update(['balance' => $money]);
                                                $date = new \DateTime();
                                                $date_format = $date->format('Y-m-d H:i:s');
                                                $this->sysdb->table('payments')->insert(['email' => $email[0]->email, 'type' => '1', 'username' => $email[0]->email, 'content' => 'Инициализация ставки [#'.$get_id.']', 'sum' => $sum, 'cur' => 'RUB', 'status' => '1', 'datefirst' => $date_format]);
                                                //
                                            } else {
                                                return $this->result_json(2,7);
                                            }
                                        }
                                        return $this->result_json(0,0);
                                    } else {
                                        $get_all_bets[$get_all_bets_count] = array();
                                        $get_all_bets[$get_all_bets_count]['user_id'] = $email[0]->id;
                                        $get_all_bets[$get_all_bets_count]['sum'] = $sum;
                                        $get_all_bets[$get_all_bets_count]['side'] = $side;
                                        $get_all_bets = json_encode($get_all_bets);
                                        $this->sysdb->table('sessions')->where('id', $get_id)->update(['bets' => $get_all_bets]);
                                        //
                                        $money = $email[0]->balance - $sum;
                                        $this->sysdb->table('accounts')->where('email', $email[0]->email)->update(['balance' => $money]);
                                        $date = new \DateTime();
                                        $date_format = $date->format('Y-m-d H:i:s');
                                        $this->sysdb->table('payments')->insert(['email' => $email[0]->email, 'type' => '1', 'username' => $email[0]->email, 'content' => 'Инициализация ставки [#'.$get_id.']', 'sum' => $sum, 'cur' => 'RUB', 'status' => '1', 'datefirst' => $date_format]);
                                        //
                                        return $this->result_json(0,0);
                                    }
                                    return $this->result_json(0,0);
                                } else {
                                    return $this->result_json(2,5);
                                }
                            } else {
                                return $this->result_json(2,4);
                            }
                        } else {
                            return $this->result_json(2,3);
                        }
                    } else {
                        return $this->result_json(2,2);
                    }
                } else {
                    return $this->result_json(2,1);
                }
            } else {
                return $this->result_json(2,0);
            }
        } else {
            return $this->result_json(1,0);
        }
    }

    /* FLAGS SESSIONS */
    /* 0 = Not ready; 1 = Ready & bet active; 2 = Pause; 3 = Done */

    public function API_Moderation(Request $request, $name) {
        $email = session()->get('email');
        $email = $this->sysdb->table('accounts')->where('email', $email)->get();
        if(count($email) >= 1) {
            if($email[0]->moder == 1) {
                if($name == "get_sessions") {
                    $array = array();
                    $catid = $email[0]->moder_catid;
                    if($catid == 0) {
                        $array = $this->sysdb->table('sessions')->where('status', '!=', 2)->get();
                    } else {
                        $array = $this->sysdb->table('sessions')->where('category', $catid)->where('status', '!=', 2)->get();
                    }
                    if(count($array) >= 1) {
                        return $this->result_json(0,0,$array);
                    } else {
                        return $this->result_json(3,3);
                    }
                } else if($name == "add_session") {
                    $session_category = $request['category_id'];
                    $session_name = $request['session_name'];
                    $session_about = $request['session_about'];
                    $session_min_value = $request['session_min_value'];
                    $session_ajax_variants = $request['ajax_variants'];
                    $session_ajax_coff = $request['ajax_coff'];
                    $session_end_date = $request['end_date'];
                    $date = new \DateTime();
                    $date_format = $date->format('Y-m-d H:i:s');
                    $this->sysdb->table('sessions')->insert(['category' => $session_category, 'status' => -1, 'alert' => 0, 'user_id' => $email[0]->id, 'winner_id' => -1, 'name' => $session_name, 'about' => $session_about, 'min_value' => $session_min_value, 'variations' => $session_ajax_variants, 'coff' => $session_ajax_coff, 'date_start' => $date_format, 'date_end' => $session_end_date]);
                    return $this->result_json(0,0);
                } else if($name == "update_session") {
                    $session_id = $request['session_id'];
                    $session_category = $request['category_id'];
                    $session_name = $request['session_name'];
                    $session_about = $request['session_about'];
                    $session_min_value = $request['session_min_value'];
                    $session_ajax_variants = $request['ajax_variants'];
                    $session_ajax_coff = $request['ajax_coff'];
                    $session_end_date = $request['end_date'];
                    $date = new \DateTime();
                    $date_format = $date->format('Y-m-d H:i:s');
                    $this->sysdb->table('sessions')->where('id', $session_id)->update(['category' => $session_category, 'alert' => 0, 'winner_id' => -1, 'name' => $session_name, 'about' => $session_about, 'min_value' => $session_min_value, 'variations' => $session_ajax_variants, 'coff' => $session_ajax_coff, 'date_start' => $date_format, 'date_end' => $session_end_date]);
                    return $this->result_json(0,0);
                } else if($name == "start_session") {
                    $session_id = $request['session_id'];
                    $this->sysdb->table('sessions')->where('id', $session_id)->update(['alert' => 0, 'status' => 1]);
                    return $this->result_json(0,0);
                } else if($name == "stop_session") {
                    $session_id = $request['session_id'];
                    $this->sysdb->table('sessions')->where('id', $session_id)->update(['alert' => 0, 'status' => 0]);
                    return $this->result_json(0,0);
                } else if($name == "result_session") {
                    $session_id = $request['session_id'];
                    $winner_id = $request['winner_id'];
                    $get_session = $this->sysdb->table('sessions')->where('id', $session_id)->get();
                    $this->sysdb->table('sessions')->where('id', $session_id)->update(['status' => 2, 'alert' => 0, 'winner_id' => $winner_id]);
                    // выдаем бабки
                    $fall_money = 0; $win_money = 0;
                    $winners = 0; $loosers = 0; $cpd = 0;
                    $get_bets = json_decode($get_session[0]->bets);
                    $get_coff = json_decode($get_session[0]->coff);
                    $date = new \DateTime();
                    $date_format = $date->format('Y-m-d H:i:s');
                    for($i = 0; $i < count($get_bets); $i++) {
                        $get_user = $this->sysdb->table('accounts')->where('id', $get_bets[$i]->user_id)->get();
                        if(count($get_user) == 1) {
                            if($get_bets[$i]->side == $winner_id) {
                                $winners++;
                                $money = $get_user[0]->balance + ($get_bets[$i]->sum * $get_coff[$winner_id]);
                                $win_money = $win_money + $get_bets[$i]->sum * $get_coff[$winner_id];
                                $cpd = $cpd + ($get_bets[$i]->sum * $get_coff[$winner_id]);
                                $this->sysdb->table('accounts')->where('email', $get_user[0]->email)->update(['balance' => $money]);
                                $this->sysdb->table('payments')->insert(['interkassa' => 'N/A', 'hash' => 'N/A', 'email' => $get_user[0]->email, 'type' => '0', 'username' => $get_user[0]->email, 'content' => "Выигрыш ставки [#{$session_id}] [side: {$winner_id}] [kof: {$get_coff[$winner_id]}]", 'sum' => $money, 'cur' => "RUB", 'datefirst' => $date_format, 'status' => 1]);
                            } else {
                                $loosers++;
                                $fall_money = $fall_money + $get_bets[$i]->sum;
                            }
                        }
                    }
                    Log::debug('FALL MONEY: '.$fall_money);
                    Log::debug('WIN MONEY: '.$win_money);
                    Log::debug('WINNERS: '.$winners.'; LOOSERS: '.$loosers);
                    $array = array();
                    $array['winners'] = $winners;
                    $array['loosers'] = $loosers;
                    $array['fall_money'] = $fall_money;
                    $array['win_money'] = $win_money;
                    $bank = $loosers - $win_money;
                    $cpd = $fall_money - $cpd;
                    $date = new \DateTime();
                    $date_format = $date->format('Y-m-d H:i:s');
                    // update com balance haben
                    $user2 = $this->sysdb->table('accounts')->where('id', $email[0]->id)->get();
                    $commission = $cpd * 0.05;
                    $money = $user2[0]->balance + $commission;
                    if($commission >= 1) {
                        $this->sysdb->table('accounts')->where('id', $email[0]->id)->update(['balance' => $money]);
                        $this->sysdb->table('payments')->insert(['email' => $user2[0]->email, 'type' => '0', 'username' => $user2[0]->email, 'content' => 'Доход с события [Н:'.$session_id.']', 'sum' => $commission, 'cur' => 'RUB', 'status' => '1', 'datefirst' => $date_format]);
                    }
                    $this->sysdb->table('services')->insert(['user_id' => $get_session[0]->user_id, 'session_id' => $session_id, 'data' => json_encode($array), 'bank' => $cpd, 'zp' => $commission, 'timeref' => $date_format]);
                    return $this->result_json(0,0, $array);
                } else if($name == "delete_session") {
                    $session_id = $request['session_id'];
                    $this->sysdb->table('sessions')->where('id', $session_id)->delete();
                    return $this->result_json(0,0);
                } else {
                    return $this->result_json(3,2);
                }
            } else {
                return $this->result_json(3,1);
            }
        } else {
            return $this->result_json(3,0);
        }
    }

}
