@extends('layouts.plan')

@section('title', 'Edit planner plan')

@section('content')
    <div class="flex flex-col items-center mt-6 space-y-6">
        <h1>Edit template {{ $plan['name'] }}</h1>

        <form action="/workout-planner/{{$plan['id']}}" method="POST">
            @csrf
            @method('PATCH')

            <div>
                <label for="name">
                    Workout Name:
                </label>
                <input placeholder='{{ $plan['name'] }}'
                       id="name"
                       name="name"
                       required
                />

                <x-form.error name="name"/>

                <x-button type="submit"
                          class="mt-1 justify-center bg-blue-600  hover:bg-blue-700 transition focus:bg-blue-600 active:bg-blue-900">
                    Rename
                </x-button>
            </div>
        </form>

        @if(empty($plan['exercises']))
            <div>
                <h1>You have no exercises yet!</h1>
            </div>
        @else
            @foreach($plan['exercises'] as $exercise)
                @include('components.exercise.card', ['exercise' => $exercise])
            @endforeach
        @endif

        <div class="flex flex-col">
            <a href="/workout-planner/exercise/create/{{ $plan['id'] }}">
                <x-button type="button"
                          class="mt-6 justify-center bg-blue-600  hover:bg-blue-700 transition focus:bg-blue-600 active:bg-blue-900">
                    Add new Exercise
                </x-button>
            </a>

            <a href="/workout-planner" class="w-full">
                <x-button type="button"
                          class="w-full mt-1 justify-center bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                    Back to Plans
                </x-button>
            </a>
        </div>
    </div>

@endsection
