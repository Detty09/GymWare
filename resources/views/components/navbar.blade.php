<div>
    <div class="hidden space-x-4 sm:flex sm:items-center p-2 bg-[#141414] border-b border-gray-700 sm:justify-between">
        @auth
            <div>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-300 hover:text-orange-600 rounded-l transition">Dashboard</a>
                <a href="/exercises" class="px-4 py-2  text-gray-300 hover:text-orange-600 rounded-l transition">Exercises</a>
                <a href="{{ route('profile.edit') }}" class="px-4 py-2  text-gray-300 hover:text-orange-600 rounded-lg transition">Profile</a>
                <a href="/workout-planner" class="px-4 py-2 text-gray-300 hover:text-orange-600 rounded-lg transition">Workout Planner</a>
                <a href="/workout/history" class="px-4 py-2 text-gray-300 hover:text-orange-600 rounded-lg transition">Workout History</a>
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
