<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => null, // This will be set dynamically in the seeder
            'user_id' => fake()->numberBetween(1, 5), // Example: Random technician ID
            'hours_logged' => fake()->randomFloat(2, 1, 8),
            'log_date' => fake()->date(),
        ];
    }
}
