@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">投稿編集</div>
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
                        <div class="form-group row">
                            <label for="title" class="col-md-2 col-form-label text-md-right">タイトル</label>
                            <div class="col-md-9">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="body" class="col-md-2 col-form-label text-md-right">内容</label>
                            <div class="col-md-9">
                                <textarea name="content" id="body" style="resize: none; height: 200px; width: 100%">{{ old('content', $post->content) }}</textarea>
                            </div>
                        </div>
                        <!-- <div class="bl_formGroup"> -->
                        <!-- <label for="image" class="el_label">画像アップロード</label> -->
                        <!-- <input type="file" class="el_form" name="image" value="{{ old('image', $post->image) }}"> -->
                        <!-- </div> -->
                        <div class="form-group row">
                            <label for="amount" class="col-md-2 col-form-label text-md-right">金額</label>
                            <div class="col-md-9">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount', $post->amount) }}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" onClick="history.back()">戻る</button>
                                <button type="submit" class="btn btn-primary ml-3" name='action' value='add'>
                                    編集完了
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection