<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Events\ArticlePublished;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    protected static function booted()
    {
        static::created(function ($article) {
            event(new ArticlePublished($article));
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'article_id', 'user_id');
    }

    public function rates()
    {
        return $this->belongsToMany(User::class, 'rates', 'article_id', 'user_id')
            ->withPivot('rate');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
