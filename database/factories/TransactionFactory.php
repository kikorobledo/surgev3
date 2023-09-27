<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Support\Arr;
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
        return [
            'title' => 'Payment to ' . $this->faker->name(),
            'amount' => rand(10, 500),
            'status' => Arr::random(['success', 'processing', 'failed']),
            'date'=> Carbon::now()->subDays(rand(1, 365))->startOfDay()
        ];
    }
}
