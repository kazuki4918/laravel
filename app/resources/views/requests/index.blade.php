@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>届いた依頼一覧</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>依頼内容</th>
                                <th>電話番号</th>
                                <th>メールアドレス</th>
                                <th>希望納期</th>
                                <th>ステータス</th>
                                <th>アクション</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requests as $request)
                            <tr>
                                <td>{{ Str::limit($request->content, 50) }}</td>
                                <td>{{ $request->tel }}</td>
                                <td>{{ $request->email }}</td>
                                <td>{{ $request->deadline }}</td>
                                <td>
                                    @if ($request->status === 0)
                                        掲載中
                                    @elseif ($request->status === 1)
                                        進行中
                                    @elseif ($request->status === 2)
                                        完了
                                    @endif
                                </td>
                                <td>
                                    @if ($request->status === 0)
                                        <form action="{{ route('requests.update_status', $request->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ $request->status }}">
                                            <button type="submit" class="btn btn-primary">進行中へ</button>
                                        </form>
                                    @elseif ($request->status === 1)
                                        <form action="{{ route('requests.update_status', $request->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ $request->status }}">
                                            <button type="submit" class="btn btn-success">完了へ</button>
                                        </form>
                                    @elseif ($request->status === 2)
                                        <form action="{{ route('requests.update_status', $request->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ $request->status }}">
                                            <button type="submit" class="btn btn-warning">掲載中に戻す</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-secondary w-25">戻る</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
