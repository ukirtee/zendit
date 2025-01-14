<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateTaskForecastRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Jobs\TaskStatisticJob;

class TaskController extends Controller
{
    // Function to update the task's forcast information
    public function updateTaskForecast(UpdateTaskForecastRequest $request, $taskId)
    {

        $validated = $request->validated();

        // It checks the task exists or not
        $task = Task::where('id', $taskId)->first();

        if (!$task) {
            return sendError([], 'Task not found.', 404);
        }

        try {
            $task->update([
                'forecast_date' => $validated['forecast_date'],
                'planned_hours' => $validated['planned_hours'],
            ]);

            //Dispatch task statistics job to update the variance as planned_hours changes
            TaskStatisticJob::dispatch($taskId);

            return sendResponse(
                ['task_name' => $task->task_name, 'forecast_date' => $task->forecast_date, 'planned_hours' => $task->planned_hours],
                'Task forecast updated successfully.'
            );
        } catch (\Exception $e) {
            logError($e);
            return sendError([], 'Something went wrong. Please try again later.', 500);
        }
    }
}
