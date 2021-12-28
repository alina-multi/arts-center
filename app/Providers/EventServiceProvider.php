<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\CommentChanged::class => [
            \App\Listeners\SendNotifications::class,
            \App\Listeners\AddToFeeds::class,
            \App\Listeners\ClearCache::class,
        ],
        \App\Events\WorkPublished::class => [
            \App\Listeners\SendNotifications::class,
            \App\Listeners\AddToFeeds::class,
            \App\Listeners\ClearCache::class,
            \App\Listeners\TranslateWork::class,
        ],
        \App\Events\PublishedWorkUpdated::class => [
            \App\Listeners\ClearCache::class,
        ],
        \App\Events\WorkDeleted::class => [
            \App\Listeners\ClearCache::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
