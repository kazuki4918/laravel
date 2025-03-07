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
    public function mainindex(Request $request)
    {

        if (Auth::check() && Auth::user()->del_flg == 1) {
            Auth::logout(); // ログアウト処理
            return redirect()->route('account.suspended');
        }
        
        $posts = Post::query();

        // タイトル検索（部分一致）
        if ($request->filled('keyword')) {
            $posts->where('title', 'like', '%' . $request->keyword . '%');
        }

        // 下限金額フィルター
        if ($request->filled('min_price')) {
            $posts->where('amount', '>=', $request->min_price);
        }

        // 上限金額フィルター
        if ($request->filled('max_price')) {
            $posts->where('amount', '<=', $request->max_price);
        }

        $amountpulldowns = config('amountpulldown.amount');

        // 検索結果を取得（無限スクロールなら simplePaginate() に変更）
        $posts = $posts->where('del_flg', 0)->orderBy('created_at', 'desc')->simplePaginate(6);

        if (Auth::check() && Auth::user()->role == 1) {
            return view('controls.top');
        }

        return view('main', [
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
        $posts = Post::query();

        // タイトル検索（部分一致）
        if ($request->filled('keyword')) {
            $posts->where('title', 'like', '%' . $request->keyword . '%');
        }

        // 下限金額フィルター
        if ($request->filled('min_price')) {
            $posts->where('amount', '>=', $request->min_price);
        }

        // 上限金額フィルター
        if ($request->filled('max_price')) {
            $posts->where('amount', '<=', $request->max_price);
        }

        // ページ数に基づいて新しい投稿を取得（ページネーション）
        $postsPerPage = 6; // 1ページあたりの投稿数
        $posts = $posts->where('del_flg', 0)->orderBy('created_at', 'desc')
            ->skip(($request->page - 1) * $postsPerPage)  // page 1 なら 0、page 2 なら 6、page 3 なら 12 といった具合に取得
            ->take($postsPerPage)
            ->get();

        // データをJSON形式で返す
        $postsHtml = view('posts.partials.posts', compact('posts'))->render(); // 投稿用の部分ビューを作成

        return response()->json([
            'posts' => $postsHtml,
            'next_page' => $posts->count() == $postsPerPage, // 次のページがあるか判定
        ]);
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
        // del_flg を 0 ⇄ 1 で切り替え
        $post->del_flg = $post->del_flg == 0 ? 1 : 0;
        $post->save();

        return back()->with('success', $post->del_flg == 1 ? '投稿を表示停止しました' : '投稿の表示を再開しました');
    }


    public function userstop(User $user)
    {
        // del_flg を 0 ⇄ 1 で切り替え
        $user->del_flg = $user->del_flg == 0 ? 1 : 0;
        $user->save();

        return back()->with('success', $user->del_flg == 1 ? 'ユーザーを利用停止しました' : 'ユーザーの利用を再開しました');
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
