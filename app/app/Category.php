<?php

namespace App;
use App\Post;
use App\Category;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
{
    return $this->belongsToMany(Post::class, 'category_post');
}

    
}


