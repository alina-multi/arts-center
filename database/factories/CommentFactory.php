<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'commentable_id' => 1,
            'commentable_type' => 'work',
            'user_id' => User::inRandomOrder()->first()->id,
            'body' => [
                'ops' => [
                    ["insert" => $this->faker->realText($maxNbChars = 300, $indexSize = 2)]
                ]
            ]
        ];
    }
}
