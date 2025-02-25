<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const IMAGE_PATH = 'user';
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'image',
        'is_admin',
        'is_active'
    ];
    protected $appends = [
        'image_path'
    ];

    protected $hidden = [
        'image',
    ];
    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'article_id', 'user_id');
    }
    public function savedArticles()
    {
        return $this->belongsToMany(Article::class, 'saved_articles');
    }

    public function getImagePathAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
