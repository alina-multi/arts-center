<?php

namespace App\Providers;

use App\Events\CommentChanged;
use App\Events\ImageCreated;
use App\Events\WorkUserPublished;
use App\Events\WorkDeleted;
use App\Events\WorkDrafted;
use App\Events\WorkPublished;
use App\Events\WorkReady;
use App\Events\WorkTranslated;
use App\Jobs\PublishWork;
use App\Listeners\AddToFeeds;
use App\Listeners\ClearCache;
use App\Listeners\ConvertImage;
use App\Listeners\SendNotifications;
use App\Listeners\TranslateWork;
use App\Listeners\ValidateWork;
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

        ],
        WorkDeleted::class => [
            ClearCache::class,
        ],
        ImageCreated::class => [
            ConvertImage::class
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
