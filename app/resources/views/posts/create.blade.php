@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-center">
                    <h5>新規投稿</h5>
                </div> <!-- カードヘッダーを中央寄せ -->

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
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- タイトル -->
                        <div class="form-group row text-center">
                            <label for="title" class="col-md-2 col-form-label text-md-right">タイトル</label>
                            <div class="col-md-9">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                            </div>
                        </div>

                        <!-- 内容 -->
                        <div class="form-group row text-center">
                            <label for="body" class="col-md-2 col-form-label text-md-right">内容</label>
                            <div class="col-md-9">
                                <textarea name="content" id="body" class="form-control" style="resize: none; height: 200px; width: 100%">{{ old('content') }}</textarea>
                            </div>
                        </div>

                        <!-- 画像 -->
                        <div class="form-group row text-center">
                            <label for="image" class="col-md-2 col-form-label text-md-right">画像アップロード</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control-file" name="image" id="image">
                            </div>
                        </div>

                        <!-- 金額 -->
                        <div class="form-group row text-center">
                            <label for="amount" class="col-md-2 col-form-label text-md-right">金額</label>
                            <div class="col-md-9">
                                <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}">
                            </div>
                        </div>

                        <!-- ボタン -->
                        <div class="form-group text-center">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" onClick="history.back()">戻る</button>
                                <button type="submit" class="btn btn-primary mx-2" name='action' value='add'>
                                    投稿
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