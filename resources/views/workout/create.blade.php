@extends('layouts.main')

@section('title', 'Workout')

@section('content')
    <div class="flex flex-col items-center">
        <h1 class="text-3xl mt-6">{{$plan['name']}}</h1>

        <form action="/workout/create" method="POST" class="flex flex-col justify-center">
            @csrf
            <input hidden name="workout-plan-id" value="{{$plan['id']}}"/>

            @if(empty($plan['exercises']))
                <div class="flex flex-col items-center">
                    <h1 class="mt-6">You don't have any exercises for this template!</h1>

                    <a href="/workout-planner/edit/{{$plan['id']}}" class="w-full">
                        <x-button type="button"
                                  class="w-full mt-6 justify-center bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                            Edit Template
                        </x-button>
                    </a>
                </div>
            @else
                @foreach($plan['exercises'] as $exercise)
                    <div>
                        <p class="text-2xl underline pr-2 mt-6 text-center">{{ucfirst($exercise['data']['name'])}}</p>
                        <input type="number" name="exercise-id[]" value="{{ $exercise['id'] }}" hidden/>
                        <input type="text" name="exercise-name[]" value="{{ucfirst($exercise['data']['name'])}}"
                               hidden/>
                        <x-exercise.table>
                            @for($i = 0; $i < $exercise['sets']; $i++)
                                <x-exercise.table-row-input :i="$i" :id="$exercise['id']"/>
                            @endfor
                        </x-exercise.table>
                    </div>
                @endforeach

                <x-session-error></x-session-error>

                <div class="flex flex-col">
                    <x-button type="submit"
                              class="mt-6 justify-center bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                        Finish Workout
                    </x-button>

                    <a href="/workout-planner" class="w-full">
                        <x-button type="button"
                                  class="w-full mt-1 justify-center bg-red-800 hover:bg-red-700 focus:bg-red-700 active:bg-red-900">
                            Cancel Workout
                        </x-button>
                    </a>
                </div>
            @endif
        </form>
    </div>
@endsection
