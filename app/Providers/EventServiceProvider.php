<?php

namespace App\Providers;

use App\Events\{
    CommentChanged,
    ImageCreated,
    UserProfileUpdated,
    WorkUserPublished,
    WorkDeleted,
    WorkDrafted,
    WorkPublished,
    WorkReady,
    WorkTranslated
};
use App\Jobs\PublishWork;
use App\Listeners\{AddToFeeds, ClearCache, ConvertImage, SendNotifications, TranslateWork, ValidateWork};
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentChanged::class => [
            SendNotifications::class,
            AddToFeeds::class,
            ClearCache::class,
        ],
        WorkUserPublished::class => [
            TranslateWork::class,
        ],
        WorkTranslated::class => [
            ValidateWork::class
        ],
        WorkReady::class => [
            PublishWork::class
        ],
        WorkPublished::class => [
            SendNotifications::class,
            AddToFeeds::class,
            ClearCache::class,
        ],
        WorkDrafted::class => [
            ClearCache::class
        ],
        WorkDeleted::class => [
            ClearCache::class,
        ],
        ImageCreated::class => [
            ConvertImage::class
        ],
        UserProfileUpdated::class => [
            ClearCache::class
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
    }
}
