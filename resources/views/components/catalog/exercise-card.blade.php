@props(["exercise", "plan" => null])

<div class="bg-white rounded-lg overflow-hidden flex border border-gray-200">
    <div class="p-4 text-start">
        <h2 class="text-lg font-bold mb-2 text-gray-900">{{ ucfirst($exercise['name']) }}</h2>
        <p class="text-gray-600 mb-2 text-sm">
            <strong>Body Parts:</strong> {{ implode(', ', $exercise['bodyParts'] ?? []) }}
        </p>
        <p class="text-gray-600 mb-2 text-sm">
            <strong>Target Muscles:</strong> {{ implode(', ', $exercise['targetMuscles'] ?? []) }}
        </p>
        <p class="text-gray-600 mb-2 text-sm">
            <strong>Equipment:</strong> {{ implode(', ', $exercise['equipments'] ?? []) }}
        </p>

        @if( $plan )
            <form action="/workout-planner/exercise/{{$plan['id']}}" method="POST"
                  class="flex flex-col justify-center mt-6">
                @csrf
                <input hidden name="plan-id" value="{{$plan['id']}}"/>
                <input hidden name="name" value="{{ ucfirst($exercise['name']) }}"/>
                <input hidden name="api-exercise-id" value="{{ $exercise['exerciseId'] }}"/>

                <div class="flex flex-row">
                    <label for="sets" class="text-gray-600 mb-2 text-sm">
                        <strong>Sets:</strong>
                    </label>
                    <input id="sets" name="sets" type="number" min="1" required class="w-10 text-gray-600 mb-2 text-sm text-center align-middle"/>
                </div>
                <x-button type="submit"
                          class="mt-1 justify-center bg-blue-600  hover:bg-blue-700 transition focus:bg-blue-600 active:bg-blue-900">
                    Add
                </x-button>
            </form>
        @endif

    </div>
    <div class="p-2">
        <img src="{{ $exercise['gifUrl'] }}" alt="{{ $exercise['name'] }}" class="w-full h-48 object-contain">
    </div>



</div>
