function interkassa_click() {

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    type: 'POST',
    url: '/wallet/1',
    dataType: 'JSON',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      value_1: $('#hidden_ident').val(),
      value_2: $('#sum').val(),
      value_3: "RUB"
    },
    success: function(data) {
      console.log(data);
      if(data == 0) {
        let sum = $('#hidden_sum').val();
        alert(`Сумма должна быть более ${sum}Р`);
      } else if(data == 1) {
        alert(`Неизвестный идентификатор`);
      } else {
        window.location.href = `https://sci.interkassa.com/?ik_co_id=${data['ik_co_id']}&ik_pm_no=${data['ik_pm_no']}&ik_am=${data['ik_am']}&ik_cur=${data['ik_cur']}&ik_desc=${data['ik_desc']}&ik_sign=${data[0].ik_sign}`;
      }
    }
  });
}