<?php

namespace Database\Factories;

use App\Models\FavoriteFolder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $folders = FavoriteFolder::get();
        if (empty($folders)) {
            $folders = FavoriteFolder::factory()->count(3)->create();
        }
        return [
            'favorite_folder_id' => $folders->random()->id,
            'work_id' => $this->faker->unique()->numberBetween(0,10000),
            'user_id' => $this->faker->unique()->numberBetween(0,10000)
        ];
    }
}
