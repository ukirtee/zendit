<?php

namespace Tests\Feature;

use App\Models\Milestone;
use App\Models\Task;
use App\Models\Wtg;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTaskForecastTest extends TestCase
{

    public function test_update_task_forecast_successfully()
    {
        $wtg = Wtg::factory()->create();
        $milestone = Milestone::factory()->create(['wtg_id' => $wtg->id]);
        $task = Task::factory()->create(['milestone_id' => $milestone->id]);

        $payload = [
            'forecast_date' => '2025-01-15',
            'planned_hours' => 24.5,
        ];

        $response = $this->putJson("/api/v1/tasks/{$task->id}/forecast", $payload);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Task forecast updated successfully.',
            ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'forecast_date' => $payload['forecast_date'],
            'planned_hours' => $payload['planned_hours'],
        ]);
    }

    public function test_update_task_forecast_validation_errors()
    {
        $wtg = Wtg::factory()->create();
        $milestone = Milestone::factory()->create(['wtg_id' => $wtg->id]);
        $task = Task::factory()->create(['milestone_id' => $milestone->id]);

        $payload = [
            'forecast_date' => 'invalid-date',
            'planned_hours' => 'not-a-number',
        ];

        $response = $this->putJson("/api/v1/tasks/{$task->id}/forecast", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['forecast_date', 'planned_hours']);
    }
}
