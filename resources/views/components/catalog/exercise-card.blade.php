@props(["exercise", "plan" => null])

@php
    $hoverClasses = !$plan
        ? "hover:shadow-xl hover:border-orange-600 hover:scale-105 cursor-pointer" : '';
@endphp

<div class="bg-white/10 overflow-hidden flex justify-between h-full border border-white/20 rounded-xl shadow-md transition-transform ease-in-out duration-200 {{ $hoverClasses }}">
    <div class="p-3 text-start flex flex-col justify-between gap-2">
        <div>
            <h2 class="text-lg font-bold mb-2 text-orange-600">{{ ucfirst($exercise['name']) }}</h2>
            <p class="text-gray-100 mb-2 text-sm">
                <strong>Body Parts:</strong> {{ implode(', ', $exercise['bodyParts'] ?? []) }}
            </p>
            <p class="text-gray-100 mb-2 text-sm">
                <strong>Target Muscles:</strong> {{ implode(', ', $exercise['targetMuscles'] ?? []) }}
            </p>
            <p class="text-gray-100 mb-2 text-sm">
                <strong>Equipment:</strong> {{ implode(', ', $exercise['equipments'] ?? []) }}
            </p>
        </div>

        @if( $plan )
            <div class="border-t border-white/20">
                <form action="/workout-planner/exercise/{{$plan['id']}}" method="POST"
                      class="flex flex-col justify-center mt-6">
                    @csrf
                    <input hidden name="plan-id" value="{{$plan['id']}}"/>
                    <input hidden name="name" value="{{ ucfirst($exercise['name']) }}"/>
                    <input hidden name="api-exercise-id" value="{{ $exercise['exerciseId'] }}"/>

                    <div class="flex flex-row gap-2">
                        <label for="sets" class="text-gray-100 font-light mb-2 text-sm">
                            <strong>Sets:</strong>
                        </label>
                        <input id="sets" name="sets" type="number" min="1" step="1" placeholder="0" required class="w-15 border border-orange-600 rounded-md text-gray-100 mb-2 text-sm text-center align-middle focus:outline-none focus:ring focus:ring-orange-600 focus:ring-offset"/>
                    </div>
                    <x-button type="submit"
                              class="mt-6 justify-center bg-orange-600  hover:bg-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                        Add
                    </x-button>
                </form>
            </div>
        @endif

    </div>
    <div class="min-w-32 max-w-32 m-3 border border-gray-200 rounded-lg bg-white aspect-square overflow-hidden flex justify-center items-center">
        <img src="{{ $exercise['gifUrl'] }}" alt="{{ $exercise['name'] }}" class="w-full h-48 object-contain">
    </div>



</div>
