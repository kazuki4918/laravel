@extends('layouts.app')

@section('content')
<div class="container">
    <h2>プロフィール編集</h2>

    <form action="{{ route('profiles.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

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

        <button type="submit" class="btn btn-success">更新</button>
        <a href="{{ route('profiles.show', $user->id) }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection
