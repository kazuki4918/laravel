@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header"><h5>依頼内容</h5></div>

        <div class="card-body">
          <div class="row">
            <!-- 左側: 依頼内容 -->
            <div class="col-md-6">
              <h6 class="fw-bold">依頼内容</h6>
              <div class="border p-3 rounded bg-light" style="min-height: 150px;">
                {{ $request->content }}
              </div>
            </div>

            <!-- 右側: 電話番号・メールアドレス・希望納期 -->
            <div class="col-md-6">
              <div class="mb-3">
                <h6 class="fw-bold">電話番号</h6>
                <p class="border p-2 rounded bg-light">{{ $request->tel }}</p>
              </div>

              <div class="mb-3">
                <h6 class="fw-bold">メールアドレス</h6>
                <p class="border p-2 rounded bg-light">{{ $request->email }}</p>
              </div>

              <div class="mb-3">
                <h6 class="fw-bold">希望納期</h6>
                <p class="border p-2 rounded bg-light">{{ $request->deadline }}</p>
              </div>
            </div>
          </div>

          <!-- ボタン配置 -->
          <div class="text-center mt-3">
            <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-secondary">戻る</a>
            <a href="{{ route('requests.edit', $request->id) }}" class="btn btn-success mx-2">編集する</a>
            <form action="{{ route('requests.destroy', $request->id) }}" method="POST" class="d-inline"
              onsubmit="return confirm('本当に削除しますか？');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger">削除</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection