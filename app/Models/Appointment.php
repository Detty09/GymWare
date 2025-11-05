<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'coach_id',
        'date',
        'time',
        'duration',
        'status'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(Coach::class);
    }

    /**
     * Check if a time slot is occupied for a specific coach
     */
    public static function isTimeSlotOccupied(int $coachId, string $date, string $time, int $duration): bool
    {
        $requestedStart = \Carbon\Carbon::parse("$date $time");
        $requestedEnd = $requestedStart->copy()->addMinutes($duration);

        $overlapping = self::where('coach_id', $coachId)
            ->where('date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->filter(function ($appointment) use ($requestedStart, $requestedEnd) {
                //Format the date from Carbon instance
                $dateStr = $appointment->date->format('Y-m-d');
                $existingStart = \Carbon\Carbon::parse("$dateStr {$appointment->time}");
                $existingEnd = $existingStart->copy()->addMinutes($appointment->duration);
                return $requestedStart->lt($existingEnd) && $requestedEnd->gt($existingStart);
            });

        return $overlapping->isNotEmpty();
    }
}
