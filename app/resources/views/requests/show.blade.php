@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white text-center">
          <h5 class="mb-0">依頼内容</h5>
        </div>

        <div class="card-body">
          <div class="row">
            <!-- 左側: 依頼内容 -->
            <div class="col-md-6">
              <h6 class="fw-bold">依頼内容</h6>
              <div class="border p-3 rounded bg-light shadow-sm" style="min-height: 150px;">
                {{ $request->content }}
              </div>
            </div>

            <!-- 右側: 電話番号・メールアドレス・希望納期 -->
            <div class="col-md-6">
              <div class="mb-3">
                <h6 class="fw-bold">電話番号</h6>
                <p class="border p-2 rounded bg-light shadow-sm">{{ $request->tel }}</p>
              </div>

              <div class="mb-3">
                <h6 class="fw-bold">メールアドレス</h6>
                <p class="border p-2 rounded bg-light shadow-sm">{{ $request->email }}</p>
              </div>

              <div class="mb-3">
                <h6 class="fw-bold">希望納期</h6>
                <p class="border p-2 rounded bg-light shadow-sm">{{ $request->deadline }}</p>
              </div>
            </div>
          </div>

          <!-- ボタン配置 -->
          <div class="text-center mt-4">
            <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
              <i class="fas fa-arrow-left"></i> 戻る
            </a>
            <a href="{{ route('requests.edit', $request->id) }}" class="btn btn-outline-success rounded-pill px-4 py-2 mx-2">
              <i class="fas fa-edit"></i> 編集する
            </a>
            <form action="{{ route('requests.destroy', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-outline-danger rounded-pill px-4 py-2">
                <i class="fas fa-trash-alt"></i> 削除
              </button>
            </form>
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

  .form-control {
    border: 2px solid #ced4da;
    transition: 0.3s;
  }

  .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
  }

  .btn {
    font-weight: bold;
    transition: 0.3s;
  }

  .btn:hover {
    opacity: 0.8;
  }
</style>