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
@section('title','submit')
@section('content')
<form action="" method="POST">
  @csrf
  <p> 名前: <input type="text" name="name"></p>
  @isset($err['name'])
  <p class="err">{{$err['name']}}</p>
  @endisset

  <p> 電話番号: <input type="tel" name="phone"></p>
  @isset($err['phone'])
  <p class="err">{{$err['phone']}}</p>
  @endisset

  <p> メールアドレス: <input type="email" name="email"></p>
  @isset($err['email'])
  <p class="err">{{$err['email']}}</p>
  @endisset
  @isset($err['isset'])
  <p class="err">{{$err['isset']}}</p>
  @endisset

  <p>パスワード: <input type="password" name="password"> </p>
  @isset($err['password'])
  <p class="err">{{$err['password']}}</p>
  @endisset

  <p>パスワード確認: <input type="password" name="password_conf"></p>
  @isset($err['password_conf'])
  <p class="err">{{$err['password_conf']}}</p>
  @endisset
  @isset($err['notEqual'])
  <p class="err">{{$err['notEqual']}}</p>
  @endisset
  <div class="flex">
    <a href="/" class="item">トップページへ</a>
    <input class="item" type="submit" value="登録する">
  </div>
</form>
@endsection
