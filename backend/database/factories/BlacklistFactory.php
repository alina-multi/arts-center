<?php

namespace Database\Factories;

use App\Models\Blacklist;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlacklistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blacklist::class;

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
