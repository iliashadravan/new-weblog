<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ArticlePublished;
use App\Listeners\SendArticleNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ArticlePublished::class => [
            SendArticleNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
