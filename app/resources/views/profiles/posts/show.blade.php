@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center">
          <h5 class="mb-0">投稿詳細</h5>
        </div>

        <div class="card-body">
          <div class="row">
            <!-- 画像部分 -->
            <div class="col-md-6 text-center">
              <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像"
                class="border rounded shadow-lg bg-white"
                style="width: 100%; max-width: 350px; height: auto; object-fit: cover; border-radius: 15px;">
            </div>

            <!-- タイトル & 投稿内容 -->
            <div class="col-md-6">
              <h5 class="font-weight-bold text-primary text-center mt-3">{{ $post->title }}</h5>

              <!-- 投稿内容 -->
              <h6 class="font-weight-bold mt-3">投稿内容</h6>
              <div class="border p-3 rounded bg-light shadow-sm" style="min-height: 150px;">
                <p class="mb-0">{{ $post->content }}</p>
              </div>

              <!-- 金額 -->
              <h6 class="font-weight-bold mt-3">金額</h6>
              <p class="border p-2 rounded bg-light shadow-sm text-danger font-weight-bold text-center"
                style="font-size: 1.2rem;">
                {{ number_format($post->amount) }}円
              </p>
            </div>
          </div>

          <!-- ボタンエリア -->
          @if(isset($post))
          <div class="text-center mt-4">
            <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-outline-secondary rounded-pill px-4">
              <i class="fas fa-arrow-left"></i> 戻る
            </a>
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-success rounded-pill px-4 mx-2">
              <i class="fas fa-edit"></i> 編集
            </a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger rounded-pill px-4">
                <i class="fas fa-trash-alt"></i> 削除
              </button>
            </form>
          </div>
          @endif
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

  .btn {
    font-weight: bold;
    transition: 0.3s;
  }

  .btn:hover {
    opacity: 0.8;
  }
</style>

@endsection