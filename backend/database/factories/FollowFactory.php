<?php

namespace Database\Factories;

use App\Models\Follow;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class FollowFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Follow::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'followable_type' => $this->faker->randomElement(['work', 'user']),
            'followable_id' => $this->faker->unique()->randomNumber
        ];
    }

    public function attachWork()
    {
        return $this->state(function () {
            $work = Work::factory()->create();
            return [
                'followable_type' => 'work',
                'followable_id' => $work->id
            ];
        });
    }

    public function attachUser()
    {
        return $this->state(function () {
            $user = User::factory()->create();
            return [
                'followable_type' => 'user',
                'followable_id' => $user->id
            ];
        });
    }
}
