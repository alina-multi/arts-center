<?php

namespace Database\Factories;

use App\blacklist;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlacklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = blacklist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'blacklist_user_id' => User::factory()->create()->id
        ];
    }
}
