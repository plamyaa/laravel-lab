<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\Article;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::where('accept', null)->latest()->paginate(10);
        return view('comments.index', ['comments'=>$comments]);
    }

    public function accept(Comment $comment){
        $comment->accept = 1;
        $comment->save();
        return redirect()->back();
    }

    public function reject(Comment $comment){
        $comment->accept = 0;
        $comment->save();
        return redirect()->back();
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
        $request->validate([
            'title' => 'required',
            'text' => 'required',
        ]);
        $comment = new Comment();
        $comment->title = request('title');
        $comment->text = request('text');
        $comment->article()->associate(request('id'));
        $comment->user()->associate(auth()->user());
        $result = $comment->save();
        $article = Article::where('id', $comment->article_id)->first();
        if ($request){
            $msg = new TestMail($article, $comment);
            Mail::send($msg);
        }
        return redirect()->route('show', ['id'=>request('id'), 'result'=>$result]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::FindOrFail($id);
        Gate::authorize('update-comment', $comment);
        return view('comments.edit', ['comment' => $comment]);
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
            'title' => 'required',
            'text' => 'required',
        ]);
        $comment = Comment::FindOrFail($id);
        Gate::authorize('update-comment', $comment);
        $comment->title = request('title');
        $comment->text = request('text');
        $comment->save();
        return redirect()->route('show', ['id' => $comment->article_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::FindOrFail($id);
        Gate::authorize('update-comment', $comment);
        $comment->delete();
        return redirect()->route('show', ['id' => $comment->article_id]);
    }
}