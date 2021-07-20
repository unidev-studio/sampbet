@extends('welcome')
@section('content')

<section class="express">
    
    @if($code != 404)

    <div id="modal" class="modal">
        <h2></h2>
        <p></p>
        <label></label>
        <select id="sel_var">
            
        </select>
        <label></label>
        <input type="number" id="set_bet_sum" step="0.01" name="sum" maxlength="5" value="10.00" placeholder="10.00" />
        <div class="actions_form">
            <input class="button-primary add_bet" type="submit" value="Поставить">
        </div>
    </div>

    <div id="modal2" class="modal">
        <p></p>
    </div>

    <div class="container-2 tc">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

        <div class="row">
            <div class="block-session">
                <h2>{{ $category->name }}</h2>
                <h3>#<span id="session_id">{{ $session->id }}</span> <span id="session_name">{{ $session->name }}</span></h3>
                <p>{!! $session->about !!}</p>
                <div class="session-info">
                    <p>Загрузка...</p>
                </div>
            </div>
            <div class="block-process">
                <h2>Процесс</h2>
                <div class="process_info" style="min-height: 80%; max-height: 80%; display: scroll;">
                    <p>Загрузка_1...</p>
                </div>
                @if($auth == 1)
                <div class="process_action" style="padding-top: 20px;">
                    <p>Загрузка_2...</p>
                </div>
                @else
                <p>Необходима <a href="https://samp-bet.ru/panel">авторизация</a></p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="block-chat">
                <h2>Чат</h2>
                <div class="messages">

                </div>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="block-chat2">
                @if($auth == 1)
                <label>Сообщение в чат</label>
                <span id="message_status"></span>
                <input type="text" placeholder="" id="message" style="width: 350px;" maxlength="100">
                <input class="button-primary btn-send-chat" type="submit" value="Отправить">
                @else
                <p style="padding-top: 20px;">Для доступа к данному контенту, необходима авторизация</p>
                @endif
            </div>
        </div>

        <!--
        <div class="row">
            <div class="block-other">
                <div class="online_session">

                </div>
            </div>
        </div>
        -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <script>
        $(document).ready(function() {

            var timers = [];
            var session = [];

            function get_date_end(sessions) {

                let format = ``;
                let first_date = new Date(sessions.date_start).getTime();
                let second_date = new Date(sessions.date_end).getTime();
                let actual_date = new Date();
                let unixtime = second_date - actual_date;
                $d = new Date(unixtime);
                let hours = $d.getHours()-3;
                let mins = $d.getMinutes();
                let secs = $d.getSeconds();
                format = `H: ${hours}; M: ${mins}; S: ${secs}`;
                return format;

            }

            function update_online() {

                let online_user_list = ``;

                $('.online_session').html(online_user_list);
            }

            function update_chat() {

                $.ajax({
                    type: 'POST',
                    url: '/use/get_chat',
                    dataType: 'JSON',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), session_id: $('#session_id').html()
                    },
                    beforeSend: function() {
                        $('.messages').html(`Загрузка...`);
                    },
                    success: function(data) {
                        console.log(data);
                        if(data.success) {
                            let get_messages_tpl = "";
                            let username = ``;
                            for(let i = 0; i < data.callback.length; i++) {
                                username = (data.callback[i].username == "N/A") ? `user${data.callback[i].user_id}` : data.callback[i].username;
                                get_messages_tpl += `<div class="message" data-message-id="${data.callback[i].id}"><span>[${data.callback[i].date_post}] ${username}:</span> <span>${data.callback[i].message}</span></div>`;
                            }
                            $('.messages').html(get_messages_tpl);
                        } else {
                            $('.messages').html(data.error);
                        }
                    }
                });

            }

            function update_session() {
                
                $.ajax({
                    type: 'POST',
                    url: '/use/get_session',
                    dataType: 'JSON',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), session_id: $('#session_id').html()
                    },
                    success: function(data) {
                        console.log(data);
                        if(data.success) {
                            session[0] = data.callback;
                            let get_session_tpl = "";
                            $('#session_name').html(data.callback.name);
                            let get_var = JSON.parse(data.callback.variations);
                            let get_coff = JSON.parse(data.callback.coff);
                            let get_var_tpl = ``;
                            let get_coff_tpl = ``;
                            let count_side = [];
                            for(let i = 0; i < get_var.length; i++) {
                                count_side[i] = 0;
                                if(get_var.length-1 != i) {
                                    get_var_tpl += `${get_var[i]} & `;
                                    get_coff_tpl += `${get_coff[i]} & `;
                                } else {
                                    get_var_tpl += `${get_var[i]}`;
                                    get_coff_tpl += `${get_coff[i]}`;
                                }
                            }

                            let format = (data.callback.status != 2) ? get_date_end(session[0]) : "GG WP!";
                            let status = (data.callback.status == -1) ? "Сессия создана" : (data.callback.status == 1) ? "Прием ставок" : (data.callback.status == 0) ? "Ожидание" : "Результат";
                            let get_bets = JSON.parse(data.callback.bets);
                            let get_bets_count = get_bets.length;

                            let get_bets_tpl = ``;
                            
                            if(get_bets_count >= 1) {
                                for(let i = 0; i < get_bets_count; i++) {
                                    let get_var_name = get_var[get_bets[i].side];
                                    count_side[get_bets[i].side]++;
                                    get_bets_tpl += `u_${get_bets[i].user_id} - ${get_bets[i].sum} RUB. <br> сторона: ${get_var_name}<br>`;
                                }
                                $('.process_info').html(get_bets_tpl);
                            } else {
                                $('.process_info').html(`Ставок еще нет`);
                            }

                            get_session_tpl = `
                                <p>Доступные вариации: <span id="session_var">${get_var_tpl}</span></p>
                                <p>Состояние сессии: <span id="session_status">${status}</span></p>
                                <p>Окончание сессии: <span id="session_end">${format}</span></p>
                                <p>Сделано ставок: <span id="session_bets">${get_bets_count}</span></p>
                                <p>Коэффициенты: ${get_coff_tpl}</p>
                            `
                            timers[0] = setInterval(function() {
                                let format = (data.callback.status != 2) ? get_date_end(session[0]) : "GG WP!";
                                $('#session_end').html(format);
                            }, 1000);
                            $('.session-info').html(get_session_tpl);

                            if(data.callback.status == 1) {

                                $('.process_action').html('<input type="submit" id="set_bet" class="button-primary add_variant" type="submit" value="Поставить ставку" />');

                                $('#set_bet').on('click', function(event) {
                                    event.preventDefault();
                                    console.log('Bet Active');
                                    $('.modal h2').html('Поставить ставку');
                                    $('.modal label').eq(0).html('Выберите сторону');
                                    let get_var_tpl_2 = ``;
                                    for(let i = 0; i < get_var.length; i++) {
                                        get_var_tpl_2 += `<option value="${i}">${get_var[i]} [к: ${get_coff[i]}]</option>`;
                                    }
                                    $('#sel_var').html(get_var_tpl_2);
                                    $('.modal label').eq(1).html('Введите сумму');
                                    $("#modal").modal({
                                        fadeDuration: 1000,
                                        fadeDelay: 0.50
                                    });

                                    $('.add_bet').off();

                                    $('.add_bet').on('click', function(event) {
                                        event.preventDefault();
                                        console.log('test');
                                        $.ajax({
                                            type: 'POST',
                                            url: '/use/add_bet',
                                            dataType: 'JSON',
                                            data: {
                                                _token: $('meta[name="csrf-token"]').attr('content'), session_id: $('#session_id').html(), sum: $('#set_bet_sum').val(), side: $('#sel_var option:selected').val()
                                            },
                                            success: function(data) {
                                                console.log(data);
                                                if(data.success) {
                                                    alert('Ставка поставлена');
                                                } else {
                                                    alert(data.error);
                                                }
                                            }
                                        });
                                    });

                                });

                            } else if(data.callback.status == 2) {
                                let get_var_name = get_var[data.callback.winner_id];
                                $('.process_action').html(`Победа за ${get_var_name}`);
                            } else {
                                $('.process_action').html('<p>Ставки не принимаются</p>');
                            }

                        } else {
                            $('.session-info').html(data.error);
                        }
                    }
                });

            }

            update_session();

            setInterval(function() {
                update_session();
            }, 10000);

            setInterval(function() {
                update_chat();
            }, 30000);

            update_chat();

            $('.btn-send-chat').on('click', function(event) {

                event.preventDefault();

                console.log($('.text_message').val());

                $.ajax({
                    type: 'POST',
                    url: '/use/send_chat',
                    dataType: 'JSON',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), session_id: $('#session_id').html(), message: $('#message').val()
                    },
                    success: function(data) {
                        console.log(data);
                        if(data.success) {
                            alert(`Сообщение отправлено`);
                            update_chat();
                        } else {
                            alert(data.error);
                        }
                    }
                });

            });

        });
    </script>
    @else
    <div class="container tc">
        Ошибка #{{ $code }}
    </div>
    @endif
</section>
@endsection