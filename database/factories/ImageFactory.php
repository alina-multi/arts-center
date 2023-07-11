<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\ImageVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ImageFolders;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    public function configure(): static
    {
        return $this->afterCreating(function (Image $image) {
            $ar = $image->folder === ImageFolders::Preview
                ? 4 / 3 :
                $this->faker->randomFloat(2, 1, 2);
            ImageVariant::factory()->count(5)->sequence(
                ['width' => 300, 'height' => round(300 / $ar), 'extension' => 'jpeg'],
                ['width' => 600, 'height' => round(600 / $ar), 'extension' => 'jpeg'],
                ['width' => 300, 'height' => round(300 / $ar), 'extension' => 'webp'],
                ['width' => 600, 'height' => round(600 / $ar), 'extension' => 'webp'],
                ['width' => 1024, 'height' => 768, 'extension' => 'jpeg', 'original' => true],
            )->create(['image_id' => $image->id]);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'user_id' => 1,
            'folder' => $this->faker->randomElement(ImageFolders::cases()),
            'w300' => true,
            'w600' => true,
            'w1200' => true,
            'w2400' => true,
            'extension' => $this->faker->randomElement(['jpg', 'png', 'jpeg'])
        ];
    }
}
