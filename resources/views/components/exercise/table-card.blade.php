<div class="flex flex-col">
    <p class="text-xl pr-2 mt-6 text-start">{{$exerciseName}}</p>
    <x-exercise.table>
        @foreach($exerciseData as $setData)
            <x-exercise.table-row-history :set-data="$setData"></x-exercise.table-row-history>
        @endforeach
    </x-exercise.table>
</div>
