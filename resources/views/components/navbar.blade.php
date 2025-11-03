<div>
    <div class="hidden space-x-4 sm:flex sm:items-center sm:ml-6">
        @auth
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Dashboard</a>
            <a href="/exercises" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Exercises</a>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Profile</a>
            <a href="/workout-planner" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Workout Planner</a>
            <a href="/workout/history" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Workout History</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Log Out
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Login</a>
            <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Register</a>
        @endauth
    </div>
</div>
