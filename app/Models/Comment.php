<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'commentable_type', 'commentable_id'];

    public function commentable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('commentable_type', Comment::class);
    }

    public function isReply()
    {
        return $this->commentable_type === Comment::class;
    }
}
