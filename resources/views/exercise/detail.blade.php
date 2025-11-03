@extends('layouts.plan')

@section('title', 'Add details')

@section('content')
    <div class="flex flex-col justify-center">
        <h1 class="text-center text-2xl mb-6">Details of {{$exercise['name']}}</h1>

        <form action="/workout-planner/details/{{$exercise['id']}}" method="POST"
              class="flex flex-col space-y-2">
            @csrf
            <input hidden name="exercise-id" value="{{$exercise['id']}}"/>
            <input hidden name="plan-id" value="{{session('plan_id')}}"/>

            <div id="sets-container">
                <div class="flex flex-row space-x-2 set-row">
                    <p>Set 1</p>
                    <input hidden name="set[]" value="1"/>
                    <div>
                        <label for="weight">Weight (kg)</label>
                        <input id="weight" name="weight[]" type="number" required/>
                    </div>
                    <div>
                        <label for="rep">Repetitions</label>
                        <input id="rep" name="rep[]" type="number" required/>
                    </div>
                </div>
            </div>

            <button type="button" id="add-set">Add set</button>

            <button type="submit">Add details</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addSetBtn = document.getElementById('add-set');
            const setsContainer = document.getElementById('sets-container');

            addSetBtn.addEventListener('click', function () {
                const currentSets = setsContainer.querySelectorAll('.set-row').length;
                const nextSetNumber = currentSets + 1;

                const newSet = document.createElement('div');
                newSet.classList.add('flex', 'flex-row', 'space-x-2', 'set-row');
                newSet.innerHTML = `
                    <p>Set ${nextSetNumber}</p>
                    <input hidden name="set[]" value="${nextSetNumber}"/>
                    <div>
                        <label for="weight">Weight (kg)</label>
                        <input id="weight" name="weight[]" type="number" required/>
                    </div>
                    <div>
                        <label for="rep">Repetitions</label>
                        <input id="rep" name="rep[]" type="number" required/>
                    </div>
                `;
                setsContainer.appendChild(newSet);
            });
        })
    </script>

@endsection
