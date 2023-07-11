<?php

namespace Database\Factories;

use App\Enums\ImageFolders;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Work::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'published_at' => Carbon::now()->subMinutes(rand(1, 1000000)),
            'show_uk' => true,
            'show_en' => true,
            'price' => $this->faker->numberBetween(100, 10000),
            'rating' => $this->faker->numberBetween(0, 30),
            'comments' => $this->faker->numberBetween(0, 500),
            'image_id'=> Image::factory()->create(['folder' => ImageFolders::Preview]),
            'full_image_id'=> Image::factory()->create(['folder' => ImageFolders::Works]),
        ];
    }
}
