<?php

namespace App\Services;

use IcehouseVentures\LaravelChartjs\Builder;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Support\Carbon;

class ChartService
{
    private float $MAX_CHART_STEP = 10;
    private float $TOTAL_CHART_STEP = 200;

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

    public function getTotalWeightsChart($data): Builder
    {
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
