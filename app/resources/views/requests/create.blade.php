@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="text-center">
                        <h5>新規依頼</h5>
                    </div>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('requests.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">

                        <!-- 依頼内容 -->
                        <div class="form-group row">
                            <label for="content" class="col-md-2 col-form-label text-md-right">依頼内容</label>
                            <div class="col-md-9">
                                <textarea name="content" id="content" class="form-control" style="resize: none; height: 200px;">{{ old('content') }}</textarea>
                            </div>
                        </div>

                        <!-- 電話番号 -->
                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label text-md-right">電話番号</label>
                            <div class="col-md-9">
                                <input type="text" id="phone" name="tel" class="form-control" value="{{ old('tel') }}">
                            </div>
                        </div>

                        <!-- メールアドレス -->
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">メールアドレス</label>
                            <div class="col-md-9">
                                <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                            </div>
                        </div>

                        <!-- 希望納期 -->
                        <div class="form-group row">
                            <label for="deadline" class="col-md-2 col-form-label text-md-right">希望納期</label>
                            <div class="col-md-9">
                                <input type="date" id="deadline" name="deadline" class="form-control" value="{{ old('deadline') }}">
                            </div>
                        </div>

                        <!-- ボタン -->
                        <div class="form-group text-center">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary" onClick="history.back()">戻る</button>
                                <button type="submit" class="btn btn-primary mx-2" name='action' value='add'>
                                    依頼
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection