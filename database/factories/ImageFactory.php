<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\ImageVariant;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ImageFolders;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

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
