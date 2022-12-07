<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Jobs\VeryLongJob;


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
            'text'=>'required',
        ]);
        
        $comment = new Comment();
        $comment->title = request('title');
        $comment->text = $request->text;//запись аналогична записи сверху
        $comment->article()->associate(request('id'));
        $result = $comment->save();
        $article = Article::FindOrFail(request('id'));
        VeryLongJob::dispatch($article, $comment);
        return redirect()->route('articles.show', ['id'=>request('id'), 'result'=>$result]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        Gate::authorize('update-comment', $comment);
        return view('comments.edit', ['comment'=>$comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('update-comment', $comment);

        $request->validate([
            'title' => 'required',
            'text'=>'required',
        ]);

        $comment->title = request('title');
        $comment->text = request('text');
        $comment->save();
       return redirect()->route('articles.show', ['article'=>$comment->article_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('update-comment', $comment);
        $comment->delete();
        return redirect()->route('articles.show', ['article'=>$comment->article_id]);

    }
}