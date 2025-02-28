@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card mt-5">
        <div class="card-header">
          <div class="text-center">
            管理者ページ
          </div>
        </div>

        <div class="card-body" style="height: 300px;">
          <div class="table-resopnsive">
            
            <div class="text-center">
                <div class="btn-group-vertical" style="width: 300px;">
                        <a href="{{ route('controls.user') }}" class="btn btn-primary mt-5">ユーザーリスト</a>
                        <a href="{{ route('controls.post') }}" class="btn btn-primary mt-5">投稿リスト</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection