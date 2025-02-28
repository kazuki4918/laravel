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
