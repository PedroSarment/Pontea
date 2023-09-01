<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Purchase;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'bought_by' => $this->faker->numberBetween(1, 10), // Customize user IDs
            'activity_id' => $this->faker->numberBetween(1, 20), // Customize activity IDs
            'bought_at' => $this->faker->dateTimeThisYear(), // Customize purchase date
        ];
    }
}
