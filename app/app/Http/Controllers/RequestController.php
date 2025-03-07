<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use App\Models\Post;

use App\Models\Request as RequestModel;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = RequestModel::where('user_id', auth()->id())->get();
        return view('requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Int $post_id)
    {
        $post = Post::findOrFail($post_id);

        // requests.create ビューへデータを渡す
        return view('requests.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // バリデーションルール
        $request->validate([
            'content' => 'required|string|max:1000',  // 依頼内容は必須、文字列、最大1000文字
            'tel' => 'nullable|numeric|digits_between:10,15',  // 電話番号は必須、数値、10〜15桁
            'email' => 'required|email|max:255',  // メールアドレスは必須、メール形式、最大255文字
            'deadline' => 'nullable|date|after_or_equal:today',  // 希望納期は必須、日付、今日以降の日付
        ], [
            // カスタムメッセージ（日本語に変更）
            'content.required' => '依頼内容は必須です。',
            'content.string' => '依頼内容は文字列でなければなりません。',
            'content.max' => '依頼内容は1000文字以内で入力してください。',
            'tel.numeric' => '電話番号は数字でなければなりません。',
            'tel.digits_between' => '電話番号は10〜15桁の数字でなければなりません。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'deadline.date' => '希望納期は日付形式で入力してください。',
            'deadline.after_or_equal' => '希望納期は今日以降の日付で入力してください。',
        ]);

        $req = new requestModel;

        $req->content = $request->content;
        $req->tel = $request->tel;
        $req->email = $request->email;
        $req->deadline = $request->deadline;
        $req->post_id = $request->post_id;
        $req->user_id = auth()->id();

        $req->save();

        return redirect()->route('posts.show', $request->post_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RequestModel $request)
    {
        if ($request->user_id !== Auth::id()) {
            abort(403);
        }


        return view('requests.show', compact('request'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $request = RequestModel::findOrFail($id);
        return view('requests.edit', compact('request'));
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

        // バリデーションルール
        $request->validate([
            'content' => 'required|string|max:1000',  // 依頼内容は必須、文字列、最大1000文字
            'tel' => 'nullable|numeric|digits_between:10,15',  // 電話番号は必須、数値、10〜15桁
            'email' => 'required|email|max:255',  // メールアドレスは必須、メール形式、最大255文字
            'deadline' => 'nullable|date|after_or_equal:today',  // 希望納期は必須、日付、今日以降の日付
        ], [
            // カスタムメッセージ（日本語に変更）
            'content.required' => '依頼内容は必須です。',
            'content.string' => '依頼内容は文字列でなければなりません。',
            'content.max' => '依頼内容は1000文字以内で入力してください。',
            'tel.required' => '電話番号は必須です。',
            'tel.numeric' => '電話番号は数字でなければなりません。',
            'tel.digits_between' => '電話番号は10〜15桁の数字でなければなりません。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内で入力してください。',
            'deadline.required' => '希望納期は必須です。',
            'deadline.date' => '希望納期は日付形式で入力してください。',
            'deadline.after_or_equal' => '希望納期は今日以降の日付で入力してください。',
        ]);

        $req = RequestModel::find($id);

        $req->fill($request->all())->save();

        return redirect()->route('requests.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $req = RequestModel::find($id);

        $req->delete();

        $user_id = Auth::id();

        return redirect()->route('profiles.show', $user_id);
    }
}
