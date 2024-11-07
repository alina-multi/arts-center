<?php

use App\Enums\UserRoles;
use App\Enums\WorkStatuses;
use App\Events\WorkReady;
use App\Jobs\PublishWork;
use App\Models\Work;
use App\Notifications\NotApprovedUserPublishedWork;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('WorkReady dispatches PublishWork', function () {
    Queue::fake();
    $work = Work::factory()->create([
        'status' => WorkStatuses::READY,
        'published_at' => now()
    ]);
    WorkReady::dispatch($work);
    Queue::assertPushed(PublishWork::class);
});
it('WorkReady notifies admin if author is not approved yet', function () {
    Queue::fake();
    Notification::fake();
    $admin = \App\Models\User::factory()->create(['role'=> UserRoles::SuperAdmin]);
    $work = Work::factory()->hasOwners(1, ['approved_at' => null])->create([
        'status' => WorkStatuses::READY,
        'published_at' => now()
    ]);
    WorkReady::dispatch($work);
    Queue::assertNotPushed(PublishWork::class);
    Notification::assertSentTo($admin, NotApprovedUserPublishedWork::class);
});
