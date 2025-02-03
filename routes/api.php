<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\WtgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Prefixing all routes with v1
Route::group(['prefix' => 'v1'], function () {

    // Tasks API
    Route::group(['prefix' => 'tasks'], function () {
        Route::put('{taskId}/forecast', [TaskController::class, 'updateTaskForecast']);
    });

    //WTG API
    Route::group(['prefix' => 'wtg'], function () {
        Route::get('{wtgId}/tasks', [WtgController::class, 'getTasksWithVariance']);
        Route::get('{wtgId}/summary', [WtgController::class, 'getWtgSummary']);
        Route::get('{wtgId}/summaryDb', [WtgController::class, 'getWtgSummaryWithDb']);
    });

    Route::get('wtgs', [WtgController::class, 'get']);

});
