<form method="POST" action="/workout-planner/exercise/{{ $exercise['id'] }}"
      class="flex-grow items-center w-full bg-white/5 rounded-lg p-5 transition border border-white/10"
      class="delete-form">
    @csrf
    @method('DELETE')

    <div class="flex gap-5 justify-start items-center">
        <div class="w-32 h-32 bg-white rounded-xl overflow-hidden flex-shrink-0">
            <img src="{{ $exercise['data']['gifUrl'] }}" alt="picture of the exercise"
                 class="w-full h-full object-cover">
        </div>
        <div class="flex flex-col ml-4 text-gray-100">
            <p class="text-md">
                <span class="text-orange-600 font-semibold">{{ $exercise['sets'] }}x</span>
                {{ ucfirst($exercise['data']['name']) }}
            </p>
        </div>
        <div class="ml-auto border-l border-white/20 pl-5">
            <input type="hidden" name="plan-id" value="{{ $plan['id'] }}">
            <button type="button" class="cursor-pointer text-red-600 hover:text-red-400 transition"
                    onclick="openConfirmModal(event)">
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>
    </div>

    <x-confirm-modal
        question="Are you sure you want to delete this exercise?"
        confirm="Delete"
        cancel="Cancel">
    </x-confirm-modal>
</form>
