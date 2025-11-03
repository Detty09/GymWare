<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseDBController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/exercises', [ExerciseDBController::class, 'indexExerciseApi']);
Route::get('/bodyparts', [ExerciseDBController::class, 'indexBodyPartsApi']);
