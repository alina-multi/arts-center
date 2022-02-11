<?php

namespace Database\Factories;

use App\PostTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published_at' => Carbon::now()->subMinutes($this->faker->randomNumber())
        ];
    }
}
