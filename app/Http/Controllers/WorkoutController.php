<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use App\Services\ChartService;
use App\Services\ExerciseDBService;
use App\Services\WorkoutPlanService;
use App\Services\WorkoutProgressionService;
use App\Services\WorkoutService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class WorkoutController extends Controller
{
    protected WorkoutPlanService $workoutPlanService;
    protected ExerciseDBService $exerciseDBService;
    protected WorkoutService $workoutService;
    protected ChartService $chartService;
    protected WorkoutProgressionService $workoutProgressionService;


    public function __construct(WorkoutPlanService $workoutPlanService, ExerciseDBService $exerciseDBService, WorkoutService $workoutService, ChartService $chartService, WorkoutProgressionService $workoutProgressionService)
    {
        $this->workoutPlanService = $workoutPlanService;
        $this->exerciseDBService = $exerciseDBService;
        $this->workoutService = $workoutService;
        $this->chartService = $chartService;
        $this->workoutProgressionService = $workoutProgressionService;
    }

    public function create(int $id)
    {
        $plan = $this->workoutPlanService->getWorkoutPlanById($id);
        $plan = $this->exerciseDBService->getExercisesForPlan($plan);
        return view('workout.create', compact('plan'));
    }

    public function store(Request $request)
    {
        $this->workoutService->createWorkoutFromRequest($request);
    }

    public function show(int $planId)
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

    public function progression(Request $request, string $id)
    {
        $workouts = $this->workoutService->getWorkoutWithDetailsByPlanId($id);

        if (!$workouts || count($workouts['workouts']) < 2) {
            $plan = $this->workoutPlanService->getWorkoutPlanById($id);
            return view('workout.progression', [
                'plan' => $plan['name'],
                'id' => $id,
                'error' => 'You have to complete at least 2 of this workout to check progression!'
            ]);
        }

        $chartType = $request->query("chart") ?? 'max-lifts';
        $chart = $this->workoutProgressionService->getProgressionChart($id, $chartType, $workouts);

        return view('workout.progression', [
            'plan' => $workouts['name'],
            'id' => $id,
            'chart' => $chart,
            'chartType' => $chartType
        ]);
    }
}
