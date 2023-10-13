<?php
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('PublishWork job', function () {
    // Check that wrong status throws
    $work = \App\Models\Work::factory()->create([
        'status' => \App\Enums\WorkStatuses::ERROR
    ]);
    expect(fn() => \App\Jobs\PublishWork::dispatchSync($work))->toThrow("not in status READY");

    // Check that unpublished throws
    $work->update([
        'status' => \App\Enums\WorkStatuses::READY,
        'published_at' => null
    ]);
    expect(fn() => \App\Jobs\PublishWork::dispatchSync($work))->toThrow("has no published_at");

    // Check publish without premium
    $work->update([
        'status' => \App\Enums\WorkStatuses::READY,
        'published_at' => now()
    ]);
    \App\Jobs\PublishWork::dispatchSync($work);
    $work->refresh();
    expect($work->status)->tobe(\App\Enums\WorkStatuses::PUBLISHED);

    // Check with premium
    $work->owners()->attach(\App\Models\User::factory()->create(['premium'=>true]));
    $work->update([
        'status' => \App\Enums\WorkStatuses::READY,
    ]);
    \App\Jobs\PublishWork::dispatchSync($work);
    $work->refresh();
    expect($work->status)->tobe(\App\Enums\WorkStatuses::PUBLISHED_PREMIUM);
});