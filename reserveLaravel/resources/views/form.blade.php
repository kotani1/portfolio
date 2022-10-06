@extends('layouts.app')
@section('title','form')
@section('css')
<link rel="stylesheet" href="/css/form.css">
@endsection
@section('body')
<div class="main">
  <p>予約日時： {{$dateView}}</p>
  <p>メニュー</p>
  <form action="/formCheck" method="POST" id="formCheck">
    @csrf
    <ul>
      <li><label><input type="radio" name="menu" checked value="メニューA">メニューA</label></li>
      <li> <label><input type="radio" name="menu" value="メニューB"> メニューB</label></li>
      <li> <label><input type="radio" name="menu" value="メニューC"> メニューC</label></li>
    </ul>
    <input type="hidden" value="<?= $dateView ?>" name="dateView">
    <input type="hidden" value="<?= $date ?>" name="date">
  </form>
  <div class="flex">
    <form action="/" method="get">
      <div class="item"><button>戻る</button></div>
    </form>
    <div class="item">
      <button form="formCheck">確認画面へ</button>
    </div>
  </div>
</div>
@endsection
