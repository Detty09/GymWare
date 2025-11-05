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
    private float $MAX_CHART_STEP = 10;
    private float $TOTAL_CHART_STEP = 200;
    protected WorkoutRepository $workoutRepository;
    protected WorkoutDetailRepository $workoutDetailRepository;
    protected WorkoutPlanRepository $workoutPlanRepository;

    public function __construct(WorkoutRepository $workoutRepository, WorkoutDetailRepository $workoutDetailRepository, WorkoutPlanRepository $workoutPlanRepository)
    {
        $this->workoutRepository = $workoutRepository;
        $this->workoutDetailRepository = $workoutDetailRepository;
        $this->workoutPlanRepository = $workoutPlanRepository;
    }


    public function createWorkout(int $planId, float $totalWeight): int
    {
        return $this->workoutRepository->create($planId, $totalWeight);
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
        $details = ['total_weight' => $workoutData['total_weight'], 'exercises' => []];
        $data = $workoutData['details'];

        for ($i = 0; $i < count($data); $i++) {
            $exercise = $data[$i]['name'];

            if (!array_key_exists($exercise, $details['exercises'])) {
                $details['exercises'][$exercise] = [
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],]
                ];
            } else {
                $details['exercises'][$exercise][] =
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],];
            }
        }

        $date = Carbon::parse($workoutData['date'])->format('d-m-Y H:i:s');

        return [$date => $details];
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

    public function getMaxLiftsChart(array $workouts): Builder
    {
        $exerciseMaxWeights = $this->getMaxWeights($workouts['workouts']);
        $labels = $this->getLabels($workouts['workouts']);

        $datasets = $this->getData($exerciseMaxWeights, $labels);
        $yMax = ceil($this->getYMax($exerciseMaxWeights) / $this->MAX_CHART_STEP) * $this->MAX_CHART_STEP + $this->MAX_CHART_STEP;
        $options = $this->getOptions($yMax, $this->MAX_CHART_STEP);

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
        foreach ($workouts as $date => $data) {
            $formattedDate = Carbon::parse($date)->format('d-m-Y H:i:s');
            foreach ($data['exercises'] as $exerciseName => $sets) {
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
            $bgColors = $this->getRandomColors($exerciseMaxWeights);

            foreach ($labels as $label) {
                $data[] = $dataByDate[$label] ?? null;
            }

            $datasets[] = [
                'label' => $exerciseName,
                'data' => $data,
                'fill' => false,
                'borderColor' => $bgColors,
            ];
        }
        return $datasets;
    }

    private function getLabels(mixed $workouts): array
    {
        $labels = [];
        foreach (array_keys($workouts) as $date) {
            $labels[] = Carbon::parse($date)->format('d-m-Y H:i:s');
        }
        return $labels;
    }

    private function getOptions(int $yMax, int $step = 10): array
    {
        return [
            'scales' => [
                'xAxes' => [[
                    'scaleLabel' => [
                        'display' => true,
                        'labelString' => 'Workout Date'
                    ],
                    'ticks' => [
                        'autoSkip' => true,
                        'maxTicksLimit' => 10
                    ]
                ]],
                'yAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true,
                        'max' => $yMax,
                        'stepSize' => $step,
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

    public function getTotalWeight(array $exerciseId, array $weights, array $reps): float
    {
        $total = 0;

        foreach ($exerciseId as $exercise) {
            for ($i = 0; $i < count($weights[$exercise]); $i++) {
                $total += $weights[$exercise][$i] * $reps[$exercise][$i];
            }
        }

        return $total;
    }

    public function getTotalWeightsChart($id): Builder
    {
        $data = $this->workoutRepository->findByPlanIdDateAndWeight($id);
        $labels = array_keys($data);
        $totalWeights = array_values($data);

        $datasets = $this->getDataForTotalWeights($totalWeights);
        $yMax = ceil(max($totalWeights) / $this->TOTAL_CHART_STEP) * $this->TOTAL_CHART_STEP + $this->TOTAL_CHART_STEP;
        $options = $this->getOptions($yMax, $this->TOTAL_CHART_STEP);

        $chart = Chartjs::build()
            ->name("WorkoutProgressionChart")
            ->type("bar")
            ->size(["width" => 400, "height" => 200])
            ->labels($labels)
            ->datasets($datasets)
            ->options($options);

        return $chart;
    }

    private function getDataForTotalWeights(array $totalWeights): array
    {

        return [[
            'label' => 'Total Weight',
            'data' => $totalWeights,
            'fill' => false,
            'borderColor' => 'rgba(0, 0, 0, 0.9)',
            'borderWidth' => 1,
            'backgroundColor' => 'rgba(234, 90, 21, 1)',
        ]];
    }

    private function getRandomColors(array $array): array
    {
        $colors = [];

        foreach ($array as $value) {
            $r = rand(50, 255);
            $g = rand(50, 255);
            $b = rand(50, 255);

            $colors[] = "rgba($r, $g, $b, 0.7)";
        }
        return $colors;
    }
}
