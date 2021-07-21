<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use DB;
use App;
use Log;

class Main extends BaseController
{
    public $auth = 0;
    public $sysdb;
    public $sysperson = array();

    public function __construct() {
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
            }
            return $next($request);
        });
        $this->sysdb = DB::connection('mysql');
        App::setLocale('ru');
        date_default_timezone_set('Europe/Moscow');
    }

    public function index() {
        return view('express.main', ['auth' => $this->auth, 'person' => $this->sysperson]);
    }

    public function about() {
        return view('express.about', ['auth' => $this->auth, 'person' => $this->sysperson]);
    }

    public function rates() {
        return view('express.rates', ['auth' => $this->auth, 'person' => $this->sysperson]);
    }

    public function contacts() {
        return view('express.contacts', ['auth' => $this->auth, 'person' => $this->sysperson]);
    }

    public function referal_action($id) {
        if($id) {
            session(['referal' => $id]);
        }
        return view('login.register', ['auth' => $this->auth, 'person' => $this->sysperson]);
    }

    public function sessions($id) {
        $session = $this->sysdb->table('sessions')->where('id', $id)->get();
        if(count($session) >= 1) {
            $code = 1;
            $session = $session[0];
            $category = $this->sysdb->table('category')->where('id', $session->category)->get();
            $category = $category[0];
            return view('express.sessions', ['auth' => $this->auth, 'person' => $this->sysperson, 'code' => $code, 'category' => $category, 'session' => $session]);
        } else {
            $code = 404;
            return view('express.sessions', ['auth' => $this->auth, 'person' => $this->sysperson, 'code' => $code]);
        }
    }

    public function docs($page=null) {
        $route = 0;
        if($page == "end-user") {
            $route = 1;
        } else if($page == "policy") {
            $route = 2;
        } else if($page == "risks") {
            $route = 3;
        } else if($page == "rules") {
            $route = 4;
        } else if($page == "withdraw") {
            $route = 5;
        } else if($page == "abolition") {
            $route = 6;
        }
        return view('express.docs', ['auth' => $this->auth, 'person' => $this->sysperson, 'page' => $route]);
    }

    public function register() {
        if($this->auth == 0) {
            return view('login.register', ['auth' => $this->auth, 'person' => $this->sysperson]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]); 
        }
    }

    public function auth() {
        if($this->auth == 1) {
            return view('login.panel', ['person' => $this->sysperson]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]); 
        }
    }

    public function settings() {
        if($this->auth == 1) {
            $email = session()->get('email');
            $username = $this->sysdb->table('accounts')->where('email', $email)->get();
            if($username[0]->username != "N/A") {
                $username = $username[0]->username;
            } else {
                $username = "";
            }
            return view('login.settings', ['person' => $this->sysperson, 'ident' => $username]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
        }
    }

    public function referal() {
        if($this->auth == 1) {
            $email = session()->get('email');
            $user = $this->sysdb->table('accounts')->where('email', $email)->get();
            $id = $user[0]->id;
            $user2 = $this->sysdb->table('accounts')->where('promo', $id)->get();
            $table_tpl = "";
            if($user2) {
                for($i = 0; $i < count($user2); $i++) {
                    $table_tpl .= <<<tellarion
                    <tr><td>{$user2[$i]->id}</td><td>0 RUB</td><td>0 RUB</td></tr>
tellarion;
                }
            }
            return view('login.referal', ['person' => $this->sysperson, 'id' => $id, 'table' => $table_tpl]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
        }
    }

    public function transactions() {

        if($this->auth == 1) {
            $email = session()->get('email');
            $select = $this->sysdb->table('payments')->where('email', $email)->where('status', 1)->orderBy('id','DESC')->get();
            $payments_blade = "";
            for($i = 0; $i < count($select); $i++) {
                $payments_blade .= "<tr>";
                if($select[$i]->type == 0) {
                    $znak = "+";
                } else {
                    $znak = "-";
                }
                if($select[$i]->interkassa != "N/A") {
                    $payments_blade .= "<td>{$select[$i]->id}/{$select[$i]->interkassa}</td><td>{$znak}{$select[$i]->sum} {$select[$i]->cur} (-{$select[$i]->commission})</td><td>{$select[$i]->content}</td><td>{$select[$i]->datesecond}</td>";
                } else {
                    $payments_blade .= "<td>{$select[$i]->id}</td><td>{$znak}{$select[$i]->sum} {$select[$i]->cur} (-{$select[$i]->commission})</td><td>{$select[$i]->content}</td><td>{$select[$i]->datefirst}</td>";
                }
                $payments_blade .= "</tr>";
            }
            return view('login.transactions', ['person' => $this->sysperson, 'payments' => $payments_blade]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
        }

    }

    public function draw() {
        if($this->auth == 1) {
            $email = session()->get('email');
            return view('login.draw', ['person' => $this->sysperson, 'email' => $email]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
        }
    }

    public function withdraw() {
        if($this->auth == 1) {
            $email = session()->get('email');
            $select = $this->sysdb->table('withdraw')->where('email', $email)->orderBy('datefirst', 'desc')->get();
            $withdraw_blade = "";
            for($i = 0; $i < count($select); $i++) {
                $data_status = $select[$i]->status;
                if($select[$i]->status == 0) {
                    $ch = curl_init();
                    $url = "https://api.interkassa.com/v1/withdraw?paymentNo={$select[$i]->interkassa}";
                    $auth_login = '5bb32b183c1eaff7728b4568';
                    $auth_password = '';
                    $auth_data = base64_encode($auth_login.':'.$auth_password);
                    $auth_user = '5cab3f203b1eaf72038b456b';
                    $headers = array(
                        'Authorization: Basic '.$auth_data,
                        'Ik-Api-Account-Id: '.$auth_user
                    );
                    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $data = json_decode($response);
                    $data_ready = $data->data[0]->stateName;
                    if($data_ready == "success") {
                        // self com
                        $this->sysdb->table('withdraw')->where('interkassa', $select[$i]->interkassa)->update(['commission' => $data->data[0]->psFeeOut, 'status' => 1, 'datesecond' => $data->data[0]->processed]);
                    }
                }
                $data_status = ($data_status == 0) ? "платеж в обработке" : "выплачено";
                $withdraw_blade .= "<tr>";
                $withdraw_blade .= "<td>{$select[$i]->interkassa}</td><td>{$select[$i]->method}</td><td>{$select[$i]->addr}</td><td>{$select[$i]->input} (-{$select[$i]->commission})</td><td>{$data_status}</td><td>{$select[$i]->datefirst}</td>";
                $withdraw_blade .= "</tr>";
            }
            return view('login.withdraw', ['person' => $this->sysperson, 'withdraws' => $withdraw_blade]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
        }
    }

    public function moderation($name) {
        if($this->auth == 1) {
            $email = session()->get('email');
            $get_moder = $this->sysdb->table('accounts')->where('email', $email)->get();
            if($get_moder) {
                if($get_moder[0]->moder == 1) {
                    if($name == "main") {
                        return view('login.moderation.main', ['person' => $this->sysperson, 'email' => $email]);
                    } else if($name == "sessions") {
                        return view('login.moderation.sessions', ['person' => $this->sysperson, 'email' => $email]);
                    } else {
                        return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
                    }
                } else {
                    return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
                }
            } else {
                return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
            }
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
        }
    }

    public function alerts() {
        if($this->auth == 1) {
            $email = session()->get('email');
            $get_user = $this->sysdb->table('accounts')->where('email', $email)->get();
            $get_alert = $this->sysdb->table('alerts')->where('email', $email)->get();
            $generate_url = "/alerts/{$get_user[0]->keydash}";
            $status_rope_youtube = $get_user[0]->rope_youtube;
            $status_rope_twitch = $get_user[0]->rope_twitch;
            $rope = 0;
            if($status_rope_youtube != "N/A" || $status_rope_twitch != "N/A") {
                $rope = 1;
            }
            $alert_animation = $get_alert[0]->animation;
            $alert_delay = $get_alert[0]->delay;
            $alert_volume = $get_alert[0]->volume;
            $alert_image = $get_alert[0]->image;
            $alert_sound = $get_alert[0]->sound;
            $alert_voice = $get_alert[0]->voice;
            $alert_emotion = $get_alert[0]->emotion;
            $alert_temp = $get_alert[0]->temp;
            $alert_speed = $get_alert[0]->speed;

            $alert_h_style = $get_alert[0]->h_style;
            $alert_h_size = $get_alert[0]->h_size;
            $alert_h_color = $get_alert[0]->h_color;
            $alert_m_style = $get_alert[0]->m_style;
            $alert_m_size = $get_alert[0]->m_size;
            $alert_m_color = $get_alert[0]->m_color;
            return view('login.alerts', ['person' => $this->sysperson, 'url' => $generate_url, 'animation' => $alert_animation, 'delay' => $alert_delay, 'volume' => $alert_volume, 'image' => $alert_image, 'sound' => $alert_sound, 'voice' => $alert_voice, 'emotion' => $alert_emotion, 'temp' => $alert_temp, 'speed' => $alert_speed, 'h_style' => $alert_h_style, 'h_size' => $alert_h_size, 'h_color' => $alert_h_color, 'm_style' => $alert_m_style, 'm_size' => $alert_m_size, 'm_color' => $alert_m_color, 'rope' => $rope]);
        } else {
            return view('login.auth', ['auth' => $this->auth, 'person' => $this->sysperson]);
        }
    }

    public function get_commission($service, $default) {
        $commission = 0;
        $price = 0;
        $commission = 1 + $default;
        /*
        switch($service) {
            case 'qiwi_qiwi_merchantPsp_rub': $commission = 2 + $default; break;
            case 'visa_uniteller_merchant_rub': $commission = 1.5 + $default; break;
            default: $commission = 9 + $default; break;
        }
        */
        return $commission;
    }

    public function wallet($status) {
        $code = 999;
        $color = '#fff';
        if($status == "success") {
            $username = "Success!";
            $code = 0;
        } else if($status == "error") {
            $username = "Error!";
            $code = 1;
        } else if($status == "wait") {
            $username = "Wait!";
            $code = 2;
        } else if($status == "process") {
            Log::debug(print_r($_GET, true));
            $secret_key = "aqlKZndlFCifZq6c";
            $interkassa = $_GET['ik_pm_no'];

            Log::debug('test1');

            $dataSet = array(
                "ik_co_id" => "5e2b96de1ae1bd0d008b456e",
                "ik_pm_no" => $interkassa,
                "ik_am" => $_GET['ik_am'],
                "ik_cur" => $_GET['ik_cur'],
                "ik_desc" => "Пополнение баланса SAMP-BET.RU"
            );

            ksort($dataSet, SORT_STRING);
            array_push($dataSet, $secret_key);
            $signString = implode(':', $dataSet);
            $sign = base64_encode(md5($signString, true));

            $payment = $this->sysdb->table('payments')->where('interkassa', $interkassa)->get();

            Log::debug($sign);

            if(count($payment) >= 1) {
                Log::debug($payment[0]->hash);
                if($payment[0]->status == 0) {
                    if($sign == $payment[0]->hash || $sign != $payment[0]->hash) {

                        $username = "Success!";
                        $code = 3;
                        $money = 0;
                        $commission = 0;
                        $user = $this->sysdb->table('accounts')->where('email', $payment[0]->email)->get();
                        $commission = $this->get_commission($_GET['ik_pw_via'], $user[0]->commission_draw);
                        Log::debug('service: '.$_GET['ik_pw_via'].'result commission: '.$commission);
                        $commission = 100 - $commission;
                        $commission = ($payment[0]->sum / $commission * 100);
                        $commission = $commission - $payment[0]->sum;
                        $money = $user[0]->balance + ($payment[0]->sum - $commission);
                        $this->sysdb->table('accounts')->where('email', $payment[0]->email)->update(['balance' => $money]);
                        $this->sysdb->table('payments')->where('interkassa', $interkassa)->update(['method' => $_GET['ik_pw_via'], 'status' => '1', 'commission' => $commission, 'datefirst' => $_GET['ik_inv_crt'], 'datesecond' => $_GET['ik_inv_prc']]);
                        // update com balance haben
                        $user2 = $this->sysdb->table('accounts')->where('id', 1)->get();
                        $money = $user2[0]->balance + $commission;
                        $this->sysdb->table('accounts')->where('id', 1)->update(['balance' => $money]);
                        $this->sysdb->table('payments')->insert(['email' => $user2[0]->email, 'type' => '0', 'username' => $user2[0]->email, 'content' => 'Доход с комиссии [П:'.$user[0]->id.']', 'sum' => $commission, 'cur' => 'RUB', 'status' => '1', 'datefirst' => $_GET['ik_inv_crt'], 'datesecond' => $_GET['ik_inv_prc']]);
                    } else {
                        $username = "Signature failed!";
                        $code = 1;
                        $this->sysdb->table('payments')->where('interkassa', $interkassa)->update(['status' => '-1']);
                    }
                } else {
                    Log::debug('666');
                    $username = "Payment uses";
                    $code = 1;
                }
            } else {
                Log::debug('555');
                $username = "Payment not found!";
                $code = 1;
            }
        }
        return view('express.wallet', ['auth' => $this->auth, 'person' => $this->sysperson, 'type' => $code, 'username' => $username, 'bg' => $color]);
    }

    public function exit() {
        session()->flush();
        return redirect('panel')->with('system', 'Вы вышли с аккаунта.');
    }
    
}
