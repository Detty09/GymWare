@extends('layouts.main')
@section('content')
    <div class="flex flex-col justify-center items-center px-4 py-8 text-gray-100">
        <h1 class="text-3xl font-bold mb-6 text-orange-600">Book Appointment with {{$coach->user->name}}</h1>
        <form method="POST" action="{{route('appointments.store')}}" class="w-full bg-white/5 p-6 rounded-lg shadow-md border border-white/20">
            @csrf
            <input type="hidden" name="coach_id" value="{{$coach->id}}">

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Date:</label>
                <input type="date" name="date" min="{{date('Y-m-d')}}" required class="w-full px-4 py-2 border border-white/20 rounded-lg focus:outline-none focus:ring focus:ring-orange-600">
                @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Time:</label>
                <select name="time" required class="w-full px-4 py-2 border border-white/20 rounded-lg focus:outline-none focus:ring-1 focus:ring-orange-600">
                    <option class="text-black" value="">Select a time</option>
                    @for($hour = 6; $hour <= 21; $hour++)
                        @foreach(['00', '30'] as $minute)
                            @php
                                $time = sprintf('%02d:%s', $hour, $minute);
                            @endphp
                            <option class="text-black" value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    @endfor
                </select>
                @error('time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Duration (minutes):</label>
                <select name="duration" required class="w-full px-4 py-2 border border-white/20 rounded-lg focus:outline-none focus:ring focus:ring-orange-600">
                    <option class="text-black" value="60">1 hour</option>
                    <option class="text-black" value="90">1.5 hours</option>
                    <option class="text-black" value="120">2 hours</option>
                </select>
                @error('duration') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-500 hover:scale-105 focus:bg-orange-400 active:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition ease-in-out duration-200">Book Appointment</button>
                <a href="{{route('dashboard')}}" class="inline-flex items-center px-4 py-2 border border-orange-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-500 hover:border-orange-500 hover:scale-105 focus:bg-orange-400 active:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-600 focus:ring-offset-2 transition ease-in-out duration-200">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        //Store occupied slots
        const occupiedSlots = @json($occupiedSlots);
        console.log('Occupied slots:', occupiedSlots); // Debug

        const dateInput = document.querySelector('input[name="date"]');
        const timeSelect = document.querySelector('select[name="time"]');
        const durationSelect = document.querySelector('select[name="duration"]');

        function updateTimeSlots() {
            const selectedDate = dateInput.value;
            const selectedDuration = parseInt(durationSelect.value);

            if (!selectedDate || !selectedDuration) {
                return;
            }

            console.log('Updating slots for date:', selectedDate, 'duration:', selectedDuration); // Debug

            //Reset all options
            Array.from(timeSelect.options).forEach(option => {
                if (option.value === '') return; //Skip the placeholder

                const time = option.value;
                const isOccupied = checkIfOccupied(selectedDate, time, selectedDuration);

                if (isOccupied) {
                    option.disabled = true;
                    option.textContent = time + ' (Occupied)';
                    option.style.color = '#999';
                } else {
                    option.disabled = false;
                    option.textContent = time;
                    option.style.color = '';
                }
            });
        }

        function checkIfOccupied(date, time, duration) {
            //Parse requested time slot
            const [hours, minutes] = time.split(':').map(Number);
            const requestedStart = new Date(date);
            requestedStart.setHours(hours, minutes, 0, 0);
            const requestedEnd = new Date(requestedStart.getTime() + duration * 60000);

            for (let appointment of occupiedSlots) {
                if (appointment.date !== date) continue;

                //Parse existing appointment time
                const [existingHours, existingMinutes] = appointment.time.split(':').map(Number);
                const existingStart = new Date(appointment.date);
                existingStart.setHours(existingHours, existingMinutes, 0, 0);
                const existingEnd = new Date(existingStart.getTime() + appointment.duration * 60000);

                //Check for overlap
                if (requestedStart < existingEnd && requestedEnd > existingStart) {
                    console.log('Conflict found:', time, 'conflicts with', appointment.time); // Debug
                    return true;
                }
            }

            return false;
        }

        //Update time slots when date or duration changes
        dateInput.addEventListener('change', updateTimeSlots);
        durationSelect.addEventListener('change', updateTimeSlots);
    </script>
@endsection
