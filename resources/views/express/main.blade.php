@extends('welcome')
@section('content')<section class="express">
                <div class="container-2 tc">

                    <div class="row">
                        <div class="block-other" style="margin-top: 0px; margin-bottom: 30px; text-align: center; max-height: inherit;">
                            <p>Мы ВКонтакте: <a href="https://vk.com/samp_bet_ru">https://vk.com/samp_bet_ru</p>
                            <p>Конференция участников ВК: <a href="https://vk.me/join/AJQ1d9uLfRZswBDWXnjVnGFk">https://vk.me/join/AJQ1d9uLfRZswBDWXnjVnGFk (оповещения ставок)</a></p>
                            <p>Расписание работы: 14:00 - 21:00 (MSK)</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="block-category">
                            <h2>Категории</h2>
                            <ul id="block-category-items">
                            </ul>
                        </div>
                        <div class="block-bets">
                            <h2>Сессии</h2>
                            <ul id="block-sessions-items">
                            </ul>
                        </div>

                        <script>

                            var category = [];
                            var sessions = [];

                            $(document).ready(function() {

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
                                    if(actual_date <= second_date) {
                                        format = `H: ${hours}; M: ${mins}; S: ${secs}`;
                                        return format;
                                    } else {
                                        format = `завершено`;
                                        return format;
                                    }
                                }

                                function loader () {
                                    $.ajax({
                                        type: 'POST',
                                        url: '/use/get_category',
                                        dataType: 'JSON',
                                        data: {
                                            _token: $('meta[name="csrf-token"]').attr('content')
                                        },
                                        beforeSend: function() {
                                            $('#block-category-items').html(`Загрузка...`);
                                            $('#block-sessions-items').html(`Необходимо выбрать категорию`);
                                        },
                                        success: function(data) {
                                            console.log(data);
                                            if(data.success) {
                                                var sessions = [];
                                                var timers = [];
                                                for(let i = 0; timers.length; i++) {
                                                    clearInterval(timers[i]);
                                                }
                                                let generate_tpl = "";
                                                for(let i = 0; i < data.callback.length; i++) {
                                                    category[i] = data.callback[i];
                                                    generate_tpl += `<li data-category-id="${data.callback[i].id}">${data.callback[i].name}</li>`;
                                                }
                                                $('#block-category-items').html(generate_tpl);

                                                $('[data-category-id]').on('click', function(event) {
                                                    event.preventDefault();
                                                    let get_id = $(this).data('category-id');
                                                    console.log(`get id ${get_id}`);
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: '/use/get_sessions',
                                                        dataType: 'JSON',
                                                        data: {
                                                            _token: $('meta[name="csrf-token"]').attr('content'), session_id: get_id
                                                        },
                                                        beforeSend: function() {
                                                            $('#block-sessions-items').html(`Поиск...`);
                                                        },
                                                        success: function(data) {
                                                            console.log(data);
                                                            if(data.success) {
                                                                let generate_tpl = "";
                                                                let status = "";
                                                                for(let i = 0; i < data.callback.length; i++) {
                                                                    sessions[i] = data.callback[i];
                                                                    status = (data.callback[i].status == -1) ? "Сессия создана" : (data.callback[i].status == 1) ? "Прием ставок" : (data.callback[i].status == 0) ? "Ожидание" : "Результат";
                                                                    date_one = data.callback[i].date_start;
                                                                    date_two = data.callback[i].date_end;
                                                                    let format = get_date_end(sessions[i]);
                                                                    generate_tpl += `<li data-session-id="${data.callback[i].id}"><span class="info"><a href="/sessions/${data.callback[i].id}">[#${data.callback[i].id}] ${data.callback[i].name} [${status}] <br> [Конец: ${date_two}] <br> [ До конца осталось: <span id="timer_${data.callback[i].id}">${format}</span> ]</a></span></li>`;
                                                                    timers[i] = setInterval(function() {
                                                                        let format = get_date_end(sessions[i]);
                                                                        $('#timer_' + sessions[i].id).html(format);
                                                                    }, 1000);
                                                                }
                                                                console.log(generate_tpl);
                                                                $('#block-sessions-items').html(generate_tpl);
                                                            } else {
                                                                $('#block-sessions-items').html(data.error);
                                                            }
                                                        }
                                                    });
                                                });
                                            } else {
                                                $('#block-category-items').html(data.error);
                                            }
                                        }
                                    });
                                }

                                loader();
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="block-other online-users" style="margin-top: 30px; margin-bottom: 0px; text-align: justify; max-height: inherit;">
                                Test
                        </div>
                        <script>
                            $(document).ready(function() {

                                $.ajax({
                                    type: 'POST',
                                    url: '/use/get_online',
                                    dataType: 'JSON',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    beforeSend: function() {
                                        $('.online-users').html(`Загрузка списка онлайна...`);
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        if(data.callback >= 1) {
                                            let online_tpl = ``;
                                            let online_count = 0;
                                            for(let i = 0; i < data.callback.length; i++) {
                                                let get_username = (data.callback[i].username != "N/A") ? data.callback[i].username : `u${data.callback[i].id}`;
                                                let get_status_1 = (data.callback[i].id == 1) ? "<span style='color: red;'> [A]" : (data.callback[i].moder == 1) ? "<span style='color: green;'> [M] " : "";
                                                let get_status_2 = (data.callback[i].moder == 1) ? `[${data.callback[i].moder_catid}] </span>` : "";
                                                online_tpl += `${get_status_1} ${get_username} ${get_status_2}`;
                                                online_count++;
                                            }
                                            $('.online-users').html(`Зарегистрированных пользователей в сети: ${online_count}<br>`);
                                            $('.online-users').append(online_tpl);
                                        } else {
                                            $('.online-users').html(`Пользователей, сейчас нет в сети`);
                                        }
                                    }
                                });

                            });
                        </script>
                    </div>
            </section>
@endsection