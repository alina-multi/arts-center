<?php

namespace Database\Factories;

use App\WorkTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkTitle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'language' => 'en'
        ];
    }
}
