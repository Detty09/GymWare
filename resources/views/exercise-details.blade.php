@extends("layouts.plan")

@section("title", "Exercise details")

@section("content")
    <div class="max-w-6xl mx-auto py-8">
        <a href="/exercises" class="text-orange-600 mb-4 inline-block hover:text-white hover:scale-102 items-center gap-2 transition ease-in-out duration-100">
            <i class="fas fa-left-long"></i>
            <span>Back to catalog</span>
        </a>
        <div class="bg-white/10 border border-gray-700 rounded-xl p-6 flex gap-20">
            <div class="flex flex-col">
                <div>
                    <h1 class="text-3xl font-bold mb-4 text-orange-600">{{ ucfirst($exercise['name']) }}</h1>
                </div>
                <div class="flex-1 rounded-lg bg-white">
                    <img src="{{ $exercise['gifUrl'] }}" alt="{{ $exercise['name'] }}" class="h-full w-80 object-contain mb-6">
                </div>
            </div>
            <div>
                <div class="border-b-1 border-gray-600 pb-3">
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
