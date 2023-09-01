<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'created_by' => $this->faker->numberBetween(1, 10), // Customize user IDs
            'activity_id' => $this->faker->numberBetween(1, 20), // Customize activity IDs
            'text' => $this->faker->paragraph,
            'note' => $this->faker->numberBetween(1, 5), // Customize note values
        ];
    }
}
