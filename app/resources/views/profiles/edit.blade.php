@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center font-weight-bold">
                    <h5>プロフィール編集</h5>
                </div>
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
                    <form action="{{ route('profiles.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3 text-center">
                            <label class="form-label d-block">現在のアイコン</label>
                            @if($user->image)
                            <img src="{{ asset('storage/' . $user->image) }}" alt="User Avatar" class="rounded-circle" width="120" height="120">
                            @else
                            <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar" class="rounded-circle" width="120" height="120">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">名前</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">メールアドレス</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="avatar" class="form-label">アイコン画像 (任意)</label>
                            <input type="file" class="form-control" id="avatar" name="image" accept="image/*">
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success">更新</button>
                            <a href="{{ route('profiles.show', $user->id) }}" class="btn btn-secondary ml-3">キャンセル</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection