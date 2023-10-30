<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = rand(1, 10) * 500;
        return [
            'from_user_id' => null,
            'from_email' => $this->faker->email,
            'event' => [],
            'amount_gross' => $amount,
            'to_user_id' => rand(0, 20),
            'type' => 1,
            'payment_intent'=> $this->faker->uuid
        ];
    }
}
