@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">依頼内容</div>

        <div class="card-body">
          <div class="table-resopnsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>依頼内容</th>
                  <th>電話番号</th>
                  <th>メールアドレス</th>
                  <th>希望納期</th>
                </tr>
              </thead>
              <tbody>
                @if(isset($request))
                <tr>
                  <td>{{ $request->content }}</td>
                  <td>{{ $request->tel }}</td>
                  <td>{{ $request->email }}</td>
                  <td>{{ $request->deadline }}</td>
                </tr>
                @endif
              </tbody>
            </table>
            @if(isset($request))
            <div class="text-center">
                <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-secondary">戻る</a>
                <a href="{{ route('requests.edit', $request->id) }}" class="btn btn-success">編集する</a>
                <form action="{{ route('requests.destroy', $request->id) }}" method="POST" class="d-inline"
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
</div>
@endsection