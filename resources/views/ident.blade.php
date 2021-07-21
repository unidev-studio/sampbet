<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>SAMP-BET — Процесс</title>
        <link rel="icon" href="/favicon.ico?2" type="image/x-icon" />
        <link rel="stylesheet" href="/css/milligram.min.css" />
        <link rel="stylesheet" href="/css/faall.min.css">
        <link rel="stylesheet" href="/css/style.css?47" />
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/header.js"></script>
    </head>
    <body>
        <main class="wrapper">
            <nav class="navigation container">
                <h1 class="logo"><a href="/">SAMP-BET</a></h1>
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
                            [ <a href="/panel">{{ $person[0] }}</a> ] <span class="ml-2">&nbsp Баланс: {{ $person[1] }} Р. <a href="/exit"><i class="fas fa-door-open"></i></a></span>
                    </div>
                    @endif
                </div>
            </nav>
            <section class="express">
                <div class="container tc">
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
                        &copy Tellarion 2019
                    </div>
                </div>
            </footer>
        </main>
    </body>
</html>