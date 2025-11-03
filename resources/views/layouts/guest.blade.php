<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'GymWare')</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Optional: Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* Autofill fix */
        input:-webkit-autofill {
            caret-color: white;
            box-shadow: inset 0 0 0 1000px transparent;
            -webkit-text-fill-color: #fff;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

<!-- Optional Logo or Navbar -->
<div class="mb-6">
    <a href="/">
        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
    </a>
</div>

<!-- Main Content -->
<div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    @yield('content')
</div>

<footer class="flex justify-center mr-6">
    <p class="text-gray-300">&copy; {{ date('Y') }} GymWare</p>
</footer>

</body>
</html>
