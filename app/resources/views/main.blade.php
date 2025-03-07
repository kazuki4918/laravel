@extends('layouts.app')

@section('content')
<div class="container">
  <form method="GET" action="{{ route('posts.index') }}" class="mb-4">
    <div class="row">
      <!-- 検索ボックス -->
      <div class="col-md-6">
        <input type="text" name="keyword" class="form-control" placeholder="タイトルを検索" value="{{ request('keyword') }}">
      </div>

      <div class="col-md-2">
        <select name="min_price" class="form-control">
          <option value="">下限金額</option>
          @foreach(config('amountpulldown.amount') as $amount)
          <option value="{{ $amount }}" {{ request('min_price') == $amount ? 'selected' : '' }}>
            {{ number_format($amount) }}円以上
          </option>
          @endforeach
        </select>
      </div>

      <!-- 上限金額プルダウン -->
      <div class="col-md-2">
        <select name="max_price" class="form-control">
          <option value="">上限金額</option>
          @foreach(config('amountpulldown.amount') as $amount)
          <option value="{{ $amount }}" {{ request('max_price') == $amount ? 'selected' : '' }}>
            {{ number_format($amount) }}円以下
          </option>
          @endforeach
        </select>
      </div>

      <!-- 検索ボタン -->
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary">検索</button>
      </div>
    </div>
  </form>

  <div class="justify-content-center">
    <div class="col-md-12">
      <a href="{{ route('posts.create') }}">
        <button type="button" class="btn btn-primary mb-3 d-block w-100">
          新規投稿
        </button>
      </a>
      <div class="card">
        <div class="card-header"><h5>投稿一覧</h5></div>

        <div class="row" id="post-container">
          @foreach ($posts as $post)
          <div class="col-md-4 col-sm-6 col-12 mb-4">
            <div class="card shadow-sm border-0">
              <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="投稿画像"
                style="height: 250px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title">
                  <a href="{{ route('posts.show', $post->id) }}" class="text-dark text-decoration-underline" style="font-weight: bold;">
                    {{ $post->title }}
                  </a>
                </h5>
                <p class="card-text text-muted">{{ Str::limit($post->content, 50) }}</p>
                <p class="text-primary font-weight-bold">{{ number_format($post->amount) }}円</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<div id="loading-message" class="text-center my-3" style="display: none;">
  <p>読み込み中...</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    let page = 2; // 最初のページは 2 番目のページからスタート
    let loading = false;
    let hasMorePosts = true;

    function loadMorePosts() {
      if (loading || !hasMorePosts) return;

      loading = true;
      $('#loading-message').show();

      $.ajax({
        url: "{{ route('posts.load') }}", // データを取得するためのルート
        type: "GET",
        data: {
          page: page,
          keyword: $('input[name="keyword"]').val(),
          min_price: $('select[name="min_price"]').val(),
          max_price: $('select[name="max_price"]').val()
        },
        dataType: "json", // サーバーからJSONで受け取る
        success: function(data) {
          if (!data.posts || data.posts.length === 0) {
            hasMorePosts = false; // 次の投稿がない場合
          } else {
            $('#post-container').append(data.posts); // 新しい投稿を追加
            page++; // 次のページへ
            if (!data.next_page) {
              hasMorePosts = false; // 次のページがない場合
            }
          }
          loading = false;
          $('#loading-message').hide();
        },
        error: function(xhr, status, error) {
          console.error("エラー:", error);
          loading = false;
          $('#loading-message').hide();
        }
      });
    }

    // スクロール時に自動でデータをロード
    $(window).scroll(function() {
      if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        loadMorePosts();
      }
    });
  });
</script>
@endsection