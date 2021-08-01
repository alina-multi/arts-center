<?php

namespace Database\Factories;

use App\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscribable_type' => $this->faker->randomElement(['work', 'user']),
            'subscribable_id' => $this->faker->unique()->randomNumber
        ];
    }
}
