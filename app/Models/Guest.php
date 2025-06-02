<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'id_number',
        'id_type',
        'birth_date',
        'gender',
        'address'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    // Relationship: Guest belongs to Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Get full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
