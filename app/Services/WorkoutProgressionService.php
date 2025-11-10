<?php

namespace App\Services;

use IcehouseVentures\LaravelChartjs\Builder;

class WorkoutProgressionService
{
    protected ChartService $chartService;
    protected WorkoutService $workoutService;
    protected WorkoutPlanService $workoutPlanService;

    public function __construct(ChartService $chartService, WorkoutService $workoutService, WorkoutPlanService $workoutPlanService) {
        $this->chartService = $chartService;
        $this->workoutService = $workoutService;
        $this->workoutPlanService = $workoutPlanService;
    }

    public function getProgressionChart(int $id, string $chartType,array $workouts): Builder
    {
        $chartType = $this->validateChartType($chartType);

        if ($chartType === 'max-lifts') {
            $chart = $this->chartService->getMaxLiftsChart($workouts);
        } else {
            $data = $this->workoutService->getWorkoutsDateAndWeightByPlanId($id);
            $chart = $this->chartService->getTotalWeightsChart($data);
        }

        return $chart;
    }

    private function validateChartType(string $chartType): string
    {
        if ($chartType === 'max-lifts') {
            return 'max-lifts';
        } else {
            return 'total-weight';
        }
    }
}
