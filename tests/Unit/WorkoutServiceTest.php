<?php

use App\Services\WorkoutService;

it('validates positive inputs correctly', function () {
    $service = app(WorkoutService::class);

    $result = $service->validateInputs(
        [1, 2, 3],
        [[1, 2], [3, 4]]
    );

    expect($result)->toBeTrue();
});

it('fails when negative or empty values exist', function () {
    $service = app(WorkoutService::class);

    $result = $service->validateInputs([0, -1], []);

    expect($result)->toBeFalse();
});

use App\Repositories\WorkoutRepository;
use App\Repositories\WorkoutDetailRepository;
use App\Repositories\WorkoutPlanRepository;

beforeEach(function () {
    $this->workoutRepo = Mockery::mock(WorkoutRepository::class);
    $this->detailRepo = Mockery::mock(WorkoutDetailRepository::class);
    $this->planRepo = Mockery::mock(WorkoutPlanRepository::class);

    $this->service = new WorkoutService($this->workoutRepo, $this->detailRepo, $this->planRepo);
});

it('creates a workout by calling repository', function () {
    $this->workoutRepo
        ->shouldReceive('create')
        ->once()
        ->with(1, 200.5)
        ->andReturn(42);

    $result = $this->service->createWorkout(1, 200.5);

    expect($result)->toBe(42);
});

it('calculates total weight correctly', function () {
    $exerciseIds = ['1', '2'];
    $weights = [
        '1' => [10, 20],
        '2' => [30]
    ];
    $reps = [
        '1' => [10, 5],
        '2' => [8]
    ];

    $result = $this->service->getTotalWeight($exerciseIds, $weights, $reps);

    expect($result)->toEqual(10*10 + 20*5 + 30*8);
});


