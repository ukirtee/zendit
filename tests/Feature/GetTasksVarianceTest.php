<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Milestone;
use App\Models\Task;
use App\Models\Wtg;

class GetTasksVarianceTest extends TestCase
{
    public function test_get_task_status_with_variance()
    {
        $wtg = Wtg::factory()->create();

        $milestone = Milestone::factory()->create(['wtg_id' => $wtg->id]);

        $tasks = Task::factory(5)->create(['milestone_id' => $milestone->id]);

        foreach ($tasks as $task) {
            $task->taskStatistic()->create([
                'actual_hours' => 22,
                'variance' => 2,
            ]);
        }

        $response = $this->getJson("/api/v1/wtg/{$milestone->wtg_id}/tasks");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'task_id',
                        'task_name',
                        'forecast_date',
                        'planned_hours',
                        'actual_hours',
                        'variance',
                    ],
                ],
            ])
            ->assertJsonCount(5, 'data') // Assert 5 tasks in the "data" key
            ->assertJsonFragment([
                'task_id' => $tasks->first()->id,
                'task_name' => $tasks->first()->task_name,
                'forecast_date' => $tasks->first()->forecast_date,
                'planned_hours' => $tasks->first()->planned_hours,
                'actual_hours' => 22,
                'variance' => 2,
            ]);
    }
}
