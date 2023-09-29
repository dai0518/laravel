<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Post;
use App\Category;

class PostController extends Controller
{
    public function index(Request $request)
{
    $selectedCategoryIds = $request->input('category_ids', []);

    $posts = Post::when(count($selectedCategoryIds) > 0, function ($query) use ($selectedCategoryIds) {
        foreach ($selectedCategoryIds as $categoryId) {
            $query->whereHas('categories', function ($subQuery) use ($categoryId) {
                $subQuery->where('id', $categoryId);
            });
        }
    })
    ->where('del_flg', 0)  
    ->orderBy('created_at', 'desc')
    ->get();

    return view('post_list', [
        'posts' => $posts,
        'categories' => Category::all(),
        'selectedCategoryIds' => $selectedCategoryIds,
    ]);
}


    public function create()
    {
         // カテゴリ一覧を取得して新規投稿作成ビューに渡す
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

    if (Auth::check()) {
        $userId = Auth::id();

        $categoryIds = json_decode($request->input('category_ids'), true);

        $validator = Validator::make($request->all(), [
            'recruit_title' => 'required|max:255',
            'game_id' => 'required|max:50',
            'discord_url' => 'required|url',
            'comment' => 'required',
            'category_ids.*' => 'exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        // 新規投稿を作成
        Post::create([
            'user_id' => $userId,
            'recruit_title' => $request->recruit_title,
            'game_id' => $request->game_id,
            'discord_url' => $request->discord_url,
            'comment' => $request->comment,
            'updated_at' => now(),
            'created_at' => now(),
        ]);
         // 最新の投稿を取得
        $post = Post::latest()->first();
        $post->categories()->attach($categoryIds);

        return redirect()->route('post_list');
    }
}
}