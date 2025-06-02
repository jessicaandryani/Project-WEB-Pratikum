<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Pastikan Carbon di-import jika belum

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'nights', // nights sekarang akan diisi oleh Controller
        'adults',
        'children',
        'total_amount',
        'status', // Default status bisa diatur di migrasi DB atau di sini jika perlu
        'special_requests',
        'confirmed_at'
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_amount' => 'decimal:2',
        'confirmed_at' => 'datetime'
    ];

    // Auto generate booking code
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            // Hanya generate booking_code di sini
            // Perhitungan 'nights' dan 'total_amount' akan dilakukan di Controller
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'HDL-' . strtoupper(uniqid());
            }

            // Set default status jika belum di-set
            if (empty($booking->status)) {
                $booking->status = 'pending'; // Atau status default lainnya
            }
        });
    }

    // Relationship: Booking belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Booking belongs to Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // Relationship: Booking has many Guests (Jika Anda memiliki model Guest)
    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    // Relationship: Booking has many Payments (Jika Anda memiliki model Payment)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relationship: Booking belongs to many Services (Jika Anda memiliki tabel pivot booking_service)
    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_service')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    // Accessor untuk menghitung total yang sudah dibayar (jika ada tabel payments)
    public function getTotalPaidAttribute()
    {
        // Pastikan ada relasi 'payments' dan model Payment dengan kolom 'amount' dan 'status'
        if (method_exists($this, 'payments')) {
            return $this->payments()->where('status', 'completed')->sum('amount');
        }
        return 0;
    }

    // Method untuk mengecek apakah booking sudah lunas
    public function isFullyPaid()
    {
        if ($this->total_amount > 0) { // Hindari pembagian dengan nol jika total_amount adalah 0
            return $this->getTotalPaidAttribute() >= $this->total_amount;
        }
        return true; // Anggap lunas jika totalnya 0 (atau sesuaikan logika bisnis)
    }
}
