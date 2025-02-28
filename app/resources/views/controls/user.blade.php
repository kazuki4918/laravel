@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><p class="font-weight-bold">ユーザーリスト</p></div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ユーザー名</th>
                                <th>投稿表示停止数</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->post_count }}</td>
                                <td>
                                    <form action="{{ route('user.stop', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('利用停止にしますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">ユーザー利用停止</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="" class="btn btn-secondary">戻る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
