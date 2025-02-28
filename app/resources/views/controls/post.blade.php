@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <p class="font-weight-bold">投稿リスト</p>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>違反報告数</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->violations_count }}</td>
                                <td>
                                    <form action="{{ route('post.stop', $post->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('表示停止しますか？');">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">表示停止</button>
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