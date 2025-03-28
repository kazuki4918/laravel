@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">新規依頼</h5>
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
                    <form action="{{ route('requests.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <!-- 依頼内容 -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">依頼内容</label>
                            <textarea name="content" id="content" class="form-control rounded shadow-sm"
                                style="resize: none; height: 200px;" placeholder="依頼内容を入力してください">{{ old('content') }}</textarea>
                        </div>

                        <!-- 電話番号 -->
                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">電話番号</label>
                            <input type="text" id="phone" name="tel" class="form-control form-control-lg rounded-pill shadow-sm"
                                placeholder="例: 090-1234-5678" value="{{ old('tel') }}">
                        </div>

                        <!-- メールアドレス -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">メールアドレス</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg rounded-pill shadow-sm"
                                placeholder="例: example@email.com" required value="{{ old('email') }}">
                        </div>

                        <!-- 希望納期 -->
                        <div class="mb-4">
                            <label for="deadline" class="form-label fw-bold">希望納期</label>
                            <input type="date" id="deadline" name="deadline" class="form-control form-control-lg rounded-pill shadow-sm"
                                value="{{ old('deadline') }}">
                        </div>

                        <!-- ボタン -->
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2"
                                onClick="history.back()">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </button>
                            <button type="submit" class="btn btn-outline-primary rounded-pill px-4 py-2 mx-3" name='action' value='add'>
                                <i class="fas fa-paper-plane"></i> 依頼
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