<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'article_id', 'user_id');
    }
}
