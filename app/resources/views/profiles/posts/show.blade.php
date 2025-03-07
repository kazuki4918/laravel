@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header text-center">
          <h5>投稿詳細</h5> <!-- 投稿詳細に変更 -->
        </div>

        <div class="card-body">
          <div class="row">
            <!-- 画像とタイトル部分を左側に配置 -->
            <div class="col-md-6 text-center">
              <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像" 
                   class="border rounded shadow-sm bg-light" 
                   style="width: 300px; height: 300px; object-fit: cover; border-radius: 15px;">
            </div>

            <!-- タイトルと投稿内容部分を右側に配置 -->
            <div class="col-md-6">
              <!-- 投稿タイトル -->
              <h5 class="font-weight-bold text-center mt-3">{{ $post->title }}</h5> <!-- タイトルを上に配置 -->

              <!-- 投稿内容 -->
              <h6 class="font-weight-bold">投稿内容</h6>
              <div class="border p-3 rounded bg-light shadow-sm" style="min-height: 150px;">
                <p>{{ $post->content }}</p>
              </div>

              <!-- 金額 -->
              <h6 class="font-weight-bold mt-3">金額</h6>
              <p class="border p-2 rounded bg-light shadow-sm text-primary font-weight-bold">
                {{ number_format($post->amount) }}円
              </p>
            </div>
          </div>

          <!-- ボタンエリア -->
          @if(isset($post))
          <div class="text-center mt-4">
            <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-secondary">戻る</a>
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success mx-3">編集</a>

            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">削除</button>
            </form>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
