@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2 class="text-danger">ご利用いただくことができません</h2>
    <p>お客様のアカウントは現在利用停止されています。</p>
    <a href="{{ route('logout') }}" class="btn btn-primary"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        ログアウト
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
@endsection
