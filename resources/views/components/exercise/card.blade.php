<form method="POST" action="/workout-planner/exercise/{{ $exercise['id'] }}"
      class="flex flex-row space-x-4 items-center">
    @csrf
    @method('DELETE')

    <img src="{{$exercise['data']['gifUrl']}}" alt="picture of the exercise">

    <p class="text-2xl underline pr-2">
        {{ $exercise['sets'] }} x {{ ucfirst($exercise['data']['name']) }}
    </p>

    <input type="hidden" name="plan-id" value="{{ $plan['id'] }}">
    <button class="cursor-pointer"><i class="fa-solid fa-trash"></i></button>
</form>
