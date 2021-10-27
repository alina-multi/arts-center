<?php

namespace App\Jobs;

use App\UserRatings;
use App\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecountUserRatings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $works = Work::whereHas('owners', function ($query) {
            $query->where('ownables.user_id', $this->user);
        })->with('category')->orderBy('created_at', 'DESC')->get();

        $categoryRating = [];
        $userRating = 0;
        foreach ($works as $work) {
            foreach ($work->category as $category) {
                if (!isset($categoryRating[$category->id])) {
                    $categoryRating[$category->id] = 0;
                }
                $categoryRating[$category->id] += $work->rating;
            }
            $userRating += $work->rating;
        }
        $userRatingModel = UserRatings::firstOrCreate([
                                                          'ratable_type' => 'user',
                                                          'ratable_id' => $this->user,
                                                          'user_id' => $this->user
                                                      ]);
        $userRatingModel->rating = $userRating;
        $userRatingModel->save();
        foreach ($categoryRating as $categoryId => $rating) {
            $ratingModel = UserRatings::firstOrCreate([
                                           'ratable_type' => 'tag',
                                           'ratable_id' => $categoryId,
                                           'user_id' => $this->user
                                       ]);
            $ratingModel->rating = $rating;
            $ratingModel->save();
        }
    }
}
