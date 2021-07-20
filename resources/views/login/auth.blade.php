@extends('welcome')
@section('content')
<section class="express">
    <div class="container-auth tc">
        <form method="post" action="/panel">
            <h2>Войти в аккаунт</h2>
            {{ $errors->first('email') }}
            {{ $errors->first('password') }}
            {{ session('system') }}
            {{ session()->get('message') }}
            <fieldset>
                <label for="nameField">Почтовый адрес</label>
                <input type="text" placeholder="" name="email">
                <label for="nameField">Пароль</label>
                <input type="password" placeholder="" name="password">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="button-primary" type="submit" value="Войти">
            </fieldset>
            <label class="label-inline" for="confirmField">У вас нет личного аккаунта? <a href="/register">Не проблема!</a></label>
        </form>
    </div>
</section>
@endsection