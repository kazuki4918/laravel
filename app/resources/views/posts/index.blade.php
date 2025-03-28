@extends('layouts.app')

@section('content')
<div class="container">
  <!-- 検索フォーム -->
  <form method="GET" action="{{ route('posts.index') }}" class="mb-4">
    <div class="row g-2">
      <div class="col-md-6">
        <input type="text" name="keyword" class="form-control rounded-pill" placeholder="タイトルを検索" value="{{ request('keyword') }}">
      </div>
      <div class="col-md-2">
        <select name="min_price" class="form-control rounded-pill">
          <option value="">下限金額</option>
          @foreach(config('amountpulldown.amount') as $amount)
          <option value="{{ $amount }}" {{ request('min_price') == $amount ? 'selected' : '' }}>
            {{ number_format($amount) }}円以上
          </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select name="max_price" class="form-control rounded-pill">
          <option value="">上限金額</option>
          @foreach(config('amountpulldown.amount') as $amount)
          <option value="{{ $amount }}" {{ request('max_price') == $amount ? 'selected' : '' }}>
            {{ number_format($amount) }}円以下
          </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100 rounded-pill">検索</button>
      </div>
    </div>
  </form>

  <!-- 投稿一覧 -->
  <div class="container-fluid bg-light py-4 rounded">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <a href="{{ route('posts.create') }}" class="btn btn-danger mb-3 d-block w-100 text-white rounded-pill">
          + 新規投稿
        </a>

        <div class="row" id="post-container">
          @foreach ($posts as $post)
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
            <div class="card shadow-lg border-0 youtube-card rounded">
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
  body {
    background-color: #f8f9fa;
  }

  .youtube-card {
    transition: 0.3s;
    background-color: white;
    border-radius: 15px;
  }

  .youtube-card:hover {
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
  }

  .rounded-pill {
    border-radius: 50px !important;
  }

  .btn-primary,
  .btn-danger {
    font-weight: bold;
    transition: 0.3s;
  }

  .btn-primary:hover,
  .btn-danger:hover {
    opacity: 0.8;
  }
</style>

<!-- JavaScript -->
<script>
  let page = 1;
  let loading = false;

  $(window).on('scroll', function() {
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !loading) {
      loading = true;
      page++;

      $('#loading-message').show();

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
          $('#loading-message').hide();
          $('#post-container').append(response.posts);

          if (!response.next_page) {
            $(window).off('scroll');
          }

          loading = false;
        }
      });
    }
  });
</script>

@endsection