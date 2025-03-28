@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header bg-primary text-white text-center">
          <h5 class="mb-0">管理者ページ</h5>
        </div>

        <div class="card-body text-center" style="height: 300px;">
          <div class="d-flex justify-content-center align-items-center h-100">
            <div class="btn-group-vertical" style="width: 300px;">
              <a href="{{ route('controls.user') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 mb-4">
                ユーザーリスト
              </a>
              <a href="{{ route('controls.post') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 mb-4">
                投稿リスト
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

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

  .btn-group-vertical .btn {
    margin: 5px 0;
  }
</style>
