<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class WtgController extends Controller
{
    //
    // Fetch tasks as per WTG with variance value
    public function getTasksWithVariance($wtgId)
    {
        $tasks = Task::whereHas('milestone', function ($query) use ($wtgId) {
            $query->where('wtg_id', $wtgId);
        })
            ->with('taskStatistic:id,task_id,actual_hours,variance') // Fetch statistics for variance and actual hours
            ->get();

        $data = $tasks->map(function ($task) {
            return [
                'task_id' => $task->id,
                'task_name' => $task->task_name,
                'forecast_date' => $task->forecast_date,
                'planned_hours' => $task->planned_hours,
                'actual_hours' => $task->taskStatistic->actual_hours ?? 0,
                'variance' => $task->taskStatistic->variance ?? 0,
            ];
        });

        return sendResponse($data);
    }

    //Get the summary of WTG
    public function getWtgSummary($wtgId)
    {
        // Fetch all tasks of WTG (implement caching the second argument passed is time in seconds)
        $summary = Cache::remember("wtg_summary_$wtgId", 60, function () use ($wtgId) {
            $tasks = Task::whereHas('milestone', function ($query) use ($wtgId) {
                $query->where('wtg_id', $wtgId);
            })->with('taskStatistic:id,task_id,actual_hours,variance') // Fetch statistics for variance and actual hours
                ->get();


            $totalPlannedHours = $tasks->sum('planned_hours');
            $totalActualHours = $tasks->sum(fn($task) => $task->taskStatistic->actual_hours ?? 0);
            $tasksBehindSchedule = $tasks->filter(fn($task) => ($task->taskStatistic->variance ?? 0) > 0)->count(); // all tasks with variance value greater than 0

            $variances = $tasks->map(fn($task) => $task->taskStatistic->variance ?? 0); // creates variance collection

            $averageVariance = $maxVariance = 0;
            if ($variances->count() > 0) {
                $averageVariance = $variances->average();
                $maxVariance = $variances->max();
            }

            $response = [
                'total_planned_hours' => round($totalPlannedHours, 2),
                'total_actual_hours' => round($totalActualHours, 2),
                'tasks_behind_schedule' => $tasksBehindSchedule,
                'variance_statistics' => [
                    'average_variance' => round($averageVariance, 2),
                    'max_variance' => $maxVariance,
                ]
            ];
            return $response;
        });

        return sendResponse($summary);
    }

    // if tasks were to fetch using pagination
    public function getTasksWithVariancePaginated($wtgId)
    {
        $tasks = DB::table('tasks')->select([
            'tasks.id as task_id',
            'tasks.task_name',
            'tasks.forecast_date',
            'tasks.planned_hours',
            DB::raw('COALESCE(task_statistics.actual_hours, 0) as actual_hours'),
            DB::raw('COALESCE(task_statistics.variance, 0) as variance'),
        ])->join('milestones', 'milestones.id', '=', 'tasks.milestone_id') // Join to filter by WTG ID
            ->leftJoin('task_statistics', 'task_statistics.task_id', '=', 'tasks.id') // Join to fetch statistics
            ->where('milestones.wtg_id', $wtgId) // Filter by WTG ID
            ->paginate();

        return sendResponse($tasks);
    }
}
