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

class RecountUserRatings implements ShouldQueue, ShouldBeUnique
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

    public function uniqueId()
    {
        return $this->user;
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
        })->with(['category', 'titles'])->orderBy('created_at', 'DESC')->get();

        $categoryLanguageRating = [];
        $userRating = [];
        foreach ($works as $work) {
            foreach ($work->category as $category) {
                foreach ($work->titles as $title) {
                    if (!isset($categoryLanguageRating[$category->id][$title->language])) {
                        $categoryLanguageRating[$category->id] = 0;
                    }
                    $categoryLanguageRating[$category->id][$title->language] += $work->rating;
                    if (!isset($userRating[$title->language])) {
                        $userRating[$title->language] = 0;
                    }
                    $userRating[$title->language] += $work->rating;
                }
            }
        }
        foreach ($userRating as $language => $rating) {
            $userRatingModel = UserRatings::firstOrCreate([
                                                              'ratable_type' => 'user',
                                                              'ratable_id' => $this->user,
                                                              'user_id' => $this->user,
                                                              'language' => $language
                                                          ]);
            $userRatingModel->rating = $rating;
            $userRatingModel->save();
        }

        foreach ($categoryLanguageRating as $categoryId => $languages) {
            foreach ($languages as $language => $rating) {
                $ratingModel = UserRatings::firstOrCreate([
                                                              'ratable_type' => 'tag',
                                                              'ratable_id' => $categoryId,
                                                              'user_id' => $this->user,
                                                              'language' => $language
                                                          ]);
                $ratingModel->rating = $rating;
                $ratingModel->save();
            }
        }
    }
}
