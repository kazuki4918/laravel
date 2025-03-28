@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">届いた依頼一覧</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="bg-light">
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
                                    <span class="badge bg-info text-white">掲載中</span>
                                    @elseif ($request->status === 1)
                                    <span class="badge bg-warning text-dark">進行中</span>
                                    @elseif ($request->status === 2)
                                    <span class="badge bg-success text-white">完了</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($request->status === 0)
                                    <form action="{{ route('requests.update_status', $request->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $request->status }}">
                                        <button type="submit" class="btn btn-outline-primary rounded-pill px-4 py-2">
                                            進行中へ
                                        </button>
                                    </form>
                                    @elseif ($request->status === 1)
                                    <form action="{{ route('requests.update_status', $request->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $request->status }}">
                                        <button type="submit" class="btn btn-outline-success rounded-pill px-4 py-2">
                                            完了へ
                                        </button>
                                    </form>
                                    @elseif ($request->status === 2)
                                    <form action="{{ route('requests.update_status', $request->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $request->status }}">
                                        <button type="submit" class="btn btn-outline-warning rounded-pill px-4 py-2">
                                            掲載中に戻す
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('profiles.show', ['profile' => Auth::user()->id]) }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 w-25">
                            <i class="fas fa-arrow-left"></i> 戻る
                        </a>
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

    .badge {
        font-weight: bold;
    }

    .table-striped tbody tr:hover {
        background-color: #f1f1f1;
    }
</style>