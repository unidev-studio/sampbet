@extends('panel')
@section('content')
<section class="tellarion-panel">
    <h2>Мои выплаты</h2>
    <p>На данной странице, вы сможете создать выплату средств на удобный способ получения денежных средств. Баланс вашего аккаунта должен соответствовать той сумме, которую, вы собираетесь выводить</p>
    <h4>Создание выплаты</h4>
    <form method="post" action="/withdraw/1">
        <fieldset>
            {{ $errors->first('method') }}
            {{ $errors->first('req') }}
            {{ $errors->first('sum') }}
            {{ session('system') }}
            <label>Метод</label>
            <select id="sel_method" name="method">
                <option value="qiwi">Qiwi</option>
            </select>
            <label>Счет</label>
            <input type="text" name="addr" maxlength="24" value="" placeholder="7.........." />
            <label>Сумма</label>
            <input type="number" step="0.01" name="sum" maxlength="5" value="100.00" placeholder="..." />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="button-primary" type="submit" value="Вывести">
        </fieldset>
    </form>
    <div class="table">
    <table style="">
        <thead>
            <tr>
                <th>#</th>
                <th>Метод</th>
                <th>Счет</th>
                <th>Сумма</th>
                <th>Статус</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            {!! $withdraws !!}
        </tbody>
        </table>
    </div>
</section>
@endsection