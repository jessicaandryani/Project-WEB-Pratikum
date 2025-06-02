<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room; // Mungkin diperlukan jika status kamar juga diupdate
use Illuminate\Http\Request;
use Carbon\Carbon; // Untuk manipulasi tanggal

class AdminBookingController extends Controller
{
    /**
     * Menampilkan daftar semua booking untuk admin.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user:id,name,email', 'room.roomType:id,name', 'room:id,room_number,room_type_id', 'payments' => function($q){
            $q->latest()->select('id', 'booking_id', 'status');
        }])->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan pencarian kode booking atau nama tamu
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('booking_code', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }


        $bookings = $query->paginate(15)->withQueryString(); // withQueryString() untuk menjaga parameter filter di paginasi

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Menampilkan detail spesifik booking untuk admin.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'room.roomType', 'payments' => function($q){
            $q->orderBy('created_at', 'desc');
        }]);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Menangani aksi check-in untuk booking.
     */
    public function checkIn(Request $request, Booking $booking)
    {
        // Validasi: Hanya booking yang 'confirmed' yang bisa di check-in
        if ($booking->status !== 'confirmed') {
            return redirect()->route('admin.bookings.show', $booking->id)
                             ->with('error', 'Hanya booking yang sudah dikonfirmasi yang bisa di check-in.');
        }

        // Validasi: Tanggal check-in tidak boleh di masa depan (opsional, tergantung kebijakan)
        // if (Carbon::parse($booking->check_in_date)->isFuture()) {
        //     return redirect()->route('admin.bookings.show', $booking->id)
        //                      ->with('error', 'Belum waktunya untuk check-in.');
        // }

        $booking->status = 'checked_in';
        // Anda bisa menambahkan field aktual check-in time jika perlu
        // $booking->actual_check_in_time = now();
        $booking->save();

        // Opsional: Update status kamar menjadi 'occupied'
        if ($booking->room) {
            $booking->room->status = 'occupied'; // atau 'checked_in' jika Anda punya status itu untuk room
            $booking->room->save();
        }

        return redirect()->route('admin.bookings.show', $booking->id)
                         ->with('success', 'Tamu untuk booking ' . $booking->booking_code . ' berhasil di check-in.');
    }

    /**
     * Menangani aksi check-out untuk booking.
     */
    public function checkOut(Request $request, Booking $booking)
    {
        if ($booking->status !== 'checked_in') {
            return redirect()->route('admin.bookings.show', $booking->id)
                             ->with('error', 'Hanya tamu yang sudah check-in yang bisa di check-out.');
        }

        $booking->status = 'completed'; // Atau 'checked_out'
        // $booking->actual_check_out_time = now();
        $booking->save();

        // Opsional: Update status kamar (misal: 'cleaning' atau 'available' jika langsung)
        if ($booking->room) {
            $booking->room->status = 'cleaning'; // Atau 'available'
            $booking->room->save();
        }
        
        return redirect()->route('admin.bookings.show', $booking->id)
                         ->with('success', 'Tamu untuk booking ' . $booking->booking_code . ' berhasil di check-out. Booking selesai.');
    }

    /**
     * Membatalkan booking dari sisi admin.
     */
    public function cancelBooking(Request $request, Booking $booking)
    {
        // Tambahkan validasi status jika diperlukan, misalnya hanya booking tertentu yang bisa dibatalkan
        if (in_array($booking->status, ['completed', 'checked_out', 'cancelled'])) {
             return redirect()->route('admin.bookings.show', $booking->id)
                             ->with('error', 'Booking dengan status ini tidak dapat dibatalkan lagi.');
        }

        $booking->status = 'cancelled';
        // Tambahkan detail pembatalan jika perlu
        // $booking->cancellation_reason = $request->input('reason', 'Dibatalkan oleh Admin');
        // $booking->cancelled_by_type = 'admin';
        // $booking->cancelled_by_id = Auth::id();
        $booking->save();

        // Opsional: Update status kamar jika sebelumnya kamar di-hold
        if ($booking->room && $booking->room->status !== 'available') { // Cek jika bukan sudah available
            // Jika booking 'confirmed' atau 'pending', kamar mungkin 'booked_pending_payment' atau 'on_hold'
            // Kembalikan menjadi 'available'
            $booking->room->status = 'available';
            $booking->room->save();
        }

        // Pertimbangkan logika refund jika pembayaran sudah 'completed'

        return redirect()->route('admin.bookings.show', $booking->id)
                         ->with('success', 'Booking ' . $booking->booking_code . ' berhasil dibatalkan oleh Admin.');
    }


    /**
     * Menampilkan form untuk mengedit booking dari sisi admin.
     * (Anda perlu membuat view admin.bookings.edit_admin)
     */
    public function editAdmin(Booking $booking)
    {
        $booking->load('user', 'room.roomType');
        // Ambil daftar kamar yang available jika admin bisa mengubah kamar
        // $availableRooms = Room::where('status', 'available')->orWhere('id', $booking->room_id)->get();
        // return view('admin.bookings.edit_admin', compact('booking', 'availableRooms'));
        return view('admin.bookings.edit_admin', compact('booking')); // Contoh sederhana
    }

    /**
     * Mengupdate booking dari sisi admin.
     */
    public function updateAdmin(Request $request, Booking $booking)
    {
        // Validasi data dari admin (mungkin lebih fleksibel daripada user)
        $validatedData = $request->validate([
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|string|in:pending,confirmed,checked_in,completed,cancelled', // Validasi status
            'total_amount' => 'required|numeric|min:0', // Admin mungkin bisa override harga
            'special_requests' => 'nullable|string|max:1000',
            // 'room_id' => 'required|exists:rooms,id', // Jika admin bisa ganti kamar
        ]);

        $checkIn = Carbon::parse($validatedData['check_in_date']);
        $checkOut = Carbon::parse($validatedData['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);

        if ($nights < 0) { // Bisa 0 malam jika kebijakan mengizinkan (misal, check-in & out di hari yg sama tanpa menginap)
            return redirect()->back()->withErrors(['check_out_date' => 'Tanggal check-out harus setelah atau sama dengan tanggal check-in.'])->withInput();
        }
        
        // Jika admin mengubah kamar, perlu logika tambahan untuk cek ketersediaan kamar baru
        // dan mungkin mengembalikan status kamar lama.

        $booking->fill($validatedData); // Mengisi field yang ada di $fillable Booking model
        $booking->nights = $nights; // Hitung ulang nights
        // Pastikan semua field yang relevan di-update
        // $booking->room_id = $validatedData['room_id'];
        // $booking->total_amount = $validatedData['total_amount'];
        
        $booking->save();

        return redirect()->route('admin.bookings.show', $booking->id)
                         ->with('success', 'Detail booking berhasil diperbarui oleh Admin.');
    }
}
