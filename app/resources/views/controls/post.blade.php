@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>投稿リスト</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 40%;">タイトル</th>
                                <th style="width: 40%;">違反報告数</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->violations_count }}</td>
                                <td>
                                    @if ($post->del_flg == 0)
                                    <!-- 表示停止ボタン -->
                                    <form action="{{ route('post.stop', $post->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('この投稿を表示停止しますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">表示停止</button>
                                    </form>
                                    @else
                                    <!-- 解除ボタン -->
                                    <form action="{{ route('post.stop', $post->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('この投稿の表示を再開しますか？');">
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