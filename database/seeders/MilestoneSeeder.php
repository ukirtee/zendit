<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Milestone;
use App\Models\Wtg;

class MilestoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wtg::all()->each(function ($wtg) {
            Milestone::factory()
                ->count(5) // Assuming 5 milestones per WTG
                ->create(['wtg_id' => $wtg->id]);
        });
    }
}
