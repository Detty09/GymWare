<?php

namespace App\Http\Controllers;

use App\Models\WorkoutPlan;
use App\Services\ExerciseDBService;
use App\Services\WorkoutPlanService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use function Illuminate\Events\queueable;

class WorkoutPlanController extends Controller
{
    protected WorkoutPlanService $service;
    protected ExerciseDBService $exerciseDBService;

    public function __construct(WorkoutPlanService $service, ExerciseDBService $exerciseDBService)
    {
        $this->service = $service;
        $this->exerciseDBService = $exerciseDBService;
    }

    public function index(): Factory|View
    {
        $userId = Auth::id();
        $plans = $this->service->getWorkoutPlans($userId);
        return view('planner.index', ['plans' => $plans]);
    }

    public function store(Request $request): RedirectResponse|Redirector
    {
        $name = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
        ])['name'];

        $userId = Auth::id();

        $this->service->createWorkoutPlan([
            'name' => $name,
            'user_id' => $userId,
        ]);


        return redirect('/workout-planner');
    }

    public function edit(int $planId): Factory|View
    {
        $plan = $this->service->getWorkoutPlanById($planId);
        $plan = $this->exerciseDBService->getExercisesForPlan($plan);

        return view('planner.edit', ['plan' => $plan]);
    }

    public function update(Request $request, int $planId): RedirectResponse {
        $newName = $request->validate([
            'name' => ['required', 'min:3', 'max:255'],
        ]);

        $this->service->updateWorkoutPlan($planId, $newName);

        return redirect("/workout-planner/edit/{$planId}");
    }

    public function destroy(WorkoutPlan $plan): RedirectResponse {
        $this->service->deleteWorkoutPlan($plan);
        return redirect('/workout-planner');
    }

}
