@extends('layouts.plan')

@section('title', 'Exercise Catalog')

@section('content')

    <div class="max-w-6xl min-w-6xl mx-auto py-8">
        <div class="mb-2">
            <h1 class="text-3xl font-bold mb-6">Add exercise to {{$plan['name']}}</h1>
            <a href="/workout-planner/edit/{{ $plan['id'] }}">
                <x-button
                    class="justify-center bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                    Back to {{ $plan['name'] }} template
                </x-button>
            </a>
        </div>

        <x-catalog.filtering-form
            :action="url('/workout-planner/exercise/create/' . $plan['id'])"
            :bodyparts="$bodyparts"
            :equipments="$equipments"
            :selected-bodypart="$selectedBodypart"
            :selected-equipment="$selectedEquipment"
        />

        @if(isset($error))
            <div class="bg-red-100 text-red-800 p-4 rounded mb-6">
                {{ $error }}
            </div>
        @endif

        <x-session-error></x-session-error>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($exercises['data'] ?? [] as $exercise)
                <x-catalog.exercise-card :exercise="$exercise" :plan="$plan"></x-catalog.exercise-card>
            @empty
                <p>No exercises found</p>
            @endforelse
        </div>

        @if(isset($exercises['metadata']))
            <x-catalog.pagination
                :exercises="$exercises"
                :selectedEquipment="$selectedEquipment"
                :selectedBodypart="$selectedBodypart"
                :page="$page"
            />
        @endif

    </div>
@endsection
