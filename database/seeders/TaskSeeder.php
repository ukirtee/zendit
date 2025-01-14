<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Milestone;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Milestone::all()->each(function ($milestone) {
            Task::factory()
                ->count(5) // Assuming 5 tasks per milestone
                ->create(['milestone_id' => $milestone->id]);
        });
    }
}
