<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'GymWare')</title>
    <link rel="icon" href="{{ asset('images/dumbbell-svgrepo-com.svg') }}" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
        input:-webkit-autofill {
            caret-color: white;
            box-shadow: inset 0 0 0 1000px transparent;
            -webkit-text-fill-color: #fff;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Optional: Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2 bg-gray-100">

<video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover">
    <source src="{{ asset('videos/login_background.mp4') }}" type="video/mp4">
</video>

<div class="fixed inset-0 bg-black/40"></div>

<!-- Optional Logo or Navbar -->
<div class="relative z-10 mb-6">
    <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </a>
</div>

<!-- Main Content -->
<div class="relative z-10 w-full sm:max-w-md px-6 py-4 bg-[#141414]/90 border border-gray-800 shadow-md overflow-hidden sm:rounded-xl">
    @yield('content')
</div>

<footer class="flex justify-center mr-6">
    <p class="text-gray-300">&copy; {{ date('Y') }} GymWare</p>
</footer>

</body>
</html>
