<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use App\Services\ExerciseDBService;
use App\Services\WorkoutPlanService;
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


    public function __construct(WorkoutPlanService $workoutPlanService, ExerciseDBService $exerciseDBService, WorkoutService $workoutService)
    {
        $this->workoutPlanService = $workoutPlanService;
        $this->exerciseDBService = $exerciseDBService;
        $this->workoutService = $workoutService;
    }

    public function create(int $id)
    {
        $plan = $this->workoutPlanService->getWorkoutPlanById($id);
        $plan = $this->exerciseDBService->getExercisesForPlan($plan);
        return view('workout.create', compact('plan'));
    }

    public function store(Request $request)
    {
        $planId = $request->input('workout-plan-id');

        $exerciseIds = $request->input('exercise-id');
        $names = $request->input('exercise-name');
        $weight = $request->input('weight');
        $reps = $request->input('reps');

        $isValid = $this->workoutService->validateInputs($names, $exerciseIds, $weight, $reps);

        if (!$isValid) {
            return redirect('/workout/create/' . $planId)->with('error', 'You cannot set a negative value to weight or repetition!');
        }

        $totalWeight = $this->workoutService->getTotalWeight($exerciseIds, $weight, $reps);

        $workoutId = $this->workoutService->createWorkout($planId, $totalWeight);
        $this->workoutService->createWorkoutDetails([
            'workout_id' => $workoutId,
            'exercise-id' => $exerciseIds,
            'names' => $names,
            'weight' => $weight,
            'reps' => $reps
        ]);
        return redirect('/workout/history');
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

        $chart = $request->query("chart") ?? 'max-lifts';

        if ($chart === 'max-lifts') {
            $chart = $this->workoutService->getMaxLiftsChart($workouts);
            $chartType = 'max-lifts';
        } else if ($chart === 'total-weight') {
            $chart = $this->workoutService->getTotalWeightsChart($id);
            $chartType = 'total-weight';
        } else {
            $plan = $this->workoutPlanService->getWorkoutPlanById($id);
            return view('workout.progression', [
                'plan' => $plan['name'],
                'id' => $id,
                'error' => 'Something went wrong!'
            ]);
        }

        return view('workout.progression', [
            'plan' => $workouts['name'],
            'id' => $id,
            'chart' => $chart,
            'chartType' => $chartType
        ]);
    }

    public function downloadChart(Request $request)
    {
        $subscribed = Auth::user()->subscription;

        if (!$subscribed) {
            $id = $request->input('id');
            return redirect('/workout/progression/' . $id)
                ->with('error', 'You have to be subscribed to download the progression chart!');
        }

        $base64 = $request->input('image');
        $plan = $request->input('plan', 'Workout');

        $imageData = str_replace('data:image/png;base64,', '', $base64);
        $imageData = str_replace(' ', '+', $imageData);
        $image = base64_decode($imageData);

        $path = storage_path('app/public/chart.png');
        file_put_contents($path, $image);

        $pdf = Pdf::loadView('workout.chart-pdf', [
            'imagePath' => $path,
            'plan' => $plan,
        ])->setPaper('a4', 'landscape');

        return Response::make($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="chart.pdf"',
        ]);
    }

    public function download(string $id)
    {
        $subscribed = Auth::user()->subscription;

        if (!$subscribed) {
            return redirect('/workout-planner')
                ->with('error', 'You have to be subscribed to download the workout template!');
        }

        $plan = $this->workoutPlanService->getWorkoutPlanById($id);

        if (empty($plan['exercises'])) {
            return redirect('/workout-planner/edit/' . $id);
        }

        $plan = $this->exerciseDBService->getExercisesForPlan($plan);
        $pdf = Pdf::loadView('workout.create-pdf', [
            'plan' => $plan,
        ])->setPaper('a4');

        $filename = Str::slug($plan['name'], '_') . '.pdf';
        return $pdf->download($filename);
    }

}
