@extends('layouts.app')

@section('content')
<div class="container">
  <!-- 検索フォーム -->
  <form method="GET" action="{{ route('posts.index') }}" class="mb-4">
    <div class="row">
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
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">検索</button>
      </div>
    </div>
  </form>

  <!-- 投稿一覧 -->
  <div class="container-fluid bg-light py-3">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <a href="{{ route('posts.create') }}" class="btn btn-danger mb-3 d-block w-100 text-white">
          新規投稿
        </a>

        <div class="row" id="post-container">
          @foreach ($posts as $post)
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
            <div class="card shadow-sm border-0 youtube-card">
              <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top rounded-top" alt="投稿画像"
                style="height: 180px; object-fit: cover;">
              <div class="card-body">
                <h6 class="card-title font-weight-bold text-truncate">
                  <a href="{{ route('posts.show', $post->id) }}" class="text-dark text-decoration-none">
                    {{ Str::limit($post->title, 20) }}
                  </a>
                </h6>
                <p class="card-text text-muted small">{{ Str::limit($post->content, 30) }}</p>
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

<!-- ローディングメッセージ -->
<div id="loading-message" class="text-center my-3" style="display: none;">
  <p>読み込み中...</p>
</div>

<!-- スタイル -->
<style>
  .youtube-card {
    transition: 0.3s;
    background-color: white;
    border-radius: 10px;
  }

  .youtube-card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
  }
</style>

<!-- JavaScript -->
<script>
  let page = 1;
  let loading = false;

  // スクロールイベントを監視
  $(window).on('scroll', function() {
    // ページの下に達したときに次のページをロード
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !loading) {
      loading = true;
      page++;

      $('#loading-message').show(); // ローディングメッセージ表示

      // Ajaxリクエストを送信
      $.ajax({
        url: "{{ route('posts.loadMore') }}",
        method: 'GET',
        data: {
          page: page,
          keyword: $('input[name="keyword"]').val(),
          min_price: $('select[name="min_price"]').val(),
          max_price: $('select[name="max_price"]').val()
        },
        success: function(response) {
          $('#loading-message').hide(); // ローディングメッセージ非表示
          $('#post-container').append(response.posts); // 投稿を追加

          // 次のページがあれば次のページを読み込む
          if (!response.next_page) {
            $(window).off('scroll'); // 最後のページに達したらイベントを解除
          }

          loading = false;
        }
      });
    }
  });
</script>

@endsection