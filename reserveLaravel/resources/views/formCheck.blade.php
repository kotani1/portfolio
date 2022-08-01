  @extends('layouts.app')
  <style>
    .main {
      text-align: center;
    }

    .flex {
      display: flex;
      justify-content: center;
    }

    .item {
      margin: 20px 20px 0 20px;
    }
  </style>
@section('title','formCheck')
@section('content')
  <div class="main">
    <h2>確認画面</h2>
    <p>予約日時： {{$dateView}}</p>
    <p>メニュー：{{$menu}}</p>
    <div class="flex">
      <form action="/form" method="POST">
        @csrf
        <div class="item"><button>戻る</button></div>
        <input type="hidden" value="<?= $date ?>" name="date">
      </form>
      <form action="/formReserve" method="POST">
        @csrf
        <input type="hidden" value="<?= $menu ?>" name="menu">
        <input type="hidden" value="<?= $date ?>" name="date">
        <input type="hidden" value="<?= $dateView ?>" name="dateView">
        <div class="item"><button>予約する</button></div>
      </form>
    </div>
  </div>
  @endsection
