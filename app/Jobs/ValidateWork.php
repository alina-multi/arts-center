<?php

namespace App\Jobs;

use App\Enums\WorkStatuses;
use App\Events\WorkReady;
use App\Models\Image;
use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exceptions\WorkValidationFailed;

class ValidateWork implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Work $work)
    {
    }

    public function handle()
    {
        if (!$this->work->published_at) {
            $this->invalid("We shouldn't be validating unpublished works");
        }
        $locales = config('app.languages');
        $supportedLocaleTitles = $this->work->titles->whereIn('language', $locales);
        $expectedLocalesNumber = sizeof($locales);
        $realLocalesNumber = $supportedLocaleTitles->count();
        if ($expectedLocalesNumber !== $realLocalesNumber) {
            $this->invalid("Expected $expectedLocalesNumber title locales but $realLocalesNumber in db");
        }
        foreach ($supportedLocaleTitles as $title) {
            if (!$title->title) {
                $this->invalid("$title->language work_title has no title");
            }
        }

        $this->validateImage($this->work->preview, 'preview');
        $this->validateImage($this->work->full, 'full');

        $this->work->update(['status' => WorkStatuses::READY]);
        WorkReady::dispatch($this->work);
    }

    public function validateImage(Image|null $image, string $type)
    {
        if (!$image) {
            $this->invalid("Work doesn't have a $type image");
        }

        if ($image->variants->count() < 2) {
            $this->invalid("Image $type seems have not been converted yet");
        }

        $image->variants->each(fn($variant) => \File::exists("{$image->folder->value}/$variant->file") or
            $this->invalid("Missing file: {$image->folder->value}/$variant->file"));
    }

    public function invalid($error)
    {
        $this->work->update(['status' => WorkStatuses::ERROR]);
        throw new WorkValidationFailed($error);
    }
}
