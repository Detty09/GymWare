@extends('layouts.guest')

@section('title', 'Home Page')

@section('content')
    <div class="max-w-2xl w-full bg-white shadow-md rounded-lg p-8 flex flex-col items-center space-y-6 mt-12">
        <h1 class="text-3xl font-bold text-gray-800">Welcome to GymWare!</h1>
        <p class="text-gray-600 text-center">
            This is the home page. You can log in or register to continue.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mt-4 w-full justify-center">
            <a href="{{ route('login') }}"
               class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 text-center transition">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="flex-1 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 text-center transition">
                Register
            </a>
        </div>
    </div>
@endsection
