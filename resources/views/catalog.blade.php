@extends('layouts.main')

@section('title', 'Exercise Catalog')

@section('content')

    <div class="max-w-6xl mx-auto py-8 px-6">
        <x-catalog.filtering-form
            action="/exercises"
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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($exercises['data'] ?? [] as $exercise)
                <a href="{{ route("exercises.show", [
                    "id" => $exercise["exerciseId"],
                    "page" => $page,
                    "bodypart" => $selectedBodypart,
                    "equipment" => $selectedEquipment
                    ])}}"
                >
                    <x-catalog.exercise-card :exercise="$exercise"></x-catalog.exercise-card>
                </a>
            @empty
                <div class="bg-white/5 border border-white/20 p-2 rounded-xl">
                    <p class="text-red-500">No exercises found</p>
                </div>

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
