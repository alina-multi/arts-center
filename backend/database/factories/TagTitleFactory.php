<?php

namespace Database\Factories;

use App\Models\TagTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagTitleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TagTitle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'language' => 'en'
        ];
    }
}
