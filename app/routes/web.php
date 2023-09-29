<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\UserController;

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
// マイページへのルート
Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage')->middleware('auth');
// マイページもっと見るリンク
Route::get('/mypage/load-more', 'MyPageController@loadMore')->middleware('auth');
// ユーザー情報変更フォーム
// ユーザーアイコン変更
Route::post('/change-avatar', 'UserController@changeAvatar')->name('changeAvatar');
//ユーザー名変更
Route::post('/change-username', [UserController::class, 'changeUsername'])->name('changeUsername');
//自身の投稿を論理削除
Route::post('/mypage/delete-post/{id}', [MyPageController::class, 'deletePost'])->name('deletePost');

// ログインページを表示
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
// ログイン処理
Route::post('/login', 'Auth\LoginController@login')->name('login');
// ログアウト処理
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// サインアップページを表示
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// サインアップ処理
Route::post('/register', 'Auth\RegisterController@register');

// 掲示板一覧ページ
Route::get('/post_list', [PostController::class, 'index'])->name('post_list');
// POSTメソッドでの投稿処理
Route::post('/post_list', [PostController::class, 'store']);

// カテゴリー関連のルート
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// 投稿系のルート
Route::get('/posts', [PostController::class, 'index']);
Route::get('/post/create', [PostController::class, 'create'])->name('post.create');
Route::get('/post_form', [PostController::class, 'showPostForm'])->name('post_form')->middleware('auth'); // ミドルウェアを追加
Route::post('/post/store', [PostController::class, 'store'])->name('post.store');
