<?php

namespace Database\Factories;

use App\Enums\FeedbackType;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'user_id' => User::factory()->create()->id,
            'language' => 'en',
            'body' => $this->faker->realText(100),
            'type'=> FeedbackType::feedback->value
        ];
    }
}
