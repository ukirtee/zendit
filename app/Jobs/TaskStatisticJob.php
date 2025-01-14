<?php

namespace App\Jobs;

use App\Models\Task;
use App\Models\TaskStatistic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TaskStatisticJob implements ShouldQueue
{
    use Queueable;

    protected $taskId;

    /**
     * Create a new job instance.
     *
     * @param int $taskId
     */
    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $task = Task::with('timesheets')->find($this->taskId);

        if ($task) {
            $actualHours = $task->timesheets->sum('hours_logged');
            $variance = $actualHours - $task->planned_hours;

            // Store variance and actual hours in Taskstatistic table
            TaskStatistic::updateOrCreate(
                ['task_id' => $this->taskId],
                [
                    'actual_hours' => $actualHours,
                    'variance' => $variance,
                ]
            );
        }
    }
}
