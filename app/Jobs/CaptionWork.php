<?php

namespace App\Jobs;

use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Google\Protobuf\Value;
use Google\Cloud\AIPlatform\V1\PredictionServiceClient;

class CaptionWork implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Work $work)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

    }
}
