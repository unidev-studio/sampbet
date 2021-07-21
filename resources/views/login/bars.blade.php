@extends('panel')
@section('content')

@if($type == 0)

<section class="express">
    <h2>Информация о целевых сборах</h2>
    @if($rope == 0)
    <p>Первым делом, необходимо связать <a href="/panel/settings">Twitch/YouTube</a> аккаунт</p>
    @elseif($rope == 1)
    <p>Собирайте средства на достижение творческих целей, улучшайте вашу студию или же жизнь?</p>
    <button id="target_new" class="button button-outline">Добавить новую цель</button><br>
    {{ $errors->first('h_name') }}
    {{ $errors->first('h_target_end') }}
    {{ $errors->first('h_target_start') }}
    {{ $errors->first('h_date_end') }}
    {{ session('system') }}
    <div class="target_new" style="display: none;">
        <link rel="stylesheet" href="/css/datepicker.css"/>
        <form method="post" action="/bars/0" enctype="multipart/form-data">
            <fieldset>
                <label>Заголовок целевого сбора</label>
                <input type="text" name="h_name" maxlength="32" value="" placeholder="Придумайте цель для сбора" />
                <label>Окончательная сумма сбора</label>
                <input type="number" step="0.01" name="h_target_end" maxlength="5" value="" placeholder="1000.00" />
                <label>Начальная сумма сбора</label>
                <input type="number" step="0.01" name="h_target_start" maxlength="5" value="" placeholder="0.00" />
                <label>Собрать до даты</label>
                <input type="text" id="calendar" name="h_date_end" value="" />
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="button-primary" type="submit" value="Создать цель">
            </fieldset>
        </form>
    </div>

    <div class="bars">
        {!! $bars !!}
    </div>
    
    <script src="/js/datepicker.min.js"></script>
    <script>
        
        $('#calendar').datepicker({
            minDate: new Date(),
            dateFormat: 'yyyy-mm-dd'
        });
        $('#calendar').data('datepicker');
        $('#target_new').on('click', function(event) {
            if($('.target_new').attr('style') == "display:block;") {
                $('.target_new').attr('style', 'display:none;');
            } else {
                $('.target_new').attr('style', 'display:block;');
            }
        });

    </script>
    @endif
</section>

@elseif($type == 1)

<section class="express">
    <h2>Редактирование целевого сбора</h2>
    <form method="post" action="/bars/2" enctype="multipart/form-data">
    </form>
</section>

@endif



@endsection