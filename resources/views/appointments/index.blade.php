@extends('layouts.main')
@section('content')
    <div class="py-12 w-screen">
        <div class="max-w-7xl mx-auto sm:px-4 md:px-6 flex justify-center">
            <div class="bg-white/5 max-w-4xl border border-white/20 shadow-sm sm:rounded-xl py-6 px-2 sm:px-4 md:px-10 w-full overflow-hidden">
                <h1 class="text-3xl font-bold mb-6 text-orange-600 text-center sm:text-start">My Appointments</h1>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
                        {{session('success')}}
                    </div>
                @endif

                @if($appointments->isEmpty())
                    <p class="text-gray-600">You have no appointments yet.</p>
                @else
                    <div class="overflow-x-auto rounded-xl border border-white/20 mb-5">
                        <table class="min-w-full divide-y divide-white/20 text-center">
                            <thead class="bg-white/20">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                                    Coach
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                                    Time
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                                    Duration
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-100 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white/10 divide-y divide-white/20">
                            @foreach($appointments as $appointment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-100">{{$appointment->coach->user->name}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">{{$appointment->date->format('M d, Y')}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">{{$appointment->duration}}
                                        min
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{$appointment->status}}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($appointment->status === 'pending')
                                            <form method="POST" action="{{route('appointments.cancel', $appointment)}}" class="delete-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button"
                                                        onclick="openConfirmModal(event)"
                                                        class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-500 hover:scale-105 focus:bg-orange-400 active:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition ease-in-out duration-200">
                                                    Cancel
                                                </button>
                                            </form>

                                            <x-confirm-modal question="Are you sure you want to cancel this appointment?"
                                                             confirm="Yes, cancel"
                                            ></x-confirm-modal>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
