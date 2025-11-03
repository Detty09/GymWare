@extends('layouts.main')

@section('title', 'Dash')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-6">
                    Welcome,
                    <span class="text-indigo-600">
                    {{ $user->is_coach ? 'Coach ' . $user->name : $user->name }}
                </span>!
                </h1>

                @if ($user->is_coach && $user->coach)
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h2 class="text-lg font-semibold text-blue-700">Coach Bio</h2>
                        <p class="mt-2 text-gray-700">{{ $user->coach->bio }}</p>
                    </div>
                @endif

                <h2 class="text-2xl font-semibold mb-4">Our Coaches:</h2>

                @if ($coaches->isEmpty())
                    <p class="text-gray-600">No coaches available at the moment.</p>
                @else
                    <ul class="space-y-2 list-disc list-inside">
                        @foreach ($coaches as $coach)
                            <li>
                                <button class="coach-btn" data-bio="{{ $coach->coach->bio ?? 'This coach has no bio yet.' }}">
                                    <span class="text-blue-600 font-semibold">Coach</span>
                                    <span class="text-gray-900 font-medium">{{ $coach->name }}</span>
                                </button>
                                <a href="{{ route('appointments.create', $coach->coach) }}"
                                   class="ml-4 px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 transition inline-block">
                                    Book Appointment
                                </a>
                                <p class="coach-bio mt-1 text-gray-700 hidden"></p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = document.querySelectorAll('.coach-btn');

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const bioPara = btn.nextElementSibling;
                    bioPara.textContent = btn.dataset.bio;
                    bioPara.classList.toggle('hidden');
                });
            });
        });
    </script>
@endsection
