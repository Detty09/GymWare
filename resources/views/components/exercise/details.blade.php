<div class="flex flex-col space-x-4 items-center">
    <div class="flex flex-row space-x-4 items-center">
        <p class="text-2xl underline pr-2">{{$exercise['name']}}</p>

        <button form="delete-form" class="cursor-pointer"><i class="fa-solid fa-trash"></i></button>
    </div>

    <table class="mt-2 border-2">
        <thead>
        <tr class="font-bold">
            <td class="border-1 px-4">
                #
            </td>
            <td class="border-1 px-4">
                Weight
            </td>
            <td class="border-1 px-4">
                Repetition
            </td>
        </tr>
        </thead>
        <tbody>
        @foreach($exercise['exercise_details'] as $detail)
            <tr>
                <td class="border-1 px-4">
                    {{ $detail['set'] }}
                </td>
                <td class="border-1 px-4">
                    {{ $detail['weight'] }}
                </td>
                <td class="border-1 px-4">
                    {{ $detail['rep'] }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <form method="POST" id="delete-form" action="/workout-planner/exercise/{{ $exercise['id'] }}" class="hidden">
        @csrf
        @method('DELETE')
        <input hidden name="plan-id" value="{{$plan['id']}}"/>
    </form>
</div>
