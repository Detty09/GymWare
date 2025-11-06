<div class="flex lg:flex-row justify-between w-full space-x-4 items-center border-1 border-white/10 rounded-lg py-2 px-3 text-gray-100 bg-white/10">
    <div class="w-full">
        <p class="text-md font-semibold overflow-x-hidden">{{ $plan['name'] }}</p>
    </div>

    <div class="flex flex-row gap-4">
        <div class="relative group inline-block border-l pl-4 border-white/20">
            <a href="/workout/create/{{ $plan['id'] }}" class="text-xl text-orange-600 hover:text-gray-100">
                <i class="fa-solid fa-dumbbell"></i>
            </a>
            <span
                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            Start Workout
        </span>
        </div>

        <div class="relative group inline-block">
            <a href="/workout/history/{{ $plan['id'] }}" class="text-xl text-orange-600 hover:text-gray-100">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </a>
            <span
                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            Workout History
        </span>
        </div>

        <div class="relative group inline-block">
            <a href="/workout/progression/{{ $plan['id'] }}" class="text-xl text-orange-600 hover:text-gray-100">
                <i class="fa-solid fa-chart-simple"></i>
            </a>
            <span
                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            Progression
        </span>
        </div>

        <div class="relative group inline-block">
            <a href="/workout-planner/edit/{{ $plan['id'] }}" class="text-xl text-orange-600 hover:text-gray-100">
                <i class="fa-solid fa-file-pen"></i>
            </a>
            <span
                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            Edit Template
        </span>
        </div>

        @if (Auth::user()->subscription)
            <form method="POST" action="/workout/download/{{ $plan['id'] }}">
                @csrf

                <div class="relative group inline-block">
                    <button type="submit" class="cursor-pointer text-xl text-orange-600 hover:text-gray-100">
                        <i class="fa-solid fa-file-export"></i>
                    </button>
                    <span
                        class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    Download Template PDF
                </span>
                </div>
            </form>
        @else
            <div class="relative group inline-block">
                <button disabled type="submit" class="opacity-50 cursor-not-allowed text-xl text-orange-600 hover:text-gray-100">
                    <i class="fa-solid fa-file-export"></i>
                </button>
                <span
                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    Subscription Required
                </span>
            </div>
        @endif

        <form method="POST" action="/workout-planner/{{ $plan['id'] }}" class="delete-form">
            @csrf
            @method('DELETE')

            <div class="relative group inline-block border-l border-white/20 pl-3">
                <button type="button" class="cursor-pointer text-xl text-red-600 hover:text-red-400"
                onclick="openConfirmModal(event)">
                    <i class="fa-solid fa-trash"></i>
                </button>
                <span
                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    Delete Template
                </span>
            </div>
        </form>

        <x-confirm-modal question="Are you sure you want to delete this template?"
                         confirm="Delete"
                         cancel="Cancel"
        ></x-confirm-modal>
    </div>
</div>


