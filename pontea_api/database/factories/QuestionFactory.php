<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'created_by' => $this->faker->numberBetween(1, 10), // Customize user IDs
            'activity_id' => $this->faker->numberBetween(1, 20), // Customize activity IDs
            'question' => $this->faker->paragraph,
            'response' => $this->faker->paragraph,
            'likes' => $this->faker->numberBetween(0, 100),
        ];
    }
}
