<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use App\User;

use App\Models\Post;

use App\Models\Request as RequestModel;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $profile)
    {
        $user = $profile;
        $user_id = Auth::id();
        $post = new Post();
        $request = new RequestModel();
        $posts = $post->where('user_id', $user_id)->where('del_flg', 0)->get();
        $requests = $request->where('user_id', $user_id)->where('del_flg', 0)->get();

        return view('profiles.show', compact('user', 'posts', 'requests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',  // 名前は必須、最大255文字
            'email' => 'required|string|email|max:255', // メールアドレスは必須、メール形式、最大255文字
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像は任意、画像ファイルのみ、最大2MB
        ],[
            'name.required' => '名前は必須です。',
            'name.string' => '名前は文字列でなければなりません。',
            'name.max' => '名前は255文字以内で入力してください。',
            
            'email.required' => 'メールアドレスは必須です。',
            'email.string' => 'メールアドレスは文字列でなければなりません。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            
            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => 'JPEG、PNG、JPG、GIF形式の画像ファイルのみアップロードできます。',
            'image.max' => '画像のサイズは最大2MBまでです。',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($user->image) {
                \Storage::disk('public')->delete($user->image);
            }

            // 新しい画像を保存
            $path = $request->file('image')->store('images', 'public');
            $user->image = $path;
        }

        $user->save();

        return redirect()->route('profiles.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->avatar) {
            \Storage::disk('public')->delete('avatars/' . $user->avatar);
        }
        Auth::logout();
        $user->delete();

        return redirect('/');
    }
}
