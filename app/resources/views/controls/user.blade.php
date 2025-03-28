@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">ユーザーリスト</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 40%;">ユーザー名</th>
                                <th style="width: 40%;">投稿表示停止数</th>
                                <th>アクション</th>
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
                                        <button type="submit" class="btn btn-outline-danger rounded-pill px-4 py-2">
                                            利用停止
                                        </button>
                                    </form>
                                    @else
                                    <!-- 解除ボタン -->
                                    <form action="{{ route('user.stop', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('このユーザーの利用を再開しますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success rounded-pill px-4 py-2">
                                            解除
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 w-25">
                            <i class="fas fa-arrow-left"></i> 戻る
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- スタイル -->
<style>
    .shadow-lg {
        transition: 0.3s;
    }

    .shadow-lg:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .rounded-lg {
        border-radius: 15px;
    }

    .btn {
        font-weight: bold;
        transition: 0.3s;
    }

    .btn:hover {
        opacity: 0.8;
    }

    .badge {
        font-weight: bold;
    }

    .table-striped tbody tr:hover {
        background-color: #f1f1f1;
    }

    .btn-group-vertical .btn {
        margin: 5px 0;
    }
</style>