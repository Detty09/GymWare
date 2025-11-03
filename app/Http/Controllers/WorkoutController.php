<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use App\Services\ExerciseDBService;
use App\Services\WorkoutPlanService;
use App\Services\WorkoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    protected WorkoutPlanService $workoutPlanService;
    protected ExerciseDBService $exerciseDBService;
    protected WorkoutService $workoutService;


    public function __construct(WorkoutPlanService $workoutPlanService, ExerciseDBService $exerciseDBService, WorkoutService $workoutService) {
        $this->workoutPlanService = $workoutPlanService;
        $this->exerciseDBService = $exerciseDBService;
        $this->workoutService = $workoutService;
    }

    public function create(string $id)
    {
        $plan = $this->workoutPlanService->getWorkoutPlanById($id);
        $plan = $this->exerciseDBService->getExercisesForPlan($plan);
        return view('workout.create', compact('plan'));
    }

    public function store(Request $request)
    {
        $planId = $request->input('workout-plan-id');
        $workoutId = $this->workoutService->createWorkout($planId);

        $exerciseIds = $request->input('exercise-id');
        $names = $request->input('exercise-name');
        $weight = $request->input('weight');
        $reps = $request->input('reps');

        $this->workoutService->createWorkoutDetails([
            'workout_id' => $workoutId,
            'exercise-id' => $exerciseIds,
            'names' => $names,
            'weight' => $weight,
            'reps' => $reps
        ]);
        return redirect('/workout/history');
    }

    public function show(string $planId)
    {
        $workouts = $this->workoutService->getWorkoutWithDetailsByPlanId($planId);

        if (empty($workouts)) {
            $plan = $this->workoutPlanService->getWorkoutPlanById($planId);
            $workouts = ['name' => $plan['name']];
        }

        return view('workout.template-history', ['data' => $workouts]);
    }

    public function index()
    {
        $userId = Auth::id();
        $workouts = $this->workoutService->getWorkoutsWithDetailsByUserId($userId);
        return view('workout.history', ['data' => $workouts]);
    }
}
