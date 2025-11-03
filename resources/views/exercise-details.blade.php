@extends("layouts.plan")

@section("title", "Exercise details"))

@section("content")
    <div class="max-w-6xl mx-auto py-8">
        <a href="/exercises" class="text-blue-600 underline mb-4 inline-block">Back to catalog</a>
        <div class="bg-white border border-gray-200 rounded-lg p-6 flex gap-20">
            <div class="flex flex-col">
                <div>
                    <h1 class="text-3xl font-bold mb-4">{{ ucfirst($exercise['name']) }}</h1>
                </div>
                <div class="flex-1">
                    <img src="{{ $exercise['gifUrl'] }}" alt="{{ $exercise['name'] }}" class="h-full w-80 object-contain mb-6">
                </div>
            </div>
            <div>
                <p class="text-gray-600 mb-2"><strong>Body Parts:</strong> {{ implode(', ', $exercise['bodyParts'] ?? []) }}</p>
                <p class="text-gray-600 mb-2"><strong>Target Muscles:</strong> {{ implode(', ', $exercise['targetMuscles'] ?? []) }}</p>
                <p class="text-gray-600 mb-2"><strong>Secondary Muscles:</strong> {{ implode(', ', $exercise['secondaryMuscles'] ?? []) }}</p>
                <p class="text-gray-600 mb-2"><strong>Equipment:</strong> {{ implode(', ', $exercise['equipments'] ?? []) }}</p>
                <div class="mt-6">
                    <h2 class="text-xl font-semibold mb-2">Instructions</h2>
                    <ul class="list-disc pl-6 text-gray-700 space-y-1">
                        @foreach($exercise['instructions'] as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
