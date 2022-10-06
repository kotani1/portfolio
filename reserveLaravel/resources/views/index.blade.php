<?php
$week = ['日', '月', '火', '水', '木', '金', '土'];
function createTd($time1, $time2)
{
  echo '<tr><th>' . $time1 . '</th>';
  for ($i = 1; $i < 8; $i++) {
    echo '<td><button
    type="submit" value="' . date("Y-m-d ", strtotime("$i day")) . $time2 . '"name="date"></button></td>';
  }
  echo '</tr>';
}
?>
@extends('layouts.app')
@section('title','Top')
@section('css')
<link rel="stylesheet" href="/css/index.css">
@endsection
@section('body')
<script src="/js/script.js"></script>
<div class="main">
  <h2>予約システム</h2>
  <p>赤色は本人、青はその他のユーザー</p>
  @if(isset($_SESSION['id']))
  <h3> <?= $_SESSION['name']; ?> さんようこそ</h3>
  <div class="flex">
    <div class="item" id="info"><a href="/info">予約情報・キャンセル</a></div>
    <div class="item"><a href="/logout">ログアウト</a></div>
  </div>
  @else
  <div class="flex">
    <div class="item"><a href="/submit">会員登録</a></div>
    <div class="item"><a href="/login">ログイン</a></div>
  </div>
  <script>
    not_click();
  </script>
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
  reserved('<?= substr($date, 0, 16); ?>');
</script>
@isset($_SESSION['msg'])
<script>
  alert("<?= $_SESSION['msg'] ?>");
</script>
<?php unset($_SESSION['msg']); ?>
@endisset
@endsection
