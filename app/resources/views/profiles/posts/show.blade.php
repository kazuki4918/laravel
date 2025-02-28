@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">投稿詳細</div>

        <div class="card-body">
          <div class="table-resopnsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>タイトル</th>
                  <th>内容</th>
                  <th>画像</th>
                  <th>金額</th>
                </tr>
              </thead>
              <tbody>
                @if(isset($post))
                <tr>
                  <td>{{ $post->title }}</td>
                  <td>{{ $post->content }}</td>
                  <td>
                    <div class="bl_imgContainer">
                      <img src="{{ Storage::url($post) }}" alt="投稿用画面">
                    </div>
                  </td>
                  <td>{{ $post->amount }}</td>
                </tr>
                @endif
              </tbody>
            </table>
            @if(isset($post))
            <div class="text-center">
                <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-secondary">戻る</a>
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">編集</a>

                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline"
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
