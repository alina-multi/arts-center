<?php
uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('ValidateWork job', function () {
    $work = \App\Models\Work::factory()
        ->has(\App\Models\WorkTitle::factory()
            ->count(2)
            ->sequence(
                ['language' => 'uk'],
                ['language' => 'be'] //Unsupported language should be ignored
            ), 'titles')
        ->create();
    expect(fn() => \App\Jobs\ValidateWork::dispatchSync($work))
        ->toThrow(\App\Exceptions\WorkValidationFailed::class, 'Expected 2 title locales but 1 in db');

    // Now make it supported language but remove title
    $englishTitle = $work->titles->where('language', 'be')->first();
    $englishTitle->update(['language' => 'en', 'title' => null]);
    expect(fn() => \App\Jobs\ValidateWork::dispatchSync($work))
        ->toThrow(\App\Exceptions\WorkValidationFailed::class, 'en work_title has no title');

    // Now title should be valid
    $englishTitle->update(['title' => 'Something here']);

    // Still don't have any images
    expect(fn() => \App\Jobs\ValidateWork::dispatchSync($work))
        ->toThrow(\App\Exceptions\WorkValidationFailed::class, "Work doesn't have a preview image");

    // Should fail because still not converted
    $work->preview()->associate(\App\Models\Image::factory()->onlyOriginal()->create());
    $work->save();

    expect(fn() => \App\Jobs\ValidateWork::dispatchSync($work))
        ->toThrow(\App\Exceptions\WorkValidationFailed::class, "Image preview seems have not been converted yet");

    // Should fail because no files exist
    $work->preview()->delete();
    $work->preview()->associate(\App\Models\Image::factory()->converted()->create());
    $work->save();

    expect(fn() => \App\Jobs\ValidateWork::dispatchSync($work))
        ->toThrow(\App\Exceptions\WorkValidationFailed::class, "Missing file");
});
