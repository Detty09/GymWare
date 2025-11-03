@extends('layouts.app')
@section('content')
    <h1>Book Appointment with {{$coach->user->name}}</h1>
    <form method="POST" action="{{route('appointments.store')}}">
        @csrf
        <input type="hidden" name="coach_id" value="{{$coach->id}}">
        <label>Date:</label>
        <input type="date" name="date" min="{{date('Y-m-d')}}" required>
        @error('date') <span class="error">{{ $message }}</span> @enderror

        <label>Time:</label>
        <input type="time" name="time" required>
        @error('time') <span class="error">{{ $message }}</span> @enderror

        <label>Duration (minutes):</label>
        <select name="duration" required>
            <option value="60">1 hour</option>
            <option value="90">1.5hours</option>
            <option value="120">2 hours</option>
        </select>
        @error('duration') <span class="error">{{ $message }}</span> @enderror
        <button type="submit">Book Appointment</button>
        <a href="{{route('coaches.show', $coach)}}" class="btn">Cancel</a>
    </form>
@endsection
