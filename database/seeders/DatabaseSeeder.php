<?php

namespace Database\Seeders;

use App\Models\Milestone;
use App\Models\TaskStatistic;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WtgSeeder::class,
            MilestoneSeeder::class,
            TaskSeeder::class,
            TimesheetSeeder::class,
            TaskStatisticSeeder::class,
        ]);
    }
}
