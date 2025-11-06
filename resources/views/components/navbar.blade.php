<div x-data="{ open: false }">
    <!-- Desktop Navbar -->
    <div class="hidden lg:flex lg:items-center p-2 bg-[#141414] border-b border-white/20 lg:justify-between">
        @auth
            <div>
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
                   {{ request()->is('dashboard') ? 'text-orange-600' : '' }}">
                    Dashboard
                </a>
                <a href="/exercises"
                   class="px-4 py-2 text-gray-300 hover:text-orange-600 transition font-semibold
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
        @endauth
    </div>

    <!-- Mobile Navbar -->
    <div class="lg:hidden bg-[#141414] border-b border-white/20 py-2 px-4">
        @auth
            <div class="flex items-center justify-between">
                <button @click="open = !open" class="text-2xl text-orange-600 hover:text-orange-500 transition">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xl text-orange-600 hover:scale-110 hover:text-orange-500 transition ease-in-out duration-100 cursor-pointer">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
            </div>

            <!-- Mobile Dropdown Menu -->
            <div x-show="open" @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="mt-2 bg-[#1a1a1a] border border-white/20 rounded-lg overflow-hidden">
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-3 text-gray-300 hover:text-orange-600 hover:bg-white/5 transition font-semibold
                   {{ request()->is('dashboard') ? 'text-orange-600 bg-white/5' : '' }}"
                   @click="open = false">
                    Dashboard
                </a>
                <a href="/exercises"
                   class="block px-4 py-3 text-gray-300 hover:text-orange-600 hover:bg-white/5 transition font-semibold
                   {{ request()->is('exercises*') ? 'text-orange-600 bg-white/5' : '' }}"
                   @click="open = false">
                    Exercises
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-3 text-gray-300 hover:text-orange-600 hover:bg-white/5 transition font-semibold
                   {{ request()->is('profile*') ? 'text-orange-600 bg-white/5' : '' }}"
                   @click="open = false">
                    Profile
                </a>
                <a href="/workout-planner"
                   class="block px-4 py-3 text-gray-300 hover:text-orange-600 hover:bg-white/5 transition font-semibold
                   {{ request()->is('workout-planner*') ? 'text-orange-600 bg-white/5' : '' }}"
                   @click="open = false">
                    Workout Planner
                </a>
                <a href="/workout/history"
                   class="block px-4 py-3 text-gray-300 hover:text-orange-600 hover:bg-white/5 transition font-semibold
                   {{ request()->is('workout/history') ? 'text-orange-600 bg-white/5' : '' }}"
                   @click="open = false">
                    Workout History
                </a>
                <a href="{{ route('appointments.myAppointments') }}"
                   class="block px-4 py-3 text-gray-300 hover:text-orange-600 hover:bg-white/5 transition font-semibold
                   {{ request()->is('my-appointments*') ? 'text-orange-600 bg-white/5' : '' }}"
                   @click="open = false">
                    Appointments
                </a>
                <a href="/gymmap"
                   class="block px-4 py-3 text-gray-300 hover:text-orange-600 hover:bg-white/5 transition font-semibold
                   {{ request()->is('gymmap') ? 'text-orange-600 bg-white/5' : '' }}"
                   @click="open = false">
                    Nearby Gyms
                </a>
            </div>
        @endauth
    </div>
</div>
