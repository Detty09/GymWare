<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'GymWare')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col bg-white">
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<link rel="icon" href="{{ asset('images/dumbbell-svgrepo-com.svg') }}" type="image/png">


<x-navbar></x-navbar>

<main class="flex-1 flex justify-center items-start bg-[#141414]">
    @yield('content')
</main>

<footer class="w-screen flex justify-start mr-6 bg-[#141414]">
    <p class="text-gray-300">&copy; {{ date('Y') }} GymWare</p>
</footer>
</body>
</html>
