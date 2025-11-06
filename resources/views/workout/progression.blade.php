@extends('layouts.main')

@section('title', "Progression of {$plan}")

@section('content')
    <div class="flex flex-col items-center w-full px-10 bg-[#141414] text-gray-100">

        <div class="flex flex-col items-start justify-start w-3/4 pb-3 border-b border-white/20">
            <form method="GET" action="/workout/progression/{{$id}}"
                  class="mt-6 text-lg py-2 rounded-xl">
                <label for="chart" class="font-semibold">Chart to show:</label>
                <select
                    name="chart"
                    id="chart"
                    class="ml-2 text-sm border border-white/20 rounded-lg px-3 py-2 text-gray-100 hover:border-orange-600 transition ease-in-out duration-100"
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
        </div>

        @if (isset($error))
            <h1 class="text-2xl mt-6 text-red-600 w-3/4">{{$error}}</h1>
        @endif

        <div class="flex w-3/4 justify-between">
            <a class="" href="/workout-planner">
                <x-button
                    class="mt-6 justify-center border border-orange-600 hover:bg-orange-500 hover:border-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                    Back to Planner
                </x-button>
            </a>

            @if (isset($chart))
                @if (Auth::user()->subscription)
                    <div class="flex justify-end w-3/4">
                        <x-button type="button" id="download"
                                  class="my-6 bg-orange-600 border border-orange-600 hover:bg-orange-500 hover:border-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                            Download Chart
                        </x-button>
                    </div>
                @else
                    <div class="flex justify-end w-3/4">
                        <div class="relative group inline-block">
                            <x-button type="button" id="download" disabled
                                      class="opacity-50 cursor-not-allowed my-6 bg-orange-600 border border-orange-600 hover:bg-orange-500 hover:border-orange-500 hover:scale-105 transition-transform ease-in-out duration-200">
                                Download Chart
                            </x-button>
                            <span
                                class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                Subscription Required
                            </span>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        @if (session('error'))
            <div class="text-center bg-[#141414]/90 border border-white/20 text-gray-100 space-y-6 p-5 rounded-xl">
                <p class="text-red-600">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        @if (isset($chart))
            <div class="w-3/4 bg-gray-200 border border-white/20 p-6 rounded-xl">
                <h1 class="text-center text-3xl font-bold mb-6 text-black">Progression of {{$plan}}</h1>
                <x-chartjs-component :chart="$chart"/>
            </div>
        @endif

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
                    plan: '{{ $plan }}',
                    id: '{{$id}}'
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
