<?php

namespace App\Providers;

use App\Events\{CommentCreated,
    CommentDeleted,
    TransactionCreated,
    ImageCreated,
    MeChanged,
    UserProfileUpdated,
    VoteCreated,
    WorkUserPublished,
    WorkDeleted,
    WorkDrafted,
    WorkPublished,
    WorkReady,
    WorkTranslated
};
use App\Listeners\{AddToFeeds,
    ClearAuthCache,
    ClearCache,
    CommentNotifications,
    ConvertImage,
    DonationNotifications,
    RecountCommentCount,
    SendNotifications,
    CheckoutSessionCompleted,
    TranslateWork,
    ValidateWork,
    PublishWork,
    VoteNotifications
};
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Cashier\Events\WebhookReceived;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentCreated::class => [
            ClearCache::class,
            CommentNotifications::class,
            RecountCommentCount::class
        ],
        CommentDeleted::class => [
            RecountCommentCount::class
        ],
        VoteCreated::class => [
            VoteNotifications::class
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
        ],
        MeChanged::class => [
            ClearAuthCache::class
        ],
        WebhookReceived::class => [
            CheckoutSessionCompleted::class
        ],
        TransactionCreated::class => [
            DonationNotifications::class
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
