@extends('layouts.plan')

@section('title', 'Exercise Planner')

@section('content')
    <div class="flex flex-col items-center mt-6 space-y-6">
        <h1>My Templates</h1>

        @if(empty($plans))
            <div>
                <h1>You have no templates yet!</h1>
            </div>
        @else
            @foreach($plans as $plan)
                @include('components.template-card', ['plan' => $plan])
            @endforeach
        @endif

        <h1>Create a new template for your workouts!</h1>

        <form action="/workout-planner" method="POST" class="flex flex-col">
            @csrf
            <div>
                <label for="name">
                    Workout Name:
                </label>
                <input placeholder="Leg day..."
                       id="name"
                       name="name"
                       required
                />

                <x-form.error name="name"/>

            </div>

            <x-button type="submit"
                      class="mt-1 justify-center bg-blue-600  hover:bg-blue-700 transition focus:bg-blue-600 active:bg-blue-900">
                Create new Plan
            </x-button>
        </form>
    </div>
@endsection
