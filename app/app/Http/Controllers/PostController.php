<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Post;
use App\Category;

class PostController extends Controller
{
    public function index(Request $request)
{
    $selectedCategoryId = $request->input('category_id');
    
    // dd($selectedCategoryId);

    // カテゴリーが "all" の場合はすべての投稿を取得
    if ($selectedCategoryId === 'all') {
        $posts = Post::all();
    } else {
        // 特定のカテゴリーに属する投稿を取得
        $category = Category::find($selectedCategoryId);

        if ($category) {
            $posts = $category->posts;
        } else {
            // カテゴリーが存在しない場合のエラーハンドリングやデフォルトの動作を設定
            $posts = Post::all(); // 例: すべての投稿を取得
        }
    }

    // 他のビューにデータを渡すなどの処理を追加

    return view('post_list', [
        'posts' => $posts,
        'categories' => Category::all(),
        'selectedCategoryId' => $selectedCategoryId,
    ]);
}




    public function create()
    {
        $categories = Category::all();
        return view('post.create', compact('categories'));
    }

    public function showPostForm()
    {
        $categories = Category::all();
        return view('post_form', ['categories' => $categories]);
    }

    public function store(Request $request)
{
   
    $categoryIds = json_decode($request->input('category_ids'), true);

    $validator = Validator::make($request->all(), [
        'recruit_title' => 'required|max:255',
        'game_id' => 'required|max:50',
        'discord_url' => 'required|url',
        'comment' => 'required',
        'category_ids' => 'required',
        'category_ids.*' => 'exists:categories,id',
    ]);

    if ($validator->fails()) {
        return redirect()
            ->back()
            ->withErrors($validator)
            ->withInput();
    }

    
    $post = new Post([
        'recruit_title' => $request->input('recruit_title'),
        'game_id' => $request->input('game_id'),
        'discord_url' => $request->input('discord_url'),
        'comment' => $request->input('comment'),
    ]);

    
    $post->save();

   
    $post->categories()->attach($categoryIds);

    return redirect()->route('post_list');
}
    

}
