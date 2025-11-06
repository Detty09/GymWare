@extends('layouts.main')

@section('title', 'Dash')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12 w-full max-w-2xl">
        <div class="max-w-7xl lg:px-8">
            <div class="bg-white/5 overflow-hidden shadow-sm sm:rounded-lg py-6 px-4 sm:px-12 text-gray-100 border border-white/20">
                <h1 class="text-3xl font-bold mb-6 text-center">
                    Welcome,
                    <span class="text-orange-600">
                        {{ $user->is_coach ? 'Coach ' . $user->name : $user->name }}
                    </span>!
                </h1>

                @if ($user->is_coach && $user->coach)
                    <div class="mt-4 p-4 bg-white/10 border border-white/15 rounded-lg">
                        <h2 class="text-lg font-semibold text-orange-600">Your Bio:</h2>
                        <p class="mt-2 text-gray-100">{{ $user->coach->bio }}</p>
                    </div>
                @endif

                <h2 class="text-xl font-semibold mt-6 border-b border-white/20 py-4">Our Coaches:</h2>

                @if ($coaches->isEmpty())
                    <p class="text-gray-100 italic font-light">No coaches available at the moment.</p>
                @else
                    <ul>
                        @foreach ($coaches as $coach)
                            <li class="border-b py-4 border-white/20">
                                <div class="flex items-center justify-between">
                                    <button
                                        class="coach-btn text-gray-100 hover:underline cursor-pointer hover:text-orange-600"
                                        data-bio="{{ $coach->coach->bio ?? 'This coach has no bio yet.' }}">
                                        Coach {{ $coach->name }}
                                    </button>

                                    <a href="{{ route('appointments.create', $coach->coach) }}"
                                       class="px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-orange-500 hover:scale-105 transition ease-in-out duration-200">
                                        Book Appointment
                                    </a>
                                </div>

                                <p class="coach-bio mt-2 text-white hidden"></p>
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
