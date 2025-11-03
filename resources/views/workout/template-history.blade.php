@extends('layouts.main')

@section('title', "History of {$data['name']}")

@section('content')
    <div class="flex flex-col items-center">
        <h1 class="text-3xl m-6">{{$data['name']}}</h1>

        @if(empty($data['workouts']))
            <h1 class="text-2xl mt-6">You have no workouts for this template yet!</h1>
        @else
            @foreach($data['workouts'] as $date => $workout)
                <div class="text-center border-2 rounded-md p-6 mb-6">
                    <h1 class="text-2xl">Workout - {{$loop->iteration}}</h1>
                    <p class="italic">{{ $date }}</p>
                    @foreach($workout as $exerciseName => $exerciseData )
                        <x-exercise.table-card :exercise-name="$exerciseName"
                                               :exercise-data="$exerciseData"></x-exercise.table-card>
                    @endforeach
                </div>
            @endforeach
        @endif

        <a class="w-full" href="/workout-planner">
            <x-button
                class="w-full mt-6 justify-center bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                Go
                Back to Planner
            </x-button>
        </a>
    </div>
@endsection
