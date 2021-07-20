@extends('welcome')
@section('content')
<section class="express">
    <div class="container-auth tc">
        <form method="post" action="/register">
            <h2>Регистрация</h2>
            {{ $errors->first('email') }}
            {{ $errors->first('password') }}
            {{ $errors->first('password_repeat') }}
            {{ session()->get('system') }}
            <fieldset>
                <label for="nameField">Почтовый адрес</label>
                <input type="text" placeholder="" name="email">
                <label for="nameField">Пароль</label>
                <input type="password" placeholder="" name="password">
                <label for="nameField">Подтвердите пароль</label>
                <input type="password" placeholder="" name="password_repeat">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="button-primary" type="submit" value="Зарегистрироваться">
            </fieldset>
            <label class="label-inline" for="confirmField">У вас уже есть аккаунт? <a href="/panel">Вам сюда!</a></label>
        </form>
    </div>
</section>
@endsection