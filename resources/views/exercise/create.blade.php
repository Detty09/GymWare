@extends('layouts.main')

@section('title', 'Exercise Catalog')

@section('content')

    <div class="max-w-6xl min-w-6xl mx-auto py-8">
        <div class="mb-5">
            <h1 class="text-2xl font-semibold mb-6 text-gray-100">Add exercise to <span class="text-orange-600 font-bold text-3xl">{{$plan['name']}}</span> workout</h1>
            <a href="/workout-planner/edit/{{ $plan['id'] }}" class="text-orange-600 mb-4 inline-block hover:text-white hover:scale-102 items-center gap-2 transition ease-in-out duration-100">
                <i class="fas fa-left-long"></i>
                <span>Back to workout template</span>
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
