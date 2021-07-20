@extends('panel')
@section('content')
<section class="tellarion-panel">
    <h2>Пополнить баланс</h2>
    <form for="">
        {{ $errors->first('email') }}
        {{ $errors->first('password') }}
        {{ session('system') }}
        {{ session()->get('message') }}
        <span id="ajax_return"></span>
        <fieldset>
            <label for="samp-bet">Сумма</label>
            <input type="number" id="sum" value="50" placeholder="">
            <input type="hidden" id="hidden_ident" value="{{ $email }}" />
            <input type="hidden" id="hidden_sum" value="50" />
            <input class="button-primary" type="button" onclick="interkassa_click()" value="Пополнить">
        </fieldset>
    </form>

    <script src="https://samp-bet.ru/js/sha256.min.js"></script>
    <script src="https://samp-bet.ru/js/interkassa_dev.js?5"></script>
</section>
@endsection