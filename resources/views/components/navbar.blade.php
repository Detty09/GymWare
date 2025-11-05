<div>
    <div class="hidden space-x-4 sm:flex sm:items-center p-2 bg-[#141414] border-b border-white/20 sm:justify-between">
        @auth
            <div>
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
                   {{ request()->is('dashboard') ? 'text-orange-600' : '' }}">
                    Dashboard
                </a>
                <a href="/exercises"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 rounded-l transition font-semibold
                   {{ request()->is('exercises*') ? 'text-orange-600' : '' }}">
                    Exercises
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
                   {{ request()->is('profile*') ? 'text-orange-600' : '' }}">
                    Profile
                </a>
                <a href="/workout-planner"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
                   {{ request()->is('workout-planner*') ? 'text-orange-600' : '' }}">
                    Workout Planner
                </a>
                <a href="/workout/history"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
                   {{ request()->is('workout/history') ? 'text-orange-600' : '' }}">
                    Workout History
                </a>
                <a href="{{ route('appointments.myAppointments') }}"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
                   {{ request()->is('my-appointments*') ? 'text-orange-600' : '' }}">
                    Appointments
                </a>
                <a href="/gymmap"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
                   {{ request()->is('gymmap') ? 'text-orange-600' : '' }}">
                    Nearby Gyms
                </a>
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-1 text-xl text-orange-600 hover:scale-110 hover:text-orange-500 rounded-lg transition ease-in-out duration-100 cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Register</a>
        @endauth
    </div>
</div>
