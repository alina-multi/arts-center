<?php

namespace Database\Factories;

use App\Models\WorkBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkBlockFactory extends Factory
{
    private static $order = 1;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WorkBlock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order' => self::$order++,
            'data' => []
        ];
    }
}
