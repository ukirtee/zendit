<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Timesheet;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::all()->each(function ($task) {
            Timesheet::factory()
                ->count(20) // Assuming 10 timesheet entries per task
                ->create(['task_id' => $task->id]);
        });
    }
}
