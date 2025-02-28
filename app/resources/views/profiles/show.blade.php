@extends('layouts.app')

@section('content')
<div class="container">
  <h2>プロフィール</h2>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card">
    <div class="card-body text-center">
      <img src="{{ $user->image ? asset('storage/images/' . $user->image) : asset('images/default-avatar.png') }}"
        alt="User Image" class="rounded-circle" width="150" height="150">


      <h3 class="mt-3">{{ $user->name }}</h3>
      <p>{{ $user->email }}</p>

      <a href="{{ route('profiles.edit', $user->id) }}" class="btn btn-primary">プロフィール編集</a>
      <div class="d-flex justify-content-end">
        <a href="{{ route('requests.index') }}" class="btn btn-success">届いた依頼はこちら</a>
        <form action="{{ route('profiles.destroy', $user->id) }}" method="POST" class="d-inline"
          onsubmit="return confirm('本当に退会しますか？');">
          @csrf
          <button type="submit" class="btn btn-danger ml-5">退会</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="container text-center">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">投稿一覧</div>
        <div class="card-body">
          <div class="table-resopnsive">
            <table class="table table-striped" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>
                  <th style="width: 25%;">タイトル</th>
                  <th style="width: 25%;">内容</th>
                  <th style="width: 25%;">画像</th>
                  <th style="width: 25%;">金額</th>
                </tr>
              </thead>
              <tbody>
                @if(isset($posts))
                @foreach ($posts as $post)
                <tr>
                  <td><a href="{{ route('profiles.posts.show', $post->id) }}">{{ $post->title }}</a></td>
                  <td>{{ $post->content }}</td>
                  <td>
                    <div class="bl_imgContainer">
                      <img src="{{ asset('storage/' . $post->image) }}" alt="投稿用画面" width="50" height="50" style="object-fit: cover;">
                    </div>
                  </td>
                  <td>{{ $post->amount }}</td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">依頼一覧</div>
        <div class="card-body">
          <div class="table-resopnsive">
            <table class="table table-striped" style="table-layout: fixed; width: 100%;">
              <thead>
                <tr>
                  <th style="width: 25%;">依頼内容</th>
                  <th style="width: 25%;">電話番号</th>
                  <th style="width: 25%;">メール</th>
                  <th style="width: 25%;">希望納期</th>
                </tr>
              </thead>
              </thead>
              <tbody>
                @if(isset($requests))
                @foreach ($requests as $request)
                <tr>
                  <td><a href="{{ route('requests.show', $request->id) }}">{{ $request->content }}</a></td>
                  <td>{{ $request->tel }}</td>
                  <td>{{ $request->email }}</td>
                  <td>{{ $request->deadline }}</td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection