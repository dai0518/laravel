<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'recruit_title',
        'game_id',
        'discord_url',
        'comment',
        'user_id',
        'del_flg',
        
    ];

    public function categories()
{
    return $this->belongsToMany(Category::class, 'category_post');
}
public function user()
    {
        return $this->belongsTo(User::class);
    }
}