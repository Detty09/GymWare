<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExerciseDBController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseDetailController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutPlanController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/bio', [ProfileController::class, 'updateBio'])->name('profile.updateBio');
    Route::patch('/profile/subscription', [ProfileController::class, 'updateSubscription'])->name('profile.subscription.update');
    Route::delete('/profile/subscription', [ProfileController::class, 'cancelSubscription'])->name('profile.subscription.cancel');
    Route::patch('/profile/subscribe',[ProfileController::class, 'subscribe'])->name('profile.subscribe');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get("/exercises", [ExerciseDBController::class, 'index']);
Route::get("/exercises/{id}", [ExerciseDBController::class, 'show'])->name('exercises.show');

Route::middleware('auth')->group(function () {
    //Workout Planner
    Route::get('/workout-planner', [WorkoutPlanController::class, 'index']);
    Route::post('/workout-planner', [WorkoutPlanController::class, 'store']);

    Route::get('/workout-planner/edit/{id}', [WorkoutPlanController::class, 'edit']);
    Route::patch('/workout-planner/{id}', [WorkoutPlanController::class, 'update']);
    Route::delete('/workout-planner/{plan}', [WorkoutPlanController::class, 'destroy']);

    //Exercise / Plan
    Route::get('/workout-planner/exercise/create/{id}', [ExerciseController::class, 'create']);
    Route::post('/workout-planner/exercise/{id}', [ExerciseController::class, 'store']);
    Route::delete('/workout-planner/exercise/{id}', [ExerciseController::class, 'destroy']);

    //Workout
    Route::get('/workout/create/{id}', [WorkoutController::class, 'create'] );
    Route::post('/workout/create', [WorkoutController::class, 'store'] );

    Route::get('/workout/history', [WorkoutController::class, 'index']);
    Route::get('/workout/history/{id}', [WorkoutController::class, 'show'] );
});

Route::middleware('auth')->group(function (){
    Route::get('/coaches', [AppointmentController::class, 'index'])->name('coaches.index');
    Route::get('/coaches/{coach}', [AppointmentController::class, 'show'])->name('coaches.show');
    Route::get('/appointments/create/{coach}', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('appointments.myAppointments');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

