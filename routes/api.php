<?php

use App\Http\Controllers\TaskController;

Route::post('/submit-task', [TaskController::class, 'submitTask']);
Route::get('/task-status/{id}', [TaskController::class, 'getTaskStatus']);
Route::get('/task-result/{id}', [TaskController::class, 'getTaskResult']);

