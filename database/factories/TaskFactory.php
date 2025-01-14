<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'milestone_id' => null, // This will be set dynamically in the seeder
            'task_name' => fake()->sentence(4),
            'planned_hours' => fake()->randomFloat(2, 10, 40),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
