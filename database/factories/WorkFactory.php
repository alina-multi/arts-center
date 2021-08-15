<?php

namespace Database\Factories;

use App\Image;
use App\Work;
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
        $image = Image::factory()->create();
        return [
            'image_id' => $image->id
        ];
    }
}
