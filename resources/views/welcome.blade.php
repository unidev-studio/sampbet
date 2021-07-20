<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SAMP-BET — SA:MP</title>
        <link rel="icon" href="https://samp-bet.ru/favicon.ico?2" type="image/x-icon" />
        <link rel="stylesheet" href="https://samp-bet.ru/css/milligram.min.css" />
        <link rel="stylesheet" href="https://samp-bet.ru/css/faall.min.css">
        <link rel="stylesheet" href="https://samp-bet.ru/css/style.css?156" />
        <script src="https://samp-bet.ru/js/jquery-3.3.1.min.js"></script>
        <script src="https://samp-bet.ru/js/header.js"></script>
    </head>
    <body>
        <main class="wrapper">
            <nav class="navigation container">
                <h1 class="logo"><a href="https://samp-bet.ru/">SAMP-BET</a></h1>
                <div class="navbar">
                    @if($auth == 0)
                    <ul>
                        <li><a href="/">Главная</a></li>
                        <li><a href="/about">О сервисе</a></li>
                        <li><a href="/rates">Тарифы</a></li>
                        <li><a href="/panel">Войти в аккаунт</a></li>
                    </ul>
                    @else
                    <div class="billing">
                    [ <a href="https://samp-bet.ru/panel">{{ $person[0] }}</a> ]@if($person[2] == 1) <a href="https://samp-bet.ru/panel/moderation/main">[М]</a> @endif<span class="ml-2">&nbsp Баланс: {{ $person[1] }} RUB <a href="/panel/settings"><i class="fas fa-user-cog" style="padding-left: 5px; font-size: 20px;"></i></a> <a href="/panel/exit"><i class="fas fa-door-open" style="padding-left: 5px; font-size: 20px;"></i></a></span>
                    </div>
                    @endif
                </div>
            </nav>
            @yield('content')
            <footer class="express">
                <div class="container tc">
                    <div class="row">
                        <div class="column column-100">
                            <div class="footerbar">
                                <ul>
                                    <li><a href="/contacts">Контакты</a></li>
                                    <li><a href="/docs">Документы</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="copy">
                        &copy SAMP-BET 2020<br>
                    </div>
                </div>
            </footer>
        </main>
    </body>
</html>