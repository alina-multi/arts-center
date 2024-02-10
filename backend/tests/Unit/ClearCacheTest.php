<?php

use \Illuminate\Support\Facades\{Event, Redis};
use App\Models\{User, Work};
use App\Events\{WorkDrafted, WorkDeleted, WorkPublished, UserProfileUpdated};
use App\Listeners\ClearCache;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Clear cache listener in place', function () {
    Event::fake();
    collect([
        WorkPublished::class,
        WorkDeleted::class,
        WorkDrafted::class,
        UserProfileUpdated::class
    ])->each(fn($item) => Event::assertListening($item, ClearCache::class));
});

test('Test user ClearCache', function () {
    $user = User::factory()->create();
    $event = new UserProfileUpdated($user);
    $listener = new ClearCache($event);

    Redis::shouldReceive('connection')->once()->andReturnSelf();
    Redis::shouldReceive('del')->once()->with("frontend.user.$user->username");

    $listener->handle($event);
});

test('Test work ClearCache', function () {
    $work = Work::factory()->create();
    $event = new WorkDeleted($work);
    $listener = new ClearCache($event);

    Redis::shouldReceive('connection')->once()->andReturnSelf();
    Redis::shouldReceive('del')->once()->with("frontend.work.$work->id");

    $listener->handle($event);
});

