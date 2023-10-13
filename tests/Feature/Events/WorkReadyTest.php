<?php

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('WorkReadyEvent', function () {
    Queue::fake();
    $work = \App\Models\Work::factory()->create([
        'status' => \App\Enums\WorkStatuses::READY,
        'published_at' => now()
    ]);
    \App\Events\WorkReady::dispatch($work);
    Queue::assertPushed(\App\Jobs\PublishWork::class);
});
