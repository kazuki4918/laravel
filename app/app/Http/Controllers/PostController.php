<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 投稿画面表示
        return view('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',  // タイトルは必須、最大255文字
            'content' => 'required|string',        // 内容は必須
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像は任意、画像ファイルのみ、最大2MB
            'amount' => 'required|numeric|min:1',  // 金額は必須、1以上の数値
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->amount = $request->amount;
        $post->user_id = Auth::id(); 

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('images', 'public');
        }

        $post->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //$post = Post::findOrFail($post);

        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Int $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',  // タイトルは必須、最大255文字
            'content' => 'required|string',        // 内容は必須
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像は任意、画像ファイルのみ、最大2MB
            'amount' => 'required|numeric|min:1',  // 金額は必須、1以上の数値
        ]);

        $post = Post::find($id);

        $post->fill($request->all())->save();

        return redirect()->route('profiles.posts.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $post = Post::find($id);

        $post->delete();

        $user_id = Auth::id();

        return redirect()->route('profiles.show', $user_id);
    }
}
