<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>SAMP-BET — Мой аккаунт</title>
        <link rel="icon" href="/favicon.ico?2" type="image/x-icon" />
        <link rel="stylesheet" href="/css/milligram.min.css" />
        <link rel="stylesheet" href="/css/faall.min.css">
        <link rel="stylesheet" href="/css/style.css?156" />
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/header.js"></script>
    </head>
    <body>
        <main class="wrapper">
            <nav class="navigation container">
                <h1 class="logo"><a href="/">SAMP-BET</a></h1>
                <div class="navbar">
                    <div class="billing">
                       [ <a href="/panel">{{ $person[0] }}</a> ]@if($person[2] == 1) <a href="/panel/moderation/main">[М]</a> @endif<span class="ml-2">&nbsp Баланс: {{ $person[1] }} RUB <a href="/panel/settings"><i class="fas fa-user-cog" style="padding-left: 5px; font-size: 20px;"></i></a> <a href="/panel/exit"><i class="fas fa-door-open" style="padding-left: 5px; font-size: 20px;"></i></a></span>
                    </div>
                </div>
            </nav>

            <section class="panel">
                <div class="bar container">
                    <ul>
                        <li><a href="/panel"><i class="fas fa-chart-bar"></i> <span class="ml-1">Статистика</span></a></li>
                        <li><a href="/panel/transactions"><i class="fab fa-alipay"></i> <span class="ml-1">История</span></a></li>
                        <li><a href="/panel/draw"><i class="fa fa-ruble-sign"></i> <span class="ml-1">Пополнить баланс</span></a></li>
                        <li><a href="/panel/withdraw"><i class="fas fa-wallet"></i> <span class="ml-1">Выплаты</span></a></li>
                        <li><a href="/panel/referal"><i class="fas fa-handshake"></i> <span class="ml-1">Рефералка</span></a></li>
                    </ul>
                </div>
            </section>

            <section class="panel2">
                <div class="container">
                    @yield('content')
                </div>
            </section>

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