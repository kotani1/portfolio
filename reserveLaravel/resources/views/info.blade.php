@extends('layouts.app')
@section('title','info')
@section('css')
<link rel="stylesheet" href="/css/info.css">
@endsection
@section('body')
<script src="/js/script.js"></script>
<div class="main">
  <h2>予約情報</h2>
  @if(!empty($info))
    <p>予約日時： {{$info->dateView}}</p>
    <p>メニュー： {{$info->menu}}</p>
  @else
    <h3>まだ予約してません</h3>
  @endif
    <div class="flex">
      <form action="/" method="get">
        <div class="item"><button>戻る</button></div>
      </form>
      @if(!empty($info))
      <form action="/formChancel" method="post" name="chancel">
        @csrf
        <div class="item"><button id="chancel" type="button">キャンセルする</button></div>
      </form>
    @endif
  </div>
</div>
@endsection
