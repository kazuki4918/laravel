<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Post;

use App\Models\Request as RequestModel;

use App\Models\Violation;

use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $post = Post::query();

        //タイトル検索（部分一致）
        if ($request->filled('keyword')) {
            $post->where('title', 'like', '%' . $request->keyword . '%');
        }

        //下限金額フィルター
        if ($request->filled('min_price')) {
            $post->where('amount', '>=', $request->min_price);
        }

        //上限金額フィルター
        if ($request->filled('max_price')) {
            $post->where('amount', '<=', $request->max_price);
        }

        $amountpulldowns = config('amountpulldown.amount');

        // 検索結果を取得（無限スクロールなら get()をsimplePaginate()に変更）
        $posts = $post->orderBy('created_at', 'desc')->take(8)->get();

        if (Auth::check() && Auth::user()->role == 1) {
            return view('controls.top');
        }


        // 記事一覧を表示
        return view('posts.index', [
            'posts' => $posts,
            'amountpulldowns' => $amountpulldowns,
        ]);
    }

    public function showPost(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }


        return view('profiles.posts.show', compact('post'));
    }

    public function create(Int $post_id)
    {
        $post = Post::findOrFail($post_id);

        // requests.create ビューへデータを渡す
        return view('requests.create', compact('post'));
    }

    public function updateStatus(Request $request, $id)
    {
        $req = RequestModel::findOrFail($id);

        // 依頼の所有者のみがステータスを変更できるようにする
        if ($req->user_id !== auth()->id()) {
            return redirect()->route('requests.index')->with('error', '権限がありません。');
        }

        if ($req->status == 0) {
            $req->status = 1;
        } elseif ($req->status == 1) {
            $req->status = 2;
        } elseif ($req->status == 2) {
            $req->status = 0;
        }

        $req->save();

        return redirect()->route('requests.index')->with('success', 'ステータスが更新されました。');
    }

    //　無限スクロール
    public function loadMore(Request $request)
    {
        $post = Post::query();
        // 検索条件を適用
        if ($request->filled('keyword')) {
            $post->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('min_price')) {
            $post->where('amount', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $post->where('amount', '<=', $request->max_price);
        } // ページネーションで次の10件を取得
        $posts = $post->orderBy('created_at', 'desc')->paginate(5, ['*'], 'page', $request->page);
        return response()->json([
            'posts' => view('posts.partials.posts', compact('posts'))->render(),
            'next_page' => $posts->nextPageUrl()
        ]);
        //return view('posts.partials.posts', compact('posts'))->render();
    }

    public function controlUser()
    {
        // 表示停止された投稿の件数が多い順にユーザーを取得
        $users = User::withCount(['post' => function ($query) {
            $query->where('del_flg', 1); // 表示停止された投稿のみカウント
        }])
            ->orderByDesc('post_count') // 件数の多い順に並べる
            ->take(10) // 上位 10 人のみ取得
            ->get();

        return view('controls.user', compact('users'));
    }

    public function controlPost()
    {
        // 違反報告数が多い順に並び替えて、上位 20 件を取得
        $posts = Post::withCount('violations')
            ->orderByDesc('violations_count') // 違反報告数の多い順に並べる
            ->take(20) // 上位 20 件
            ->get();

        return view('controls.post', compact('posts'));
    }

    public function poststop(Post $post)
    {
        $post->del_flg = 1;
        $post->save();

        return back()->with('success', '表示停止しました');
    }

    public function userstop(User $user)
    {
        $user->del_flg = 1;
        $user->save();

        return back()->with('success', '利用停止しました');
    }


    public function storeViolation(Request $request, $postId)
    {
        Violation::create([
            'post_id' => $postId,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', '違反報告を送信しました');
    }
}
