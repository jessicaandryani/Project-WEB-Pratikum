<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Data Statistik
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::whereIn('status', ['occupied', 'checked_in'])->count(); // Diperjelas
        
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count(); // Tambahan statistik
        $checkedInBookings = Booking::where('status', 'checked_in')->count(); // Tambahan statistik
        
        $paymentsWaitingConfirmation = Payment::where('status', 'waiting_confirmation')->count();
        $todayRevenue = Payment::whereDate('paid_at', today())->where('status', 'completed')->sum('amount');
        $monthlyRevenue = Payment::whereYear('paid_at', now()->year)
                                ->whereMonth('paid_at', now()->month)
                                ->where('status', 'completed')
                                ->sum('amount');

        // Booking Terbaru & Menunggu Konfirmasi (untuk ditampilkan di dashboard)
        $recentAndPendingPaymentBookings = Booking::with([
            'user:id,name,email', // Hanya pilih kolom yang dibutuhkan dari user
            'room.roomType:id,name', // Hanya pilih kolom yang dibutuhkan dari roomType
            'room:id,room_number,room_type_id', // Hanya pilih kolom yang dibutuhkan dari room
            'payments' => function ($query) {
                $query->latest()->select('id', 'booking_id', 'status', 'amount'); // Hanya kolom yang dibutuhkan dari payment
            }
        ])
        ->where(function ($query) {
            $query->whereHas('payments', function ($subQuery) {
                $subQuery->where('status', 'waiting_confirmation');
            })
            ->orWhereDate('bookings.created_at', '>=', now()->subDays(7)); 
        })
        ->orderBy('created_at', 'desc')
        ->take(10) 
        ->get();

        // Status Kamar (Ringkasan)
        $roomsByStatus = Room::query()
                            ->selectRaw('status, COUNT(*) as count')
                            ->groupBy('status')
                            ->pluck('count', 'status');
        // Definisikan semua kemungkinan status kamar yang ingin Anda tampilkan
        $allRoomStatuses = ['available', 'occupied', 'checked_in', 'maintenance', 'cleaning', 'booked_pending_payment', 'on_hold']; 

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'checkedInBookings',
            'paymentsWaitingConfirmation',
            'todayRevenue',
            'monthlyRevenue',
            'recentAndPendingPaymentBookings',
            'roomsByStatus',
            'allRoomStatuses'
        ));
    }
}