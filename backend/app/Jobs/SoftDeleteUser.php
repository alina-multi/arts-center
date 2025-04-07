<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SoftDeleteUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private const CHUNK_SIZE = 100;

    public function __construct(
        private readonly User $user
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Soft delete comments in chunks
        $this->user->comments()
            ->chunkById(self::CHUNK_SIZE, function ($comments) {
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            });

        // Soft delete works in chunks
        $this->user->works()
            ->chunkById(self::CHUNK_SIZE, function ($works) {
                foreach ($works as $work) {
                    $work->delete();
                }
            });

        // Finally, soft delete the user
        $this->user->delete();
    }
}
