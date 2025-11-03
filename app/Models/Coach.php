<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{use HasFactory;

    protected $fillable = [
    'user_id',
    'bio',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
    return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}
