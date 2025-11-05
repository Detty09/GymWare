@extends("layouts.main")

@section("title", "Exercise details")

@section("content")
    <div class="max-w-6xl mx-auto py-8 px-6">
        <div class="mb-5">
            <a class="" href="/exercises">
                <x-button
                    class="mt-6 justify-center bg-orange-600 border border-orange-600 hover:bg-orange-500 hover:border-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                    Back to the Catalog
                </x-button>
            </a>
        </div>
        <div class="bg-white/10 border border-white/20 rounded-xl p-6 flex flex-col md:flex-row gap-10">
            <div class="flex flex-col items-center md:items-start">
                <h1 class="text-3xl font-bold mb-4 text-orange-600">{{ ucfirst($exercise['name']) }}</h1>

                <div class="rounded-lg bg-white flex justify-center">
                    <img
                        src="{{ $exercise['gifUrl'] }}"
                        alt="{{ $exercise['name'] }}"
                        class="w-full max-w-xs h-auto object-contain my-6"
                    >
                </div>
            </div>
            <div>
                <div class="border-b-1 border-white/20 pb-3">
                    <p class="text-gray-100 mb-2 text-md font-light"><span class="font-bold">Body Parts:</span> {{ implode(', ', $exercise['bodyParts'] ?? []) }}</p>
                    <p class="text-gray-100 mb-2 text-md font-light"><span class="font-bold">Target Muscles:</span> {{ implode(', ', $exercise['targetMuscles'] ?? []) }}</p>
                    <p class="text-gray-100 mb-2 text-md font-light"><span class="font-bold">Secondary Muscles:</span> {{ implode(', ', $exercise['secondaryMuscles'] ?? []) }}</p>
                    <p class="text-gray-100 mb-2 text-md font-light"><span class="font-bold">Equipment:</span> {{ implode(', ', $exercise['equipments'] ?? []) }}</p>
                </div>
                <div class="mt-3">
                    <h2 class="text-2xl font-bold mb-2 text-orange-600">Instructions</h2>
                    <ul class="list-disc pl-6 text-gray-100 space-y-1 text-md font-light">
                        @foreach($exercise['instructions'] as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
