@if($find == 0)
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Bars - Tellarion Express</title>
    </head>
    <body>
        <main class="wrapper">
            Bar not found
        </main>
    </body>
</html>
@elseif($find == 1)
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Bars - Tellarion Express</title>
        <link rel="stylesheet" href="https://tellarion.express/css/milligram.min.css" />
        <link rel="stylesheet" href="https://tellarion.express/css/faall.min.css">
        <link rel="stylesheet" href="https://tellarion.express/css/bars.css" />
        <link rel="stylesheet" href="https://tellarion.express/css/animate.css" />
        <link rel="stylesheet" href="https://tellarion.express/css/jquery-ui.min.css" />
        <script src="https://tellarion.express/js/jquery-3.3.1.min.js"></script>
        <script src="https://tellarion.express/js/jquery-ui.min.js"></script>
    </head>
    <body>
        <style>
            .ui-widget-header {
                background-color: #0096a7!important;
                margin: 0!important;
                padding: 0!important;
            }
        </style>
        <main class="wrapper">
        <h3 style="font-family: 'Montserrat', sans-serif; color: #0096a7;"><b>{{ $target_name }}</b></h3>
        <div class="progress" style="height: 50px; border-radius: 50px;"><span class="inside" style="line-height: 50px;"><b>Собрано {{ $target_actual }} RUB из {{ $target_end }} RUB</b></div></div>
        </main>
        <script>
            let delay = 20000;
            $(document).ready(function() {
                $(".progress").progressbar({
                    value: {{ $procent_bar }},
                });
            });
            setTimeout(function() {
                location.reload();
            }, delay);
        </script>
    </body>
</html>
@endif