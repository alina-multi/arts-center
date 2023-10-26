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
        $amount = rand(1,10) * 500;
        $net = round($amount*0,9);
        return [
            'from_user_id'=>null,
            'from_email'=> $this->faker->email,
            'event' => [],
            'amount_gross' => $amount,
            'amount_net' => $net
        ];
    }
}
