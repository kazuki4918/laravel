@extends('layouts.app')

@section('content')
<div class="container">
  <form method="GET" action="{{ route('main') }}" class="mb-4">
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
      <div class="card">
        <div class="card-header">投稿一覧</div>

        <div class="card-body">
          <a href="{{ route('posts.create') }}">
            <button type="button" class="btn btn-primary mb-3 d-block w-100">
              新規投稿
            </button>
          </a>

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
              <tbody id="post-container">
                @if(isset($posts))
                @foreach ($posts as $post)
                <tr>
                  <td><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></td>
                  <td>{{ $post->content }}</td>
                  <td>
                    <div class="bl_imgContainer">
                      <img src="{{ asset('storage/' . $post->image) }}" alt="投稿用画面" width="150" height="150" style="object-fit: cover;">
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
  </div>
</div>

<div id="loading-message" class="text-center my-3" style="display: none;">
  <p>読み込み中...</p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    let page = 2;
    let loading = false;
    let hasMorePosts = true;


    function loadMorePosts() {
      if (loading || !hasMorePosts) return;

      loading = true;
      $('#loading-message').show();

      $.ajax({
        url: "{{ route('posts.load') }}",
        type: "GET",
        data: {
          page: page,
          keyword: $('input[name="keyword"]').val(),
          min_price: $('select[name="min_price"]').val(),
          max_price: $('select[name="max_price"]').val()
        },
        dataType: "json", // JSON を受け取る
        success: function(data) {
          if (!data.posts || data.posts.length === 0) {
            hasMorePosts = false; // 投稿がない場合
          } else {
            $('#post-container').append(data.posts); // 取得したHTMLを追加
            page++;
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

    // スクロール時にデータを追加
    $(window).scroll(function() {
      if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        loadMorePosts();
      }
    });
  });
</script>
@endsection