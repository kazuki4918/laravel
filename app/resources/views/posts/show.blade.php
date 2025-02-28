@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">投稿詳細</div>

        <div class="card-body">
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
              <tbody>
                @if(isset($post))
                <tr>
                  <td>{{ $post->title }}</td>
                  <td>{{ $post->content }}</td>
                  <td>
                    <div class="bl_imgContainer">
                      <img src="{{ asset('storage/' . $post->image) }}" alt="投稿用画面" width="150" height="150" style="object-fit: cover;">
                    </div>
                  </td>
                  <td>{{ $post->amount }}</td>
                </tr>
                @endif
              </tbody>
            </table>
            @if(isset($post))
            <div class="text-center">
              <a href="{{ route('posts.index') }}" class="btn btn-secondary">戻る</a>
              <a href="{{ route('request.create', $post->id) }}" class="btn btn-success">依頼</a>
              <form action="{{ route('violation.store', $post->id) }}" method="POST" class="d-inline"
                onsubmit="return confirm('本当に違反報告しますか？');">
                @csrf
                <button type="submit" class="btn btn-danger">違反報告</button>
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