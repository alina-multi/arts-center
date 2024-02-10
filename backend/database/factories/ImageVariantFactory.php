<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImageVariant>
 */
class ImageVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $width = $this->faker->randomElement([300, 600, 1200, 2400]);
        $ar = $this->faker->randomElement([1, 16/9, 4/3, 3/2, 2/3]);
        $height = round($width / $ar);
        return [
            'image_id' => 1,
            'extension' => $this->faker->randomElement(['png', 'jpeg', 'webp']),
            'width' => $width,
            'height' => $height,
            'size' => $this->faker->numberBetween(1000, 100000),
            'original' => false,
        ];
    }
}
