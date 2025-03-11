<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APITasksController; // ✅ Import the controller

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('task', [APITasksController::class, 'create']);
Route::get('task', [APITasksController::class, 'index']);
Route::get('task/{id}', [APITasksController::class, 'getTaskById']);
Route::put('task/{id}', [APITasksController::class, 'update']);
Route::post('task/done/{id}', [APITasksController::class, 'markAsDone']);
Route::delete('task/{id}', [APITasksController::class, 'delete']);
