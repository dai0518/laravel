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
        // 他の必要なフィールドもここに含めてください
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}