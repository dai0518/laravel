<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('post_list', ['categories' => $categories]);
    }
}
