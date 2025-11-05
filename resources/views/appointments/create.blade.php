@extends('layouts.app')
@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Book Appointment with {{$coach->user->name}}</h1>
        <form method="POST" action="{{route('appointments.store')}}" class="max-w-md bg-white p-6 rounded-lg shadow-md">
            @csrf
            <input type="hidden" name="coach_id" value="{{$coach->id}}">

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Date:</label>
                <input type="date" name="date" min="{{date('Y-m-d')}}" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block mb-2 font-semibold">Time:</label>
                <select name="time" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select a time</option>
                    @for($hour = 6; $hour <= 21; $hour++)
                        @foreach(['00', '30'] as $minute)
                            @php
                                $time = sprintf('%02d:%s', $hour, $minute);
                            @endphp
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    @endfor
                </select>
                @error('time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold">Duration (minutes):</label>
                <select name="duration" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="60">1 hour</option>
                    <option value="90">1.5 hours</option>
                    <option value="120">2 hours</option>
                </select>
                @error('duration') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Book Appointment</button>
                <a href="{{route('coaches.show', $coach)}}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Cancel</a>
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
