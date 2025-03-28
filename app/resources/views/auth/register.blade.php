@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">会員登録</h5>
                </div>

                <div class="card-body px-5 py-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- ユーザー名 -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">ユーザー名</label>
                            <input id="name" type="text" class="form-control form-control-lg rounded-pill shadow-sm @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="ユーザー名を入力">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- メールアドレス -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">メールアドレス</label>
                            <input id="email" type="email" class="form-control form-control-lg rounded-pill shadow-sm @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="例: example@email.com">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- パスワード -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">パスワード</label>
                            <input id="password" type="password" class="form-control form-control-lg rounded-pill shadow-sm @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password" placeholder="パスワードを入力">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- 確認用パスワード -->
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-bold">確認用パスワード</label>
                            <input id="password-confirm" type="password" class="form-control form-control-lg rounded-pill shadow-sm"
                                name="password_confirmation" required autocomplete="new-password" placeholder="もう一度パスワードを入力">
                        </div>

                        <!-- 登録ボタン -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100 rounded-pill px-4 py-2">
                                <i class="fas fa-user-plus"></i> 会員登録
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