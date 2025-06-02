<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
        'status',
        'floor',
        'notes'
    ];

    // Relationship: Room belongs to RoomType
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    // Relationship: Room has many Bookings
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Check if room is available for specific dates
    public function isAvailableForDates($checkIn, $checkOut)
    {
        if ($this->status !== 'available') {
            return false;
        }

        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                      ->orWhere(function ($q) use ($checkIn, $checkOut) {
                          $q->where('check_in_date', '<=', $checkIn)
                            ->where('check_out_date', '>=', $checkOut);
                      });
            })->exists();
    }
}
