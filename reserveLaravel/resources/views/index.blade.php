<?php
$week = ['日', '月', '火', '水', '木', '金', '土'];
function createTd($time1, $time2)
{
  echo '<tr>
  <th>' . $time1 . '</th>';
  for ($i = 1; $i < 8; $i++) {
    echo '<td><button
    type="submit" value="' . date("Y-m-d ", strtotime("$i day")) . $time2 . '"name="date"></button></td>';
  }
  echo '</tr>';
}
?>
@extends('layouts.app')
<style>
  .main {
    text-align: center;
  }

  table {
    margin-left: auto;
    margin-right: auto;
    width: 80%;
  }

  td,
  th {
    height: 45px;
  }

  td:hover {
    color: #ffffff;
    background-color: blue;
    cursor: pointer;
  }

  td[disabled] {
    pointer-events: none;
  }

  button {
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    background: transparent;
  }

  .flex {
    display: flex;
    justify-content: center;
  }

  .item {
    margin-right: 20px;
    margin-bottom: 10px;
  }

  li {
    list-style: none;
  }
</style>

@section('title','Top')

@section('content')

@isset($_SESSION['msg'])
<script>
  alert("<?= $_SESSION['msg'] ?>");
</script>
<?php unset($_SESSION['msg']); ?>
@endisset
<div class="main">
  <h2>予約システム</h2>
  <p>赤色は本人、青はその他のユーザー</p>
  @if(isset($_SESSION['id']))
  <div class="flex">
    <div class="item" id="info"><a href="/info">予約情報・キャンセル</a></div>
    <div class="item"><a href="/logout">ログアウト</a></div>
  </div>
  @else
  <div class="flex">
    <div class="item"><a href="/submit">会員登録</a></div>
    <div class="item"><a href="/login">ログイン</a></div>
  </div>
  @endif
  <table border="2">
    <tr>
      <th>　</th>
      <?php for ($i = 1; $i < 8; $i++) {
        echo '<th>' . date("m/d", strtotime("$i day"))  . '(' . $week[date('w', strtotime("$i day"))] . ')</th>';
      } ?>
    </tr>
    <form action="/form" method="post">
      @csrf
      <?php createTd('10時', '10:00'); ?>
      <?php createTd('11時', '11:00'); ?>
      <?php createTd('12時', '12:00'); ?>
      <?php createTd('13時', '13:00'); ?>
      <?php createTd('14時', '14:00'); ?>
      <?php createTd('15時', '15:00'); ?>
      <?php createTd('16時', '16:00'); ?>
      <?php createTd('17時', '17:00'); ?>
      <?php createTd('18時', '18:00'); ?>
  </table>
</div>
<script>
  //予約されているtdの色を変更する処理
  $(function() {
    $.ajax({
      type: 'GET',
      url: "https://agile-sierra-61895.herokuapp.com/json",
      dataType: 'json',
    }).done(function(data) {
      console.log(data);
      let buttons = document.querySelectorAll('button');
      for (let i = 0; i < data.length; i++) {
        for (let j = 0; j < buttons.length; j++) {
          if (buttons[j].value == '<?php echo substr($date, 0, 16); ?>') {
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
</script>
@if(!isset($_SESSION['id']))
<script>
  $(function() {
    $('button').css('pointer-events', 'none');
    $('td').on('click', function() {
      alert('予約するには会員登録又はログインしてください');
    })
  })
</script>
@endif
@endsection
