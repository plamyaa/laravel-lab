<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/
//Auth
Route::get('/auth/registr', [AuthController::class, 'create']);
Route::post('/auth/registr', [AuthController::class, 'store']);
Route::get('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'customLogin']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

//Article
Route::group(['prefix'=>'/article', 'middleware'=>'auth:sanctum'], function(){
    Route::get('/create', [ArticleController::class, 'create']);
    Route::post('/store', [ArticleController::class, 'store']);
    Route::get('/show/{id}', [ArticleController::class, 'show'])->name('articles.show')->middleware('path');
    Route::get('/edit/{id}', [ArticleController::class, 'edit']);
    Route::put('/{id}', [ArticleController::class, 'update']);
    Route::get('/destroy/{id}', [ArticleController::class, 'destroy']);
});

//Comment
Route::resource('comment', CommentController::class);
Route::get('/comment/{comment}/accept', [CommentController::class, 'accept']);
Route::get('/comment/{comment}/reject', [CommentController::class, 'reject']);


// Route::get('/', [MainController::class, 'index']);
Route::get('/', [ArticleController::class, 'index']);
Route::get('/galery/{full}', [MainController::class, 'show']);


Route::get('/about', function () {
    return view('main/about');
});

Route::get('/contact', function () {
    $contact = [
        'name' => 'Политех',
        'adres' => 'Пряники',
        'phone' => '8(495)423-2323',
        'email' => '@mospolytech.ru',
    ];
    return view('main/contact', ['contact' => $contact]);
});