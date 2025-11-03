@extends('layouts.main')

@section('title', "Workout History")

@section('content')
    <div class="flex flex-col items-center">
        <h1 class="text-3xl m-6">Workout History</h1>

        @if (empty($data))
            <p>You haven't finished any workout yet!</p>
        @else
            @foreach($data as $template => $workouts)
                <div>
                    <h1 class="text-2xl m-6">{{$template}}</h1>
                </div>
                @foreach($workouts as $date => $details)
                    <div class="text-center border-2 rounded-md p-6 mb-6">
                        <h1 class="text-2xl">Workout - {{$loop->iteration}}</h1>
                        <p class="italic">{{ $date }}</p>
                        @foreach($details as $exerciseName => $exerciseData )
                            <x-exercise.table-card :exercise-name="$exerciseName"
                                                   :exercise-data="$exerciseData"></x-exercise.table-card>
                        @endforeach
                    </div>
                @endforeach
            @endforeach
        @endif
    </div>
@endsection
