<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStatistic>
 */
class TaskStatisticFactory extends Factory
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
            'actual_hours' => 0, // Will be calculated in the seeder
            'variance' => 0, // Will be calculated in the seeder
            'last_updated' => now(),
        ];
    }
}
