@extends('layouts.main')

@section('title', "Workout History")

@section('content')

    <div class="relative min-h-screen w-full">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('/images/planner-bg.jpg')">
        </div>

        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative flex justify-center p-10">
            <div class="flex flex-col items-center text-gray-100 bg-[#141414]/90 max-w-7xl px-10 sm:px-20 py-10 mt-6 rounded-xl border border-white/20">
                <h1 class="text-3xl mb-5 font-semibold">Workout History</h1>

                @if (empty($data))
                    <p>You haven't finished any workout yet!</p>
                @else
                    @foreach($data as $template => $workouts)
                        <div>
                            <h1 class="text-2xl mb-5 font-semibold text-orange-600">{{$template}}</h1>
                        </div>
                        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-6 w-full mb-6">
                            @foreach($workouts as $date => $details)
                                <div class="text-center bg-white/5 border border-white/10 rounded-xl p-6">
                                    <h1 class="text-xl">Workout - {{$loop->iteration}}</h1>
                                    <p class="italic text-sm font-light">{{ $date }}</p>
                                    <p class="text-sm mt-4">Total weight: <span class="text-orange-600 font-bold">{{$details['total_weight']}} kg</span></p>
                                    @foreach($details['exercises'] as $exerciseName => $exerciseData )
                                        <x-exercise.table-card :exercise-name="$exerciseName"
                                                               :exercise-data="$exerciseData" />
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
