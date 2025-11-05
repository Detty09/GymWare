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

                <h2 class="text-2xl font-semibold mb-4 mt-6">Our Coaches:</h2>

                @if ($coaches->isEmpty())
                    <p class="text-gray-600">No coaches available at the moment.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($coaches as $coach)
                            <li class="border-b pb-3">
                                <div class="flex items-center gap-4">
                                    <button
                                        class="coach-btn text-blue-600 font-semibold hover:underline"
                                        data-bio="{{ $coach->coach->bio ?? 'This coach has no bio yet.' }}">
                                        Coach {{ $coach->name }}
                                    </button>

                                    <a href="{{ route('appointments.create', $coach->coach) }}"
                                       class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-green-700 transition">
                                        Book Appointment
                                    </a>
                                </div>

                                <p class="coach-bio mt-2 text-gray-700 hidden"></p>
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

            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const bio = button.closest('li').querySelector('.coach-bio');
                    bio.textContent = button.dataset.bio;
                    bio.classList.toggle('hidden');
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async (pos) => {
                    const { latitude, longitude } = pos.coords;
                    localStorage.setItem('user_lat', latitude);
                    localStorage.setItem('user_lng', longitude);

                    try {
                        const radius = 1000;
                        const res = await fetch(`/gymsdata?lat=${latitude}&lng=${longitude}&radius=${radius}`);
                        const data = await res.json();
                        if (data.elements) {
                            localStorage.setItem('cached_gyms', JSON.stringify(data.elements));
                        }
                    } catch (err) {
                        console.error('❌ Failed to preload gyms:', err);
                    }
                });
            } else {
                console.warn("Geolocation not supported in this browser.");
            }
        });
    </script>
@endsection
