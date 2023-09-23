<?php

namespace Database\Factories;

use App\Enums\ImageFolders;
use App\Enums\WorkStatuses;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Bus;

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
            'image_id' => $this->faker->numberBetween(100, 10000),
            'full_image_id' => $this->faker->numberBetween(100, 10000),
            'status' => WorkStatuses::PUBLISHED
        ];
    }

    public function convertedImages(): Factory
    {
        $full = Image::withoutEvents(function () {
            return Image::factory()->converted()->create(['folder' => ImageFolders::Works]);
        });
        $preview = Image::withoutEvents(function () {
            return Image::factory()->converted()->create(['folder' => ImageFolders::Preview]);
        });
        return $this->state(fn() => [
            'image_id' => $preview->id,
            'full_image_id' => $full->id,
        ]);
    }

    public function freshImages(): Factory
    {
        $full = Image::withoutEvents(function () {
            return Image::factory()->onlyOriginal()->create(['folder' => ImageFolders::Works]);
        });
        $preview = Image::withoutEvents(function () {
            return Image::factory()->onlyOriginal()->create(['folder' => ImageFolders::Preview]);
        });
        return $this->state(fn() => [
            'image_id' => $preview->id,
            'full_image_id' => $full->id,
        ]);
    }
}
