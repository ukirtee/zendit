<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\TaskStatistic;

class TaskStatisticSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve tasks in chunks for memory efficiency
        Task::chunk(50, function ($tasks) {
            foreach ($tasks as $task) {
                $totalActualHours = $task->timesheets->sum('hours_logged');

                // Check if an entry exists in task_statistics for this task
                TaskStatistic::updateOrCreate(
                    ['task_id' => $task->id], // Matching condition
                    [
                        'actual_hours' => $totalActualHours,
                        'variance' => $totalActualHours - $task->planned_hours,
                        'updated_at' => now(),
                    ]
                );
            }
        });
    }
}
