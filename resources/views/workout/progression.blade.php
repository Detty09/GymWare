@extends('layouts.main')

@section('title', "Progression of {$plan}")

@section('content')
    <div class="flex flex-col items-center w-full">

        @if (isset($error))
            <h1 class="text-2xl mt-6">{{$error}}</h1>
        @endif

        @if (isset($chart))
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
@endsection
