<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use App\Events\NewArticleEvent;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewArticleNotify;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index(){
        $currentPage = request('page');
        $articles = Cache::remember('articles:all1'.$currentPage, 2000, function() {
            return Article::latest()->paginate(5);
        });
        return view('articles/index', ['articles' => $articles]);
    }

    public function create(){
        $this->authorize('create', [self::class]);
        return view('articles/create');
    }
    
    public function store(Request $request){
        $this->authorize('create', [self::class]);

        $caches = DB::table('cache')->whereRaw('`key` GLOB :name', ['name'=>'laravel_cachearticles:all*[0-9]'])->get();
        foreach($caches as $cache) {
            Cache::forget($cache->key);
        }

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
        $users = User::where('id', '!=', auth()->id())->get();
        Notification::send($users, new NewArticleNotify($article));
        event(new NewArticleEvent($article->name));
        return redirect('/');
    }

    public function show($id){
        if(isset($_GET['notify'])){
            auth()->user()->notifications()->where('id',$_GET['notify'])->first()->markAsRead();
        }
        $array = Cache::rememberForever('article/show/' .$id, function()use($id){
            $article = Article::FindOrFail($id);
            $comments = Comment::where([['article_id', $id],['accept', 1]])->latest()->paginate(5);
            return ['article'=>$article, 'comments'=>$comments];
        });
        
        //$comments=Comment::where([['article_id', $id],['accept', 1]])->latest()->paginate(5);
        return view('articles.show', $array);
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
        Cache::flush();
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
        Cache::flush();
        $article=Article::FindOrFail($id);
        $this->authorize('delete', [self::class, $article]);
        Comment::where('article_id', $id)->delete();
        $article->delete();
        return redirect('/');
    }
}
