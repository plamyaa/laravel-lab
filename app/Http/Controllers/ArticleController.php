<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;

class ArticleController extends Controller
{
    public function index(){
        $articles = Article::latest()->paginate(5);
        return view('articles/index', ['articles' => $articles]);
    }

    public function create(){
        $this->authorize('create', [self::class]);
        return view('articles/create');
    }
    
    public function store(Request $request){
        $this->authorize('create', [self::class]);

        $request->validate([
            'name' => 'required',
            'annotation' =>'required|min:10',
        ]);
        $article = new Article();
        $article->name = request('name');
        $article->date = request('date');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $article->save();
        return redirect('/');
    }

    public function show($id){
        $article = Article::FindOrFail($id);
        $comments=Comment::where([
                            ['article_id', $id],
                            ['accept', 1]
                        ])->latest()->paginate(5);
        return view('articles.show', ['article' => $article, 'comments'=>$comments]);
    }

    public function edit($id){
        $article=Article::FindOrFail($id);
        $this->authorize('update', [self::class, $article]);
        return view('articles.edit', ['article'=>$article]);
    }

    public function update(Request $request, $id){
        
        $request->validate([
            'name' => 'required',
            'annotation' =>'required|min:10',
        ]);
        $article=Article::FindOrFail($id);
        $this->authorize('update', [self::class, $article]);
        $article->name = request('name');
        $article->date = request('date');
        $article->shortDesc = request('annotation');
        $article->desc = request('description');
        $article->save();
        return redirect()->route('show', ['id'=>$article->id]);
    }

    public function destroy($id){
        $article=Article::FindOrFail($id);
        $this->authorize('delete', [self::class, $article]);
        Comment::where('article_id', $id)->delete();
        $article->delete();
        return redirect('/');
    }
}
