@extends('layouts.main')

@section('title', 'Exercise Planner')

@section('content')
    <div class="relative min-h-screen w-full text-gray-100">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('/images/planner-bg.jpg')">
        </div>

        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative flex justify-center p-10">
            <div class="flex flex-col gap-10 max-w-1/3 min-w-[400px]">
                <div class="flex flex-col items-center min-w-[400px] px-5 mt-6 space-y-6 text-gray-100 bg-[#141414]/90 border border-white/20 py-5 rounded-xl">
                    <h1 class="font-semibold text-xl">My Templates</h1>

                    <div class="flex flex-col items-start gap-5">
                        @if(empty($plans))
                            <div>
                                <h1 class="italic text-sm font-light">You have no templates yet!</h1>
                            </div>
                        @else
                            @foreach($plans as $plan)
                                @include('components.template-card', ['plan' => $plan])
                            @endforeach
                        @endif
                    </div>
                </div>

                @if (session('error'))
                    <div class="text-center bg-[#141414]/90 border border-white/20 text-gray-100 space-y-6 p-5 rounded-xl">
                        <p class="text-red-600">
                            {{ session('error') }}
                        </p>
                    </div>
                @endif

                <div class="flex flex-col items-center bg-[#141414]/90 border border-white/20 text-gray-100 space-y-6 p-5 rounded-xl">
                    <h1 class="font-semibold text-xl">Create new workout plan</h1>

                    <form action="/workout-planner" method="POST" class="flex flex-col space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="text-sm mr-2">
                                Workout name:
                            </label>
                            <input placeholder="Leg day..."
                                   id="name"
                                   name="name"
                                   required
                                   class="text-sm border border-white/20 p-1 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-600"
                            />

                            <x-form.error name="name"/>

                        </div>

                        <x-button type="submit"
                                  class="mt-1 justify-center bg-orange-600  hover:bg-orange-500 hover:scale-102 transition-transform ease-in-out duration-200 focus:outline-none focus:ring focus:ring-orange-600 focus:ring-offset">
                            Create new Plan
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
