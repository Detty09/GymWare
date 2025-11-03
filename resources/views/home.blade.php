@extends('layouts.guest')

@section('title', 'Home Page')

@section('content')
    <div class="max-w-2xl w-full bg-transparent rounded-lg p-8 flex flex-col items-center space-y-6">
        <h1 class="text-3xl font-bold text-white">Welcome to GymWare!</h1>
        <p class="text-white text-center">
            You can log in or register to continue.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mt-4 w-full justify-center">
            <a href="{{ route('login') }}"
               class="flex-1 px-6 py-2 bg-orange-600 border-2 border-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 hover:border-orange-500 text-center transition duration-300 ease-in-out">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="flex-1 px-6 py-2 bg-black border-2 border-orange-600 text-white font-semibold rounded-xl hover:bg-orange-500 hover:border-orange-500 text-center transition duration-300 ease-in-out">
                Register
            </a>
        </div>
    </div>
@endsection
