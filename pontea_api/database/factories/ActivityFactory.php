<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Activity;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activities>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'created_by' => $this->faker->numberBetween(1, 10), // Customize user IDs
            'area_id' => $this->faker->numberBetween(1, 5), // Customize area IDs
            'level_id' => $this->faker->numberBetween(1, 3), // Customize level IDs
            'age_group_id' => $this->faker->numberBetween(1, 4), // Customize age group IDs
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'media_path_1' => null,
            'media_path_2' => null,
            'media_path_3' => null,
            'media_path_4' => null,
            'has_multimedia_resources' => $this->faker->randomElement([true, false]), // Valor aleatório entre true e false
            'has_visual_instructions' => $this->faker->randomElement([true, false]), // Valor aleatório entre true e false
        ];
    }
}
