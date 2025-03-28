@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="text-center mb-4">プロフィール</h2>

  @if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card shadow-lg p-4">
    <div class="card-body text-center">
      <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('images/default-avatar.png') }}"
        alt="User Image" class="rounded-circle shadow-lg" width="150" height="150">

      <h3 class="mt-3 text-primary">{{ $user->name }}</h3>
      <p class="text-muted">{{ $user->email }}</p>

      <a href="{{ route('profiles.edit', $user->id) }}" class="btn btn-outline-primary">
        <i class="fas fa-user-edit"></i> プロフィール編集
      </a>

      <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('requests.index') }}" class="btn btn-success w-50 me-2">
          <i class="fas fa-envelope-open-text"></i> 届いた依頼はこちら
        </a>
        <form action="{{ route('profiles.destroy', $user->id) }}" method="POST" class="w-50"
          onsubmit="return confirm('本当に退会しますか？');">
          @csrf
          <button type="submit" class="btn btn-danger w-100">
            <i class="fas fa-user-slash"></i> 退会
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- 投稿・依頼一覧 -->
<div class="container mt-5">
  <div class="row g-4">
    <!-- 投稿一覧 -->
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">投稿一覧</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>タイトル</th>
                  <th>内容</th>
                  <th>画像</th>
                  <th>金額</th>
                </tr>
              </thead>
              <tbody>
                @if(isset($posts) && count($posts) > 0)
                @foreach ($posts as $post)
                <tr>
                  <td>
                    <a href="{{ route('profiles.posts.show', $post->id) }}" class="text-dark text-decoration-none fw-bold">
                      {{ Str::limit($post->title, 20) }}
                    </a>
                  </td>
                  <td>{{ Str::limit($post->content, 20) }}</td>
                  <td>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="投稿画像"
                      class="rounded shadow-sm" width="50" height="50" style="object-fit: cover;">
                  </td>
                  <td class="text-primary fw-bold">{{ number_format($post->amount) }}円</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="4" class="text-center text-muted">投稿はありません</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- 依頼一覧 -->
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-header bg-success text-white text-center">依頼一覧</div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-light">
                <tr>
                  <th>依頼内容</th>
                  <th>電話番号</th>
                  <th>メール</th>
                  <th>希望納期</th>
                </tr>
              </thead>
              <tbody>
                @if(isset($requests) && count($requests) > 0)
                @foreach ($requests as $request)
                <tr>
                  <td>
                    <a href="{{ route('requests.show', $request->id) }}" class="text-dark text-decoration-none fw-bold">
                      {{ Str::limit($request->content, 20) }}
                    </a>
                  </td>
                  <td>{{ $request->tel }}</td>
                  <td>{{ $request->email }}</td>
                  <td class="text-danger fw-bold">{{ $request->deadline }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td colspan="4" class="text-center text-muted">依頼はありません</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- スタイル -->
<style>
  .shadow-lg {
    border-radius: 15px;
    transition: all 0.3s;
  }

  .shadow-lg:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
  }

  .btn {
    font-weight: bold;
  }

  .table th {
    text-align: center;
  }

  .table td {
    vertical-align: middle;
    text-align: center;
  }
</style>

@endsection