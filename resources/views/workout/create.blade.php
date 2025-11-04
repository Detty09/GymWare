@extends('layouts.main')

@section('title', 'Workout')

@section('content')
    <div class="relative min-h-screen w-full">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('/images/planner-bg.jpg')">
        </div>

        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative flex justify-center p-10">
            <div class="flex flex-col items-center bg-[#141414]/90 py-5 px-10 mt-6 text-gray-100 rounded-xl border border-white/20">
                <h1 class="text-3xl font-semibold">{{$plan['name']}} workout</h1>

                <form action="/workout/create" method="POST" class="flex flex-col justify-center">
                    @csrf
                    <input hidden name="workout-plan-id" value="{{$plan['id']}}"/>

                    @if(empty($plan['exercises']))
                        <div class="flex flex-col items-center">
                            <h1 class="mt-6 text-sm font-light italic">You don't have any exercises for this template!</h1>

                            <a href="/workout-planner/edit/{{$plan['id']}}" class="w-full">
                                <x-button type="button"
                                          class="w-full mt-6 justify-center bg-orange-600 hover:bg-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                                    Edit Template
                                </x-button>
                            </a>
                        </div>
                    @else
                        @foreach($plan['exercises'] as $exercise)
                            <div class="flex flex-col py-6 border-b border-white/20">
                                <p class="text-xl pr-2">{{ucfirst($exercise['data']['name'])}}</p>
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

                        <div class="flex gap-5 mx-auto items-center mt-10">
                            <x-button type="submit"
                                      class="justify-center bg-orange-600 hover:bg-orange-500 border border-orange-600 hover:border-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                                Finish Workout
                            </x-button>

                            <a href="/workout-planner">
                                <x-button type="button"
                                          class="justify-center bg-transparent border border-orange-600 hover:border-orange-500 hover:bg-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                                    Cancel Workout
                                </x-button>
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection
