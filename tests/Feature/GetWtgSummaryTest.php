<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Milestone;
use App\Models\Task;
use App\Models\Wtg;

class GetWtgSummaryTest extends TestCase
{
    public function test_get_wtg_summary()
    {
        $wtg = Wtg::factory()->create();
        $milestone = Milestone::factory()->create(['wtg_id' => $wtg->id]);
        $tasks = Task::factory(5)->create(['milestone_id' => $milestone->id]);

        $totalPlannedHours = $tasks->sum('planned_hours');
        $totalActualHours = 0;
        $maxVariance = -INF;

        foreach ($tasks as $task) {
            $actualHours = rand(20, 30);
            $variance = $actualHours - $task->planned_hours;

            $task->taskStatistic()->create([
                'actual_hours' => $actualHours,
                'variance' => $variance,
            ]);

            $totalActualHours += $actualHours;
            $maxVariance = max($maxVariance, $variance);
        }

        $response = $this->getJson("/api/v1/wtg/{$milestone->wtg_id}/summary");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'total_planned_hours' => $totalPlannedHours,
                    'total_actual_hours' => $totalActualHours,
                    'tasks_behind_schedule' => $tasks->filter(fn($task) => $task->taskStatistic->variance > 0)->count(),
                    'variance_statistics' => [
                        'average_variance' => round($tasks->avg(fn($task) => $task->taskStatistic->variance), 2),
                        'max_variance' => round($maxVariance,2),
                    ],
                ],
                'message' => ''
            ]);
    }
}
