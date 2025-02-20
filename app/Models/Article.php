<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Service\SmsService;
use App\Models\User;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id'];

    protected static function booted()
    {
        static::saved(function ($article) {
            $smsService = app(SmsService::class);
            $isUpdated = $article->wasChanged();
            $time = $article->{$isUpdated ? 'updated_at' : 'created_at'}->format('Y-m-d H:i:s');
            $action = $isUpdated ? 'ویرایش شد' : 'منتشر شد';

            $followers = User::whereIn('id', function ($query) use ($article) {
                $query->select('user_id')
                    ->from('notifications')
                    ->where('author_id', $article->user_id);
            })->get();

            $message = " مقاله {$article->user->firstname} در {$time} {$action}: {$article->title}";

            foreach ($followers as $user) {
                $smsService->sendSms($user->phone, $message);
            }
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
