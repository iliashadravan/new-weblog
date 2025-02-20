<?php

namespace App\Listeners;

use App\Events\ArticleUpdatedOrPublished;
use App\Models\User;
use App\Service\SmsService;

class SendArticleNotification
{
    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function handle(ArticleUpdatedOrPublished $event)
    {
        $article = $event->article;

        $createdAt = $article->created_at->format('Y-m-d H:i:s');
        $updatedAt = $article->updated_at->format('Y-m-d H:i:s');

        $isUpdated = $article->created_at != $article->updated_at;

        $followers = User::whereIn('id', function ($query) use ($article) {
            $query->select('user_id')
                ->from('notifications')
                ->where('author_id', $article->user_id);
        })->get();

        foreach ($followers as $user) {
            $time = $isUpdated ? $updatedAt : $createdAt;
            $action = $isUpdated ? 'ویرایش شد' : 'منتشر شد';

            $message = " مقاله شماره {$article->id} توسط {$article->user->firstname} در {$time} {$action}: {$article->title}";

            $this->smsService->sendSms($user->phone, $message);
        }
    }
}
