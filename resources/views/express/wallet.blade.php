@extends('ident')
@section('content')
                    @if($type == 0)
                    <p>Оплата прошла успешно</p>
                    @elseif($type == 1)
                    <p>Во время оплаты возникла ошибка. Обратитесь в interkassa.com</p>
                    @elseif($type == 2)
                    <p>Ожидание платежа...</p>
                    @elseif($type == 3)
                    <p>Проводиться проверка...</p>
                    @elseif($type == 999)
                    <p>N/A</p>
                    @endif
@endsection