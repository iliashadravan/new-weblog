<?php

namespace App\Providers;

use App\Events\ArticleUpdatedOrPublished;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\SendArticleNotification;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ArticleUpdatedOrPublished::class => [
            SendArticleNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
