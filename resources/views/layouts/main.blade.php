<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'GymWare')</title>
    <link rel="icon" href="{{ asset('images/dumbbell-svgrepo-com.svg') }}" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col bg-black">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<x-navbar></x-navbar>

<main class="flex-1 flex justify-center items-start bg-[#141414]">
    @yield('content')
</main>

<footer class="w-full flex justify-start mr-6 bg-[#141414]">
    <p class="text-gray-300">&copy; {{ date('Y') }} GymWare</p>
</footer>
</body>
</html>
