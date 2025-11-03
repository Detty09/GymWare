@extends('layouts.app')
@section('content')
    <h1>My Appointments</h1>
    @if(session('success'))
        <div class="alert success">{{session('success')}}</div>
    @endif

    @if($appointments->isEmpty())
        <p>You have no appointments yet.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Coach</th>
                <th>Date</th>
                <th>Time</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{$appointment->coach->user->name}}</td>
                        <td>{{$appointment->date->format('M d, Y')}}</td>
                        <td>{{$appointment->time->format('H:i') }}</td>
                        <td>{{$appointment->duration}} min</td>
                        <td>{{$appointment->status}}</td>
                        <td>
                            @if($appointment->status === 'pending')
                                <form method="POST" action="{{route('appointments.cancel', $appointment)}}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Cancel?')">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
