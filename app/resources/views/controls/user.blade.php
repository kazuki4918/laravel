@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>ユーザーリスト</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 40%;">ユーザー名</th>
                                <th style="width: 40%;">投稿表示停止数</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->post_count }}</td>
                                <td>
                                    @if ($user->del_flg == 0)
                                    <!-- 利用停止ボタン -->
                                    <form action="{{ route('user.stop', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('このユーザーを利用停止にしますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">利用停止</button>
                                    </form>
                                    @else
                                    <!-- 解除ボタン -->
                                    <form action="{{ route('user.stop', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('このユーザーの利用を再開しますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-success">解除</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary w-25">戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection