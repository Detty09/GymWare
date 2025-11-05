<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Coach;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(){
        $coaches = Coach::with('user')->get();
        return view('coaches.index', compact('coaches'));
    }

    public function show(Coach $coach){
        $coach->load('user');
        return view('coaches.show', compact('coach'));
    }

    public function create(Coach $coach){
        $coach->load('user');

        //Occupied time - this coach
        $occupiedSlots = Appointment::where('coach_id', $coach->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('date', '>=', now()->toDateString())
            ->get(['date', 'time', 'duration'])
            ->map(function($appointment) {
                return [
                    'date' => $appointment->date->format('Y-m-d'),
                    'time' => $appointment->time,
                    'duration' => $appointment->duration
                ];
            });

        return view('appointments.create', compact('coach', 'occupiedSlots'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'coach_id' => 'required|exists:coaches,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'duration' => 'required|integer|min:60',
        ]);

        //Check if the appointment time is in the past
        $appointmentDateTime = \Carbon\Carbon::parse("{$validated['date']} {$validated['time']}");
        if ($appointmentDateTime->isPast()) {
            return back()->withErrors([
                'time' => 'Cannot book an appointment in the past. Please choose a future date and time.'
            ])->withInput();
        }

        //Check if the time slot is already occupied (already denied by frontend, but checking to make it sure)
        if (Appointment::isTimeSlotOccupied(
            $validated['coach_id'],
            $validated['date'],
            $validated['time'],
            $validated['duration']
        )) {
            return back()->withErrors([
                'time' => 'This time slot is already occupied. Please choose a different time.'
            ])->withInput();
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        Appointment::create($validated);

        return redirect()->route('appointments.myAppointments')->with('success', 'Appointment booked successfully!');
    }

    public function myAppointments(){
        $appointments = Appointment::where('user_id', auth()->id())
            ->with('coach.user')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();
        return view('appointments.index', compact('appointments'));
    }

    public function cancel(Appointment $appointment){
        if ($appointment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('appointments.myAppointments')->with('success', 'Appointment cancelled successfully!');
    }
}

