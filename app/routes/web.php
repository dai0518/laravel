<?php
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
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

Route::get('/', function () {
    return view('home');
});

// 掲示板一覧ページ
Route::get('/post_list', [PostController::class, 'index'])->name('post_list'); // GETメソッドで表示

// POSTメソッドでの投稿処理
Route::post('/post_list', [PostController::class, 'store']);

// カテゴリー関連のルート
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// 投稿系のルート
Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::get('/post_form', [PostController::class, 'showPostForm'])->name('post_form');
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');