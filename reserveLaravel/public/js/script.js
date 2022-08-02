$(function () {
  $('#chancel').on('click', function () {
    let check = window.confirm('キャンセルしますか？');
    if (check) {
      document.chancel.submit();
    }
  })
})

  //予約されているtdの色を変更する処理
function reserved(time) {
  $(function () {
  $.ajax({
    type: 'GET',
    url: "https://agile-sierra-61895.herokuapp.com/json",
    dataType: 'json',
  }).done(function (data) {
    let buttons = document.querySelectorAll('button');
    for (let i = 0; i < data.length; i++) {
      for (let j = 0; j < buttons.length; j++) {
        if (buttons[j].value == time) {
          let td = buttons[j].parentNode;
          td.setAttribute("bgcolor", "red");
          let tds = document.querySelectorAll('td');
          for (let i = 0; i < tds.length; i++) {
            tds[i].setAttribute("disabled", true);
          }
        } else if (buttons[j].value == data[i]) {
          let td = buttons[j].parentNode;
          td.setAttribute("bgcolor", "blue");
          td.setAttribute("disabled", true);
        }
      }
    }
  })
  })
}


function not_click() {
  $(function (){
  $('button').css('pointer-events', 'none');
  $('td').on('click', function () {
    alert('予約するには会員登録又はログインしてください');
  })
})
}
