<?php

namespace App\Listeners;

use App\Events\ArticlePublished;
use App\Models\User;
use App\Service\SmsService;

class SendArticleNotification
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function handle(ArticlePublished $event)
    {
        $article = $event->article;

        $followers = User::whereIn('id', function ($query) use ($article) {
            $query->select('user_id')
                ->from('notifications')
                ->where('author_id', $article->user_id);
        })->get();


        foreach ($followers as $user) {
            $this->smsService->sendSms(
                $user->phone,
                "کاربر {$article->user->firstname} یک مقاله جدید منتشر کرد: {$article->title}"
            );
        }
    }
}
