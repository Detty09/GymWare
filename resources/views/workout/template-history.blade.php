@extends('layouts.main')

@section('title', "History of {$data['name']}")

@section('content')
    <div class="relative min-h-screen w-full">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('/images/planner-bg.jpg')">
        </div>

        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative flex justify-center p-10">
            <div class="flex flex-col items-center bg-[#141414]/90 max-w-7xl px-10 sm:px-20 py-10 mt-6 text-gray-100 rounded-xl border border-white/20">
                <h1 class="text-3xl font-semibold mb-6">{{$data['name']}} workouts</h1>

                @if(empty($data['workouts']))
                    <h1 class="mt-6 text-sm font-light italic">You have no workouts for this template yet!</h1>
                @else
                    <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-6 w-full">
                        @foreach($data['workouts'] as $date => $workout)
                            <div class="text-center bg-white/5 border border-white/10 rounded-xl p-6">
                                <h1 class="text-xl">Workout - {{$loop->iteration}}</h1>
                                <p class="italic text-sm font-light">{{ $date }}</p>
                                <p class="text-sm mt-4">Total weight: <span class="text-orange-600 font-semibold">{{$workout['total_weight']}} kg</span></p>
                                @foreach($workout['exercises'] as $exerciseName => $exerciseData)
                                    <x-exercise.table-card :exercise-name="$exerciseName"
                                                           :exercise-data="$exerciseData" />
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @endif

                <a href="/workout-planner">
                    <x-button
                        class="mt-6 justify-center bg-orange-600 hover:bg-orange-500 hover:scale-105 transition-transform ease-in-out duration-200 cursor-pointer">
                        Go Back to Planner
                    </x-button>
                </a>
            </div>
        </div>
    </div>
@endsection
