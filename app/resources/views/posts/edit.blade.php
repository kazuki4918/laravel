@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">投稿編集</h5>
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
                    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- タイトル -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">タイトル</label>
                            <input id="title" type="text" class="form-control form-control-lg rounded-pill shadow-sm"
                                name="title" value="{{ old('title', $post->title) }}" required>
                        </div>

                        <!-- 内容 -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">内容</label>
                            <textarea name="content" id="content" class="form-control rounded shadow-sm"
                                style="resize: none; height: 200px;" required>{{ old('content', $post->content) }}</textarea>
                        </div>

                        <!-- 画像 -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">現在の画像</label>
                            <div class="text-center">
                                @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像"
                                    class="rounded shadow-lg bg-white"
                                    style="width: 100%; max-width: 350px; height: auto; object-fit: cover; border-radius: 15px;">
                                @else
                                <p class="text-muted">画像は登録されていません。</p>
                                @endif
                            </div>
                            <input type="file" class="form-control form-control-lg rounded shadow-sm mt-3" name="image" id="image">
                        </div>

                        <!-- 金額 -->
                        <div class="mb-4">
                            <label for="amount" class="form-label fw-bold">金額</label>
                            <input id="amount" type="text" class="form-control form-control-lg rounded-pill shadow-sm"
                                name="amount" value="{{ old('amount', $post->amount) }}" required>
                        </div>

                        <!-- ボタン -->
                        <div class="text-center mt-4">
                            <a href="{{ route('profiles.posts.show', $post->id) }}" class="btn btn-outline-secondary rounded-pill px-4">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4 mx-2">
                                <i class="fas fa-check"></i> 編集完了
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