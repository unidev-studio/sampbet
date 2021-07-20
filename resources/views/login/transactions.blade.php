@extends('panel')
@section('content')
<section class="tellarion-panel">
    <h2>Мои транзакции</h2>
    <div class="table">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Сумма</th>
                <th>Комментарий</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            {!! $payments !!}
        </tbody>
        </table>
    </div>
</section>
@endsection