@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">新規依頼</div>
                <div class="card-body">
                    <form action="{{ route('requests.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="form-group row">
                            <label for="body" class="col-md-2 col-form-label text-md-right">依頼内容</label>
                            <div class="col-md-9">
                                <textarea name="content" id="body" style="resize: none; height: 200px; width: 100%">{{ old('content') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">電話番号</label>
                            <input type="text" id="phone" name="tel" class="form-control" required value="{{ old('tel') }}">
                        </div>
                
                        <div class="mb-3">
                            <label for="email" class="form-label">メールアドレス</label>
                            <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>
                
                        <div class="mb-3">
                            <label for="deadline" class="form-label">希望納期</label>
                            <input type="date" id="deadline" name="deadline" class="form-control" required value="{{ old('deadline') }}">
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-secondary" onClick="history.back()">戻る</button>
                                <button type="submit" class="btn btn-primary ml-3" name='action' value='add'>
                                    依頼する
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
