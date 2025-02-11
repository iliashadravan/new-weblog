<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Tests\Integration\Database\EloquentHasManyThroughTest\Category;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body' ,
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_categories');
    }
}
