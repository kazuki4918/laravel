<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->del_flg == 1) {
            Auth::logout(); // ログアウト処理
            return redirect()->route('account.suspended');
        }

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
        $posts = $post->where('del_flg', 0)->orderBy('created_at', 'desc')->take(6)->get();

        if (Auth::check() && Auth::user()->role == 1) {
            return view('controls.top');
        }


        // 記事一覧を表示
        return view('posts.index', [
            'posts' => $posts,
            'amountpulldowns' => $amountpulldowns,
        ]);
    }

    public function create()
    {
        // 投稿画面表示
        return view('posts/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',  // タイトルは必須、最大255文字
            'content' => 'required|string',        // 内容は必須
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像は任意、画像ファイルのみ、最大2MB
            'amount' => 'required|numeric|min:1',  // 金額は必須、1以上の数値
        ], [
            'title.required' => 'タイトルは必須です。',
            'title.string' => 'タイトルは文字列でなければなりません。',
            'title.max' => 'タイトルは50文字以内で入力してください。',

            'content.required' => '内容は必須です。',
            'content.string' => '内容は文字列でなければなりません。',

            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => '画像はJPEG、PNG、JPG、GIFのいずれかの形式である必要があります。',
            'image.max' => '画像のサイズは最大2MBまでです。',

            'amount.required' => '金額は必須です。',
            'amount.numeric' => '金額は数字でなければなりません。',
            'amount.min' => '金額は1以上の数値である必要があります。',
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

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        //$post = Post::findOrFail($post);

        return view('posts.show', ['post' => $post]);
    }

    public function edit($id)
    {
        $post = Post::find($id);

        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Int $id)
    {
        $request->validate([
            'title' => 'required|string|max:50',  // タイトルは必須、最大50文字
            'content' => 'required|string',        // 内容は必須
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像は任意、画像ファイルのみ、最大2MB
            'amount' => 'required|numeric|min:1',  // 金額は必須、1以上の数値
        ], [
            'title.required' => 'タイトルは必須です。',
            'title.string' => 'タイトルは文字列でなければなりません。',
            'title.max' => 'タイトルは50文字以内で入力してください。',

            'content.required' => '内容は必須です。',
            'content.string' => '内容は文字列でなければなりません。',

            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => '画像はJPEG、PNG、JPG、GIFのいずれかの形式である必要があります。',
            'image.max' => '画像のサイズは最大2MBまでです。',

            'amount.required' => '金額は必須です。',
            'amount.numeric' => '金額は数字でなければなりません。',
            'amount.min' => '金額は1以上の数値である必要があります。',
        ]);

        $post = Post::findOrFail($id);

        // 画像アップロード処理
        if ($request->hasFile('image')) {
            // 既存の画像がある場合は削除
            if ($post->image) {
                \Storage::disk('public')->delete($post->image);
            }

            // 新しい画像を保存
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        // その他のフィールドを更新
        $post->title = $request->title;
        $post->content = $request->content;
        $post->amount = $request->amount;

        $post->save();

        return redirect()->route('profiles.posts.show', $id)->with('success', '投稿を更新しました');
    }

    public function destroy(Int $id)
    {
        $post = Post::find($id);

        $post->delete();

        $user_id = Auth::id();

        return redirect()->route('profiles.show', $user_id);
    }
}
