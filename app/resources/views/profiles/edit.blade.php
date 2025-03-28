@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">プロフィール編集</h5>
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
                    <form action="{{ route('profiles.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- アイコン画像 -->
                        <div class="mb-4 text-center">
                            <label class="form-label d-block">現在のアイコン</label>
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('default-avatar.png') }}" 
                                 alt="User Avatar" class="rounded-circle" width="120" height="120">
                        </div>

                        <!-- 名前 -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">名前</label>
                            <input type="text" class="form-control form-control-lg rounded-pill shadow-sm" id="name" 
                                   name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <!-- メールアドレス -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">メールアドレス</label>
                            <input type="text" class="form-control form-control-lg rounded-pill shadow-sm" id="email" 
                                   name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <!-- アイコン画像アップロード -->
                        <div class="mb-4">
                            <label for="avatar" class="form-label fw-bold">アイコン画像 (任意)</label>
                            <input type="file" class="form-control form-control-lg rounded-pill shadow-sm" id="avatar" 
                                   name="image" accept="image/*">
                        </div>

                        <!-- ボタンエリア -->
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-outline-success rounded-pill px-4 py-2">
                                <i class="fas fa-save"></i> 更新
                            </button>
                            <a href="{{ route('profiles.show', $user->id) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 mx-3">
                                <i class="fas fa-times"></i> キャンセル
                            </a>
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
F