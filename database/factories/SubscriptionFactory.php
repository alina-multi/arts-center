<?php

namespace Database\Factories;

use App\Subscription;
use App\Work;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\User;

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
            'user_id' => User::factory(),
            'subscribable_type' => $this->faker->randomElement(['work', 'user']),
            'subscribable_id' => $this->faker->unique()->randomNumber
        ];
    }

    public function attachWork()
    {
        return $this->state(function () {
            $work = Work::factory()->create();
            return [
                'subscribable_type' => 'work',
                'subscribable_id' => $work->id
            ];
        });
    }

    public function attachUser()
    {
        return $this->state(function () {
            $user = User::factory()->create();
            return [
                'subscribable_type' => 'user',
                'subscribable_id' => $user->id
            ];
        });
    }
}
