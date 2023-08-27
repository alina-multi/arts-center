<?php
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);
use \Illuminate\Support\Facades\Bus;

test('ValidateWorks command', function () {
    Bus::fake();
    \App\Models\Work::factory()->sequence(['published_at' => now()],['published_at' => null])->count(2)->create();
    \Illuminate\Support\Facades\Artisan::call('app:validate-works');
    Bus::assertDispatched(\App\Jobs\ValidateWork::class);
});
