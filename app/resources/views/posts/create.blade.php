@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">新規投稿</h5>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger mt-3 mx-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card-body px-5 py-4">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- タイトル -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">タイトル</label>
                            <input id="title" type="text" class="form-control form-control-lg rounded-pill shadow-sm"
                                name="title" value="{{ old('title') }}" placeholder="タイトルを入力">
                        </div>

                        <!-- 内容 -->
                        <div class="mb-4">
                            <label for="body" class="form-label fw-bold">内容</label>
                            <textarea name="content" id="body" class="form-control rounded shadow-sm"
                                style="resize: none; height: 200px;" placeholder="内容を入力">{{ old('content') }}</textarea>
                        </div>

                        <!-- 画像 -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">画像アップロード</label>
                            <input type="file" class="form-control form-control-lg rounded shadow-sm"
                                name="image" id="image">
                        </div>

                        <!-- 金額 -->
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-bold">金額</label>
                            <input id="amount" type="text" class="form-control form-control-lg rounded-pill shadow-sm"
                                name="amount" value="{{ old('amount') }}" placeholder="例: 1000">
                        </div>

                        <!-- ボタン -->
                        <div class="text-center mt-4">
                            <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4 py-2 mx-3" name='action' value='add'>
                                <i class="fas fa-upload"></i> 投稿
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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

    .form-control {
        border: 2px solid #ced4da;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
    }

    .btn {
        font-weight: bold;
        transition: 0.3s;
    }

    .btn:hover {
        opacity: 0.8;
    }
</style>

@endsection