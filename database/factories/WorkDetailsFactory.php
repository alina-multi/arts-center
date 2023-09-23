<?php

namespace Database\Factories;

use App\Models\WorkDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkDetails::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year'=> $this->faker->year,
            'width'=> $this->faker->numberBetween(10, 100),
            'height'=> $this->faker->numberBetween(10, 100),
            'length'=> $this->faker->numberBetween(10, 100),
        ];
    }
}
