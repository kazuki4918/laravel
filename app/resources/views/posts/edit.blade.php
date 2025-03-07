@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center"><h5>投稿編集</h5></div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- タイトル -->
                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-md-right">タイトル</label>
                            <div class="col-md-9">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}">
                            </div>
                        </div>

                        <!-- 内容 -->
                        <div class="form-group row">
                            <label for="content" class="col-md-2 col-form-label text-md-right">内容</label>
                            <div class="col-md-9">
                                <textarea name="content" id="content" class="form-control" style="resize: none; height: 200px;">{{ old('content', $post->content) }}</textarea>
                            </div>
                        </div>

                        <!-- 画像 -->
                        <div class="form-group row">
                            <label for="image" class="col-md-2 col-form-label text-md-right">現在の画像</label>
                            <div class="col-md-9">
                                @if($post->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" class="rounded" style="width: 250px; height: 250px; object-fit: cover;">
                                </div>
                                @else
                                <p>画像は登録されていません。</p>
                                @endif
                                <input type="file" class="form-control-file mt-2" name="image" id="image">
                            </div>
                        </div>

                        <!-- 金額 -->
                        <div class="form-group row">
                            <label for="amount" class="col-md-2 col-form-label text-md-right">金額</label>
                            <div class="col-md-9">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount', $post->amount) }}">
                            </div>
                        </div>

                        <!-- ボタン -->
                        <div class="form-group text-center">
                            <a href="{{route('profiles.posts.show', $post->id) }}" class="btn btn-secondary">戻る</a>
                            <button type="submit" class="btn btn-primary mx-2">編集完了</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection