<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request;
use App\Post;
use App\Category;
class MyPageController extends Controller
{   
    public function __construct()
{
    $this->middleware('auth');
}
    public function index(){
        //認証ユーザーで論理削除されてない投稿を表示
        $user = Auth::user();
        $posts = $user->posts()
        ->where('del_flg', 0)
        ->orderBy('created_at', 'desc')
        ->get();
        return view('auth.mypage', ['posts' => $posts]);
    }
    

        public function showLoginForm()
    {
        return view('login');
    }

    public function loadMore(Request $request)
{
        //もっとみるリンクで表示する内容
        $user = Auth::user();
        $offset = $request->input('offset', 0);
        $posts = $user->posts()
            ->with('categories')
            ->where('del_flg', 0)
            ->orderBy('created_at', 'desc')
            ->skip($offset)
            ->take(3)
            ->get();

        return response()->json(['posts' => $posts]);
    
}

    public function deletePost($id)
    {
        // 論理削除
        $post = Post::find($id);

        if ($post) {
            $post->del_flg = 1;
            $post->save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
}





