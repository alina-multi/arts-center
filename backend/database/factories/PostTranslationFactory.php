<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostTranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'language' => $this->faker->unique()->randomElement(config('app.languages')),
            'body' => ['delta' => []]
        ];
    }
}
