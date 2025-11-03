@extends('layouts.app')

@section('content')
    <h1>{{$coach->user->name}}</h1>
    <p><strong>Bio:</strong>{{$coach->bio ?? 'No bio available'}}</p>

    <a href="{{route('appointments.create', $coach)}}" class="btn">
        Book Appointment with {{$coach->user->name}}
    </a>
@endsection
