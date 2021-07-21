@if($find == 0)
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Alerts- Tellarion Express</title>
    </head>
    <body>
        <main class="wrapper">
            Not Found User
        </main>
    </body>
</html>
@elseif($find == 1)
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Alerts - Tellarion Express</title>
        <link rel="stylesheet" href="/css/milligram.min.css" />
        <link rel="stylesheet" href="/css/faall.min.css">
        <link rel="stylesheet" href="/css/alerts.css" />
        <link rel="stylesheet" href="/css/animate.css" />
        <script src="/js/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <main class="wrapper">
            @if($alert == 1)
            <audio id="sound" src="../{{ $sound }}"></audio>
            <div class="alert animated {{ $animation }}">
                <div class="alert-image"><img src="../{{ $image }}" /></div>
                <div class="alert-title" style="font-family: '{{ $h_style }}'!important; font-size: {{ $h_size }}px!important; color: {{ $h_color }}!important; text-shadow: 0px 0px 1px rgb(0, 0, 0), 0px 0px 2px rgb(0, 0, 0), 0px 0px 3px rgb(0, 0, 0), 0px 0px 4px #000, 0px 0px 5px rgb(0, 0, 0);">{{ $username }} - {{ $sum }} <i class="fas fa-ruble-sign"></i></div>
                <div class="alert-message" style="font-family: '{{ $m_style }}'!important; font-size: {{ $m_size }}px!important; color: {{ $m_color }}!important; text-shadow: 0px 0px 1px rgb(0, 0, 0), 0px 0px 2px rgb(0, 0, 0), 0px 0px 3px rgb(0, 0, 0), 0px 0px 4px #000, 0px 0px 5px rgb(0, 0, 0);">{{ $message }}</div>
            </div>
            @endif
        </main>
        <script>
            let delay = {{ $delay }};
            @if($alert == 1)
            $(document).ready(function() {
                let voice = 0;
                var audio = $("#sound")[0];
                audio.play();
                audio.volume = {{ $volume }};
                $("#sound").on("loadedmetadata", function() {
                    if(voice == 0) {
                        voice++;
                        let duration = audio.duration;
                        delay = delay + (parseInt(duration) * 1000);
                        console.log(`delay: ${delay}`);
                        setTimeout(function() {
                            audio.pause();
                            $("#sound").attr("src", "../{{ $path_voice }}");
                            setTimeout(function() {
                                audio.volume = {{ $temp }};
                                audio.play();
                            }, 1000);
                        }, parseInt(duration) * 1000);
                        setTimeout(function() {
                            location.reload();
                        }, delay);
                    }
                });
            });
            @elseif($alert == 0)
            setTimeout(function() {
                location.reload();
            }, delay);
            @endif
        </script>
    </body>
</html>
@endif