<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{'GymWare'}}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite (Tailwind + JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen flex flex-col">

<!-- Navigation -->
<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                </a>
            </div>

            <!-- Desktop Links -->
            <div class="hidden space-x-4 sm:flex sm:items-center sm:ml-6">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Profile</a>
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

            <!-- Hamburger Menu -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Log Out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Login</a>
                <a href="{{ route('register') }}" class="block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Register</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Page Content -->
<main class="flex-1">
    {{ $slot ?? '' }}
    @yield('content')
</main>

<!-- Footer -->
<footer class="flex justify-center items-center p-4 bg-gray-800 text-white mt-auto">
    &copy; {{ date('Y') }} GymWare
</footer>

<!-- Alpine.js for mobile toggle -->
<script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>
