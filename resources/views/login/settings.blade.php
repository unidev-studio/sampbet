@extends('panel')
@section('content')
<section class="tellarion-panel">
    <h2>Настройки</h2>
    <p>Здесь можно настроить настройки безопасности вашего аккаунта и персонализацию [BETA]</p>
    <h4>Персонализация</h4>
    <form method="post" action="/settings/1">
        <fieldset>
            {{ $errors->first('ident') }}
            {{ session('system') }}
            <label>Идентификатор</label>
            <input type="text" name="ident" maxlength="31" value="{{ $ident }}" placeholder="Придумайте идентификатор" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="button-primary" type="submit" value="Сохранить">
        </fieldset>
    </form>
</section>
@endsection