@extends('layouts.main')

@section('title', 'Edit planner plan')

@section('content')
    <div class="relative min-h-screen w-full">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('/images/planner-bg.jpg')"></div>

        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative flex justify-center p-10">
            <div class="min-w-1/3 flex flex-col items-center mt-6 space-y-6 text-gray-100 bg-[#141414]/90 border border-white/20 p-5 rounded-xl">
                <h1 class="text-orange-600 font-semibold text-md">Edit template:  <span class="text-gray-100">{{ $plan['name'] }}</span></h1>

                <form action="/workout-planner/{{$plan['id']}}" method="POST" class="w-full">
                    @csrf
                    @method('PATCH')

                    <div class="flex flex-col gap-2 items-center justify-center h-full">
                        <div class="flex w-full justify-between">
                            <div>
                                <label for="name" class="text-sm mr-2">
                                    Workout Name:
                                </label>
                                <input placeholder='{{ $plan['name'] }}'
                                       id="name"
                                       name="name"
                                       required
                                       class="text-sm border border-white/20 p-1 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-600"
                                />
                            </div>

                            <div>
                                <x-button type="submit"
                                          class="justify-center bg-transparent border border-orange-600 hover:bg-orange-500 hover:border-orange-500 transition ease-in-out duration-200 focus:bg-orange-600">
                                    Rename
                                </x-button>
                            </div>
                        </div>

                        <x-form.error name="name"/>
                    </div>
                </form>

                @if(empty($plan['exercises']))
                    <div>
                        <h1 class="italic text-sm font-light">You have no exercises yet!</h1>
                    </div>
                @else
                    @foreach($plan['exercises'] as $exercise)
                        @include('components.exercise.card', ['exercise' => $exercise])
                    @endforeach
                @endif

                <div class="flex gap-2 items-center">
                    <a href="/workout-planner/exercise/create/{{ $plan['id'] }}">
                        <x-button type="button"
                                  class="justify-center bg-orange-600 border border-orange-600  hover:bg-orange-500 hover:border-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                            Add new Exercise
                        </x-button>
                    </a>

                    <a href="/workout-planner">
                        <x-button type="button"
                                  class="justify-center bg-transparent border border-orange-600 hover:bg-orange-500 hover:border-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                            Back to Plans
                        </x-button>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
