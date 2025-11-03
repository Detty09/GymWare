<?php

namespace App\Services;

use App\Repositories\WorkoutDetailRepository;
use App\Repositories\WorkoutPlanRepository;
use App\Repositories\WorkoutRepository;
use IcehouseVentures\LaravelChartjs\Builder;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Support\Carbon;

class WorkoutService
{
    private float $CHART_MODIFIER = 1.4;
    protected WorkoutRepository $workoutRepository;
    protected WorkoutDetailRepository $workoutDetailRepository;
    protected WorkoutPlanRepository $workoutPlanRepository;

    public function __construct(WorkoutRepository $workoutRepository, WorkoutDetailRepository $workoutDetailRepository, WorkoutPlanRepository $workoutPlanRepository)
    {
        $this->workoutRepository = $workoutRepository;
        $this->workoutDetailRepository = $workoutDetailRepository;
        $this->workoutPlanRepository = $workoutPlanRepository;
    }


    public function createWorkout(int $planId): int
    {
        return $this->workoutRepository->create($planId);
    }

    public function createWorkoutDetails(array $data): void
    {
        for ($j = 0; $j < count($data['exercise-id']); $j++) {
            $exerciseId = $data['exercise-id'][$j];
            $name = $data['names'][$j];
            $details = $this->getDetails($data, $exerciseId);

            for ($i = 0; $i < count($details['weight']); $i++) {
                $detail = [
                    'workout_id' => $data['workout_id'],
                    'exercise_id' => $exerciseId,
                    'name' => $name,
                    'set' => $i + 1,
                    'weight' => $details['weight'][$i],
                    'reps' => $details['reps'][$i],
                ];
                $this->workoutDetailRepository->create($detail);
            }
        }
    }

    private function getDetails(array $data, string $id): array
    {
        return [
            'weight' => $data['weight']["$id"],
            'reps' => $data['reps']["$id"],
        ];
    }

    public function getWorkoutWithDetailsByPlanId(int $planId): array
    {
        $data = $this->workoutRepository->findByPlanId($planId);

        if (empty($data)) {
            return [];
        }

        $formattedData = $this->getFormattedDetails($data);

        return [
            'name' => $data[0]['workout_plan']['name'],
            'workouts' => $formattedData,
        ];
    }

    private function getFormattedDetails(array $data): array
    {
        $detailsData = [];

        foreach ($data as $workoutData) {
            $detailsData += $this->formatDetail($workoutData);
        }

        return $detailsData;
    }

    private function formatDetail(mixed $workoutData): array
    {
        $details = [];
        $data = $workoutData['details'];

        for ($i = 0; $i < count($data); $i++) {
            $exercise = $data[$i]['name'];

            if (!array_key_exists($exercise, $details)) {
                $details[$exercise] = [
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],]
                ];
            } else {
                $details[$exercise][] =
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],];
            }
        }
        return [$workoutData['date'] => $details];
    }

    public function getWorkoutsWithDetailsByUserId(string $userId): array
    {
        $plans = $this->workoutPlanRepository->getByUserId($userId);
        $details = [];

        foreach ($plans as $plan) {
            $data = $this->workoutRepository->findByPlanId($plan['id']);

            if (empty($data)) {
                continue;
            }

            $name = $data[0]['workout_plan']['name'];
            $details[$name] = $this->getFormattedDetails($data);
        }
        return $details;
    }

    public function validateInputs(array ...$arrays): bool
    {
        foreach ($arrays as $array) {
            if (empty($array)) return false;

            foreach ($array as $inputs) {

                if (gettype($inputs) !== 'array') {
                    if ($inputs < 0 || empty($inputs)) return false;
                    continue;
                }

                foreach ($inputs as $input) {
                    if ($input < 0) return false;
                }
            }
        }
        return true;
    }

    public function createWorkoutChart(array $workouts): Builder
    {
        $exerciseMaxWeights = $this->getMaxWeights($workouts['workouts']);
        $labels = $this->getLabels($workouts['workouts']);
        $datasets = $this->getData($exerciseMaxWeights, $labels);
        $yMax = $this->getYMax($exerciseMaxWeights) * $this->CHART_MODIFIER;
        $options = $this->getOptions($yMax);

        $chart = Chartjs::build()
            ->name("WorkoutProgressionChart")
            ->type("line")
            ->size(["width" => 400, "height" => 200])
            ->labels($labels)
            ->datasets($datasets)
            ->options($options);

        return $chart;
    }

    private function getMaxWeights(array $workouts): array
    {
        $maxWeights = [];
        foreach ($workouts as $date => $exercises) {
            $formattedDate = Carbon::parse($date)->format('m-d-Y');
            foreach ($exercises as $exerciseName => $sets) {
                foreach ($sets as $set) {
                    if (!isset($maxWeights[$exerciseName])) {
                        $maxWeights[$exerciseName] = [];
                    }
                    if (!isset($maxWeights[$exerciseName][$formattedDate]) || $set['weight'] > $maxWeights[$exerciseName][$formattedDate]) {
                        $maxWeights[$exerciseName][$formattedDate] = $set['weight'];
                    }
                }
            }
        }
        return $maxWeights;
    }

    private function getData(array $exerciseMaxWeights, array $labels): array
    {
        $datasets = [];

        foreach ($exerciseMaxWeights as $exerciseName => $dataByDate) {
            $data = [];
            foreach ($labels as $label) {
                $data[] = $dataByDate[$label] ?? null;
            }

            $datasets[] = [
                'label' => $exerciseName,
                'data' => $data,
                'fill' => false,
                'backgroundColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',0.3)',
                'borderColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ',0.7)',
            ];
        }

        return $datasets;
    }

    private function getLabels(mixed $workouts): array
    {
        $labels = [];
        foreach (array_keys($workouts) as $date) {
            $labels[] = Carbon::parse($date)->format('m-d-Y');
        }
        return $labels;
    }

    private function getOptions(int $yMax): array
    {
        return [
            'scales' => [
                'xAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => 'Workout Date'
                    ]
                ]],
                'yAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true,
                        'max' => $yMax,
                    ],
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => 'Weight (kg)'
                    ]
                ]],
            ],
            'plugins' => [
                'title' => [
                    'display' => true,
                    'text' => 'Max Weight per Exercise'
                ]
            ]
        ];
    }

    private function getYMax(array $exerciseMaxWeights): int
    {
        $yMax = 0;

        foreach ($exerciseMaxWeights as $exercises) {
            foreach ($exercises as $date => $weight) {
                if ($weight > $yMax) {
                    $yMax = $weight;
                }
            }
        }
        return $yMax;
    }
}
