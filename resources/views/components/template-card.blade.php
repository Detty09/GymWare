<div class="flex flex-row space-x-4 items-center border-2 rounded-sm p-2">
    <p class="text-xl font-bold text-gray-700">{{ $plan['name'] }}</p>

    <div class="relative group inline-block">
        <a href="/workout/create/{{ $plan['id'] }}" class="text-xl text-gray-700 hover:text-blue-600">
            <i class="fa-solid fa-dumbbell"></i>
        </a>
        <span
            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
        Start Workout
    </span>
    </div>

    <div class="relative group inline-block">
        <a href="/workout/history/{{ $plan['id'] }}" class="text-xl text-gray-700 hover:text-blue-600">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </a>
        <span
            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
        Workout History
    </span>
    </div>

    <div class="relative group inline-block">
        <a href="/workout-planner/edit/{{ $plan['id'] }}" class="text-xl text-gray-700 hover:text-blue-600">
            <i class="fa-solid fa-file-pen"></i>
        </a>
        <span
            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
        Edit Template
    </span>
    </div>

    <form method="POST" action="/workout-planner/{{ $plan['id'] }}">
        @csrf
        @method('DELETE')

        <div class="relative group inline-block">
            <button type="submit" class="cursor-pointer text-xl text-gray-700 hover:text-blue-600">
                <i class="fa-solid fa-trash"></i>
            </button>
            <span
                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                Delete Template
            </span>
        </div>
    </form>
</div>


