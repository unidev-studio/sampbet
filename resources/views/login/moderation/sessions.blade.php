@extends('panel')
@section('content')
<section class="tellarion-panel">
    
    <h2>Менеджер сессий</h2>
    
    <p>Актуальные</p>
    <ul id="actual_sessions">

    </ul>

    <h3 style="margin-top: 20px;" id="action_session">Создание сессии</h3>

    <link rel="stylesheet" href="/css/datepicker.css"/>
    <fieldset>
        <label>Категория</label>
        <select id="sel_category">
            
        </select>
        <label>Название</label>
        <input type="text" id="set_session_name" maxlength="32" value="" placeholder="..." />
        <label>Описание</label>
        <textarea id="set_session_about" maxlength="1000" placeholder="">...</textarea><br>
        <label>Варианты выбора [<span id="set_session_variant_count">0</span>]</label>
        <div class="set_session_variant">
            <input class="button-primary add_variant" type="submit" value="Добавить вариант" />
        </div>
        <label>Минимальная сумма</label>
        <input type="number" id="set_session_min_value" step="0.01" name="sum" maxlength="5" value="10.00" placeholder="10.00" />
        <label>Дата окончания</label>
        <input type="text" id="set_session_end_date" value="" />
        <div class="actions_form">
            <input class="button-primary add_session" type="submit" value="Добавить">
        </div>
    </fieldset>

    <script src="https://cdn.tiny.cloud/1/ydzgua76avstjc1p3w1sb2e7k5xsmyzfcq0r35d1fbp6ckbn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/js/datepicker.min.js"></script>

    <script>

        $(document).ready(function() {
            // prepare
            //$('.actual_sessions').html();

            $('#set_session_end_date').datepicker({
                minDate: new Date(),
                dateFormat: 'yyyy-mm-dd 00:00:00'
            });

            $('#set_session_end_date').data('datepicker');

            var variants_count = 0;

            var variants_global = 0;

            var sessions = [];

            function add_variants(value = null, value2 = null) {
                variants_count++;
                if(value == null) {
                    value = "";
                }
                if(value2 == null) {
                    value2 = "";
                }
                $('.set_session_variant').prepend(`<input type="text" id="varriant_${variants_count-1}" maxlength="32" value="${value}" placeholder="Вариант #${variants_count}" /> <input type="text" id="varriant_${variants_count-1}_coff" maxlength="32" value="${value2}" placeholder="Коэффициент #${variants_count}" />`);
                $('#set_session_variant_count').html(variants_count);
            }

            function del_variants(value = null) {
                variants_count--;
                $(`#varriant_${variants_count}`).remove();
                $(`#varriant_${variants_count}_cof`).remove();
                $('#set_session_variant_count').html(variants_count);
            }

            function clear_form(value = null) {

                console.log(`clear form`);

                $('.set_session_variant').html(`<input class="button-primary add_variant" type="submit" value="Добавить вариант" />`);

                variants_count = 0;

                $('#set_session_variant_count').html(variants_count);

                $('#delete_session').remove();

                $('#action_session').html('Создание сессии'); 
                $('#set_session_name').val('');
                $('#set_session_about').val('');
                $('#set_session_min_value').val('');
                $('#set_session_end_date').val('');

            }

            $('.add_variant').on('click', function(event) {
                event.preventDefault();
                add_variants();
            });

            $.ajax({
                type: 'POST',
                url: '/moder/get_sessions',
                dataType: 'JSON',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'), session_id: $('#session_id').html()
                },
                beforeSend: function() {
                    $('#actual_sessions').html(`Загрузка...`);
                },
                success: function(data) {
                    console.log(data);
                    if(data.success) {

                        let get_sessions_tpl = "";
                        $('#session_name').html(data.callback.name);
                        for(let i = 0; i < data.callback.length; i++) {
                            sessions[data.callback[i].id] = data.callback[i];
                            let selector_actions = ``;
                            selector_actions = (parseInt(data.callback[i].status) == -1) ? `<input class="button-primary btn-green" type="submit" data-startid="${data.callback[i].id}" value="Запустить">` : (parseInt(data.callback[i].status) == 0) ? `<input class="button-primary btn-gray" type="submit" data-changeid="${data.callback[i].id}" value="Изменить">` : (parseInt(data.callback[i].status) == 1) ? `<input class="button-primary btn-red" type="submit" data-stopid="${data.callback[i].id}" value="Остановить">` : `Сессия завершена, есть результат`;
                            get_sessions_tpl += `<li id="list_${data.callback[i].id}"><span>[cat id]: ${data.callback[i].category}</span> <span>[g-name]: ${data.callback[i].name}</span><span class="actions">${selector_actions}</span></li>`;
                        }
                        $('#actual_sessions').html(get_sessions_tpl);

                        $('[data-startid]').on('click', function() {
                            let get_id = $(this).data('startid');
                            $.ajax({
                                type: 'POST',
                                url: '/moder/start_session',
                                dataType: 'JSON',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'), session_id: get_id
                                },
                                success: function(data) {
                                    console.log(data);
                                    if(data.success) {
                                        alert('Сессия стартовала');
                                    } else {
                                        alert(data.error);
                                    }
                                }
                            });
                        });

                        $('[data-stopid]').on('click', function() {
                            let get_id = $(this).data('stopid');
                            $.ajax({
                                type: 'POST',
                                url: '/moder/stop_session',
                                dataType: 'JSON',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'), session_id: get_id
                                },
                                success: function(data) {
                                    console.log(data);
                                    if(data.success) {
                                        alert('Сессия остановлена');
                                    } else {
                                        alert(data.error);
                                    }
                                }
                            });
                        });

                        $('[data-changeid]').on('click', function() {
                            let get_id = $(this).data('changeid');
                            alert(get_id);
                            $('#action_session').html('Изменение сессии'); 
                            $('#set_session_name').val(sessions[get_id].name);
                            $('#set_session_about').val(sessions[get_id].about);
                            $('#set_session_min_value').val(sessions[get_id].min_value);
                            $('#set_session_end_date').val(sessions[get_id].date_end);
                            let get_var = JSON.parse(sessions[get_id].variations);
                            let get_coff = JSON.parse(sessions[get_id].coff);
                            for(let i = 0; i < get_var.length; i++) {
                                add_variants(get_var[i], get_coff[i]);
                            }

                            $('#delete_variant').remove();
                            $('.set_session_variant').after(`<input type="submit" class="button-primary" id="delete_variant" maxlength="32" value="Удалить" />`);

                            $('#delete_variant').on('click', function(event) {
                                event.preventDefault();
                                console.log(`telete`);
                                del_variants();
                            });

                            $('.edit_session').val('Изменить');
                            $('.edit_session').removeClass('add_session');
                            $('.add_session').off();

                            $('.actions_form').append(`<input type="submit" class="button-primary" id="delete_session" maxlength="32" value="Удалить" />`);
                            $('.actions_form').append(`<input type="text" id="set_winner" maxlength="1" value="" placeholder="Укажите ID вариации победителя" />`);
                            $('.actions_form').append(`<input class="button-primary btn-gray" type="submit" data-resultid="${get_id}" value="Результат">`);

                            $('.actions_form').append(` <input class="button-primary btn-gray edit_session" type="submit" data-resultid="${get_id}" value="Изменить">`);

                            $('[data-resultid]').on('click', function() {
                                let get_id = $(this).data('resultid');
                                $.ajax({
                                    type: 'POST',
                                    url: '/moder/result_session',
                                    dataType: 'JSON',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content'), session_id: get_id, winner_id: $('#set_winner').val()
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        if(data.success) {
                                            alert('Результат выявлен');
                                        } else {
                                            alert(data.error);
                                        }
                                    }
                                });
                            });

                            let varriants = [];
                            let coff = [];

                            for(let i = 0; i < variants_count; i++) {
                                varriants[i] = $(`#varriant_${i}`).val();
                                coff[i] = $(`#varriant_${i}_coff`).val()
                            }

                            varriants = JSON.stringify(varriants);
                            coff = JSON.stringify(coff);

                            $('.add_session').off();

                            $('.edit_session').on('click', function(event) {
                                event.preventDefault();
                                $.ajax({
                                    type: 'POST',
                                    url: '/moder/update_session',
                                    dataType: 'JSON',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content'), session_id: get_id, category_id: $('#sel_category option:selected').val(), session_name: $('#set_session_name').val(), session_about: $('#set_session_about').val(), session_min_value: $('#set_session_min_value').val(), ajax_variants: varriants, ajax_coff: coff, end_date: $('#set_session_end_date').val()
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        if(data.success) {
                                            alert('Сессия обновлена');
                                        } else {
                                            alert(data.error);
                                        }
                                    }
                                });
                            });

                            $('#delete_session').on('click', function(event) {
                                event.preventDefault();
                                $.ajax({
                                    type: 'POST',
                                    url: '/moder/delete_session',
                                    dataType: 'JSON',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content'), session_id: get_id
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        if(data.success) {
                                            alert('Сессия удалена');
                                            $(`#list_${get_id}`).remove();
                                            clear_form();
                                        } else {
                                            alert(data.error);
                                        }
                                    }
                                });
                            });
                        });
                    } else {
                        $('#actual_sessions').html(data.error);
                    }
                }
            });

            $.ajax({
                type: 'POST',
                url: '/use/get_category2',
                dataType: 'JSON',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    if(data.success) {
                        let get_categoryes_tpl = "";
                        for(let i = 0; i < data.callback.length; i++) {
                            get_categoryes_tpl += `<option value="${data.callback[i].id}">${data.callback[i].name}</option>`;
                        }
                        $('#sel_category').html(get_categoryes_tpl);

                        $('.add_session').on('click', function(event) {
                            event.preventDefault();

                            console.log($('#varriant_0').val());

                            let varriants = [];
                            let coff = [];

                            for(let i = 0; i < variants_count; i++) {
                                varriants[i] = $(`#varriant_${i}`).val();
                                coff[i] = $(`#varriant_${i}_coff`).val()
                            }

                            varriants = JSON.stringify(varriants);
                            coff = JSON.stringify(coff);

                            $.ajax({
                                type: 'POST',
                                url: '/moder/add_session',
                                dataType: 'JSON',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'), category_id: $('#sel_category option:selected').val(), session_name: $('#set_session_name').val(), session_about: $('#set_session_about').val(), session_min_value: $('#set_session_min_value').val(), ajax_variants: varriants, ajax_coff: coff, end_date: $('#set_session_end_date').val()
                                },
                                success: function(data) {
                                    console.log(data);
                                    if(data.success) {
                                        alert('Сессия создана');
                                    } else {
                                        alert(data.error);
                                    }
                                }
                            });
                        });
                    } else {
                        $('#sel_category').html(data.error);
                    }
                }
            });

        });

    </script>
</section>
@endsection