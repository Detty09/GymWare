@extends('layouts.main')

@section('title', 'Our Coaches')

@section('content')
    <div class="container">
        <h1>Our Coaches</h1>

        @if($coaches->isEmpty())
            <p>No coaches available at the moment.</p>
        @else
            <div class="coaches-grid">
                @foreach($coaches as $coach)
                    <div class="coach-card">
                        <h3>{{ $coach->user->name }}</h3>
                        <p>{{ Str::limit($coach->bio ?? 'No bio available', 100) }}</p>
                        <div class="coach-actions">
                            <a href="{{ route('coaches.show', $coach) }}" class="btn btn-primary">View Details</a>
                            <a href="{{ route('appointments.create', $coach) }}" class="btn btn-success">Book Appointment</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
