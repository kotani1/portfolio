@extends('layouts.app')
<style>
  .err {
    color: red;
  }

  .flex {
    display: flex;
  }

  .item {
    margin: 20px 20px 0 20px;
  }
</style>

@section('title','login')
@section('content')
<form action="" method="POST">
  @csrf
  <p> メールアドレス:
    <input type="email" name="email">
    @isset($err['email'])
  <p class="err">{{$err['email']}}</p>
  @endisset
  @isset($err['notEmail'])
  <p class="err">{{$err['notEmail']}}</p>
  @endisset
  </p>
  <p> パスワード:
    <input type="password" name="password">
    @isset($err['password'])
  <p class="err">{{$err['password']}}</p>
  @endisset
  @isset($err['notPassword'])
  <p class="err">{{$err['notPassword']}}</p>
  @endisset
  </p>
  <div class="flex">
    <a href="/" class="item">トップページへ</a>
    <button class="item">送信</button>
  </div>
</form>
@endsection
