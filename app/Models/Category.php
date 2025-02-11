<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = 'name';

    public function article()
    {
        return $this->belongsToMany(Article::class , 'article_category');
    }
}
