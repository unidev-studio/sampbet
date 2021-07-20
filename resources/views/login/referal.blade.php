@extends('panel')
@section('content')
<section class="tellarion-panel">
    <h2>Реферальная система</h2>
    <p>Вы можете пригласить на этот сервис своих друзей и получать доп. средства на свой баланс при их пополнении на сервисе</p>
    <h4>Информация</h4>
    <p>Ваша реферальная ссылка: <a href="https://samp-bet.ru/referal/{{$id}}">https://samp-bet.ru/referal/{{$id}}</a></p>
    <p> - достаточно поделится ссылкой и чтобы человек перешел, при регистрации - он к вам добавится в ваш список.</p>

    <div class="table">
    <table>
        <thead>
            <tr>
                <th>ID пользователя</th>
                <th>Сумма платежей</th>
                <th>Сумма выводов</th>
            </tr>
        </thead>
        <tbody>
            {!! $table !!}
        </tbody>
        </table>
    </div>
</section>
@endsection