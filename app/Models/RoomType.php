<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'base_price',
        'max_occupancy',
        'amenities',
        'image'
    ];

    protected $casts = [
        'amenities' => 'array',
        'base_price' => 'decimal:2'
    ];

    // Relationship: RoomType has many Rooms
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Get available rooms for this type
    public function availableRooms()
    {
        return $this->rooms()->where('status', 'available');
    }
}
