@extends('layouts.main')

@section('title', "Progression of {$plan}")

@section('content')
    <div class="flex flex-col items-center w-full">

        <form method="GET" action="/workout/progression/{{$id}}"
              class="mt-6">
            <label for="chart">Chart to show:</label>
            <select
                name="chart"
                id="chart"
                class="border border-gray-700 rounded-lg px-3 py-2 text-black bg-white/10 hover:border-orange-600 transition ease-in-out duration-100"
                onChange="this.form.submit()"
            >
                <option
                    class="text-black"
                    value="max-lifts"
                    {{ request('chart') === 'max-lifts' ? 'selected' : '' }}>
                    Max Lifts
                </option>
                <option
                    class="text-black"
                    value="total-weight"
                    {{ request('chart') === 'total-weight' ? 'selected' : '' }}>
                    Total Weight
                </option>
            </select>
        </form>

        @if (isset($error))
            <h1 class="text-2xl mt-6 text-red-600">{{$error}}</h1>
        @endif

        @if (isset($chart))
            <x-button type="button" id="download"
                      class="mt-6 justify-center bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                Download Chart
            </x-button>
            <div class="w-3/4 mt-20">
                <h1 class="text-center text-3xl font-bold mb-6">Progression of {{$plan}}</h1>
                <x-chartjs-component :chart="$chart"/>
            </div>
        @endif

        <a class="" href="/workout-planner">
            <x-button
                class="mt-6 justify-center bg-gray-800 hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900">
                Go
                Back to Planner
            </x-button>
        </a>
    </div>

    <script>
        document.getElementById('download').addEventListener('click', async () => {
            const canvas = document.querySelector('canvas');
            const image = canvas.toDataURL('image/png');

            const response = await fetch('/workout/progression/download', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    image: image,
                    plan: '{{ $plan }}'
                })
            });

            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `{{ Str::slug($plan) }}-chart-{{ date('d-m-Y') }}.pdf`;
            a.click();
            window.URL.revokeObjectURL(url);
        });
    </script>
@endsection
