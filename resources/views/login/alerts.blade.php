@extends('panel')
@section('content')
<section class="tellarion-panel">
    <h2>Информация об оповещениях</h2>
    @if($rope == 0)
    <p>Первым делом, необходимо связать <a href="/panel/settings">Twitch/YouTube</a> аккаунт</p>
    @elseif($rope == 1)
    <p>Настройте вывод на прямых трансляциях и оповещайте своих зрителей. Вам предоставлена ссылка, используйте ее в своих приложениях (OBS, XSplit, etc...)</p>
    <input type="text" value="{{ $url }}" disabled />
    <form method="post" action="/alerts/0">
        {{ session('system2') }}
        <fieldset>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="button-primary" type="submit" value="Тестовое оповещение">
        </fieldset>
    </form>
    <h4>Настройки оповещения</h4>
    <form method="post" action="/alerts/1" enctype="multipart/form-data">
        <fieldset>
            {{ $errors->first('animation-fade') }}
            {{ $errors->first('delay') }}
            {{ $errors->first('volume') }}
            {{ $errors->first('image') }}
            {{ $errors->first('sound') }}
            {{ $errors->first('voice') }}
            {{ $errors->first('emotion') }}
            {{ $errors->first('temp') }}
            {{ $errors->first('speed') }}
            {{ session('system') }}
            <label>Анимация появления</label>
            <select id="sel_animation-fade" name="animation-fade">
                <option value="bounce">bounce</option>
                <option value="flash">flash</option>
                <option value="pulse">pulse</option>
                <option value="shake">shake</option>
                <option value="headShake">headShake</option>
                <option value="swing">swing</option>
                <option value="tada">tada</option>
                <option value="wobble">wobble</option>
                <option value="jello">jello</option>
                <option value="bounceIn">bounceIn</option>
                <option value="bounceInDown">bounceInDown</option>
                <option value="bounceInLeft">bounceInLeft</option>
                <option value="bounceInRight">bounceInRight</option>
                <option value="bounceInUp">bounceInUp</option>
                <option value="bounceOut">bounceOut</option>
                <option value="bounceOutDown">bounceOutDown</option>
                <option value="bounceOutLeft">bounceOutLeft</option>
                <option value="bounceOutRight">bounceOutRight</option>
                <option value="bounceOutUp">bounceOutUp</option>
                <option value="fadeIn">fadeIn</option>
                <option value="fadeInDown">fadeInDown</option>
                <option value="fadeInDownBig">fadeInDownBig</option>
                <option value="fadeInLeft">fadeInLeft</option>
                <option value="fadeInLeftBig">fadeInLeftBig</option>
                <option value="fadeInRight">fadeInRight</option>
                <option value="fadeInRightBig">fadeInRightBig</option>
                <option value="fadeInUp">fadeInUp</option>
                <option value="fadeInUpBig">fadeInUpBig</option>
                <option value="fadeOut">fadeOut</option>
                <option value="fadeOutDown">fadeOutDown</option>
                <option value="fadeOutDownBig">fadeOutDownBig</option>
                <option value="fadeOutLeft">fadeOutLeft</option>
                <option value="fadeOutLeftBig">fadeOutLeftBig</option>
                <option value="fadeOutRight">fadeOutRight</option>
                <option value="fadeOutRightBig">fadeOutRightBig</option>
                <option value="fadeOutUp">fadeOutUp</option>
                <option value="fadeOutUpBig">fadeOutUpBig</option>
                <option value="flipInX">flipInX</option>
                <option value="flipInY">flipInY</option>
                <option value="flipOutX">flipOutX</option>
                <option value="flipOutY">flipOutY</option>
                <option value="lightSpeedIn">lightSpeedIn</option>
                <option value="lightSpeedOut">lightSpeedOut</option>
                <option value="rotateIn">rotateIn</option>
                <option value="rotateInDownLeft">rotateInDownLeft</option>
                <option value="rotateInDownRight">rotateInDownRight</option>
                <option value="rotateInUpLeft">rotateInUpLeft</option>
                <option value="rotateInUpRight">rotateInUpRight</option>
                <option value="rotateOut">rotateOut</option>
                <option value="rotateOutDownLeft">rotateOutDownLeft</option>
                <option value="rotateOutDownRight">rotateOutDownRight</option>
                <option value="rotateOutUpLeft">rotateOutUpLeft</option>
                <option value="rotateOutUpRight">rotateOutUpRight</option>
                <option value="hinge">hinge</option>
                <option value="jackInTheBox">jackInTheBox</option>
                <option value="rollIn">rollIn</option>
                <option value="rollOut">rollOut</option>
                <option value="zoomIn">zoomIn</option>
                <option value="zoomInDown">zoomInDown</option>
                <option value="zoomInLeft">zoomInLeft</option>
                <option value="zoomInRight">zoomInRight</option>
                <option value="zoomInUp">zoomInUp</option>
                <option value="zoomOut">zoomOut</option>
                <option value="zoomOutDown">zoomOutDown</option>
                <option value="zoomOutLeft">zoomOutLeft</option>
                <option value="zoomOutRight">zoomOutRight</option>
                <option value="zoomOutUp">zoomOutUp</option>
                <option value="slideInDown">slideInDown</option>
                <option value="slideInLeft">slideInLeft</option>
                <option value="slideInRight">slideInRight</option>
                <option value="slideInUp">slideInUp</option>
                <option value="slideOutDown">slideOutDown</option>
                <option value="slideOutLeft">slideOutLeft</option>
                <option value="slideOutRight">slideOutRight</option>
                <option value="slideOutUp">slideOutUp</option>
                <option value="heartBeat">heartBeat</option>
            </select>
            <label>Продолжительность оповещения</label>
            <input type="text" name="delay" maxlength="3" value="{{ $delay }}" placeholder="В секундах..." />
            <label>Громкость оповещения</label>
            <input type="number" step="0.1" name="volume" maxlength="3" value="{{ $volume }}" placeholder="0.00-1.00" />
            <label>Изображение</label>
            @if($image != "N/A")<img src="../{{ $image }}" /><br>
            @endif
            <input type="file" name="image" /><br>
            <p>примечание: принимаются изображения с максимальным размером в 1МБ (jpeg,png,jpg,gif,svg)</p>
            <label>Звуковое оповещение</label>
            @if($sound != "N/A")
            <audio controls>
                <source src="../{{ $sound }}" type="audio/mpeg">
            </audio><br>
            @endif
            <input type="file" name="sound" /><br>
            <p>примечание: принимаются медиа-форматы с максимальным размером в 500KB</p>
            <label>Голос TTS</label>
            <select id="sel_voice" name="voice">
                <option value="oksana">Оксана (ж)</option>
                <option value="alyss">Алиса (ж)</option>
                <option value="jane">Джейн (ж)</option>
                <option value="omazh">Омаж (ж)</option>
                <option value="zahar">Захар (м)</option>
                <option value="ermil">Ермил (м)</option>
            </select>
            <label>Эмоции TTS</label>
            <select id="sel_emotion" name="emotion">
                <option value="good">радостный, доброжелательный</option>
                <option value="evil">раздраженный</option>
                <option value="neutral">нейтральный</option>
            </select>
            <label>Громкость TTS</label>
            <input type="number" step="0.1" name="temp" maxlength="4" value="{{ $temp }}" placeholder="Decimal Value..." />
            <label>Скорость чтения</label>
            <input type="number" step="0.1" name="speed" maxlength="4" value="{{ $speed }}" placeholder="Decimal Value..." />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="button-primary" type="submit" value="Сохранить">
        </fieldset>
    </form>
    <h4>Настройки текста</h4>
    <form method="post" action="/alerts/2" enctype="multipart/form-data">
        <fieldset>
            {{ $errors->first('h') }}
            {{ $errors->first('h_color') }}
            {{ $errors->first('m') }}
            {{ $errors->first('m_color') }}
            {{ session('system3') }}
            <label>Стиль заголовка</label>
            <select id="sel_h" name="h">
                <option value="Roboto">Roboto</option>
                <option value="Open Sans">Open Sans</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Source Sans Pro">Source Sans Pro</option>
                <option value="Oswald">Oswald</option>
                <option value="Merriweather">Merriweather</option>
                <option value="PT Sans">PT Sans</option>
                <option value="Noto Sans">Noto Sans</option>
                <option value="Ubuntu">Ubuntu</option>
                <option value="Playfair Display">Playfair Display</option>
                <option value="Lora">Lora</option>
                <option value="Noto Serif">Noto Serif</option>
                <option value="Arimo">Arimo</option>
            </select>
            <label>Размер заголовка</label>
            <input type="text" name="h_size" maxlength="3" value="{{ $h_size }}" placeholder="Размер в px" />
            <label>Цвет заголовка</label>
            <input type="text" name="h_color" maxlength="7" value="{{ $h_color }}" placeholder="Цветовой код" />
            <label>Стиль сообщения</label>
            <select id="sel_m" name="m">
                <option value="Roboto">Roboto</option>
                <option value="Open Sans">Open Sans</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Source Sans Pro">Source Sans Pro</option>
                <option value="Oswald">Oswald</option>
                <option value="Merriweather">Merriweather</option>
                <option value="PT Sans">PT Sans</option>
                <option value="Noto Sans">Noto Sans</option>
                <option value="Ubuntu">Ubuntu</option>
                <option value="Playfair Display">Playfair Display</option>
                <option value="Lora">Lora</option>
                <option value="Noto Serif">Noto Serif</option>
                <option value="Arimo">Arimo</option>
            </select>
            <label>Размер сообщения</label>
            <input type="text" name="m_size" maxlength="3" value="{{ $m_size }}" placeholder="Размер в px" />
            <label>Цвет сообщения</label>
            <input type="text" name="m_color" maxlength="7" value="{{ $m_color }}" placeholder="Цветовой код" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="button-primary" type="submit" value="Сохранить">
        </fieldset>
    </form>
    <script>
        $("#sel_voice [value='{{ $voice }}']").attr("selected", "selected");
        $("#sel_emotion [value='{{ $emotion }}']").attr("selected", "selected");
        $("#sel_animation-fade [value='{{ $animation }}']").attr("selected", "selected");

        $("#sel_h [value='{{ $h_style }}']").attr("selected", "selected");
        $("#sel_m [value='{{ $m_style }}']").attr("selected", "selected");
    </script>
    @endif
</section>
@endsection