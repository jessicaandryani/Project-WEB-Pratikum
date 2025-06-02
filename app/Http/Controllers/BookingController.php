<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Payment;
// use Illuminate\Validation\Rule; // Uncomment jika Anda memerlukan Rule untuk validasi yang lebih kompleks

class BookingController extends Controller
{
    /**
     * Menampilkan form untuk membuat booking baru.
     */
    public function create()
    {
        $rooms = Room::with('roomType')->where('status', 'available')->get();
        return view('bookings.create', compact('rooms'));
    }

    /**
     * Menyimpan booking baru ke database.
     */
    public function store(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'check_in_date' => 'required|date|after_or_equal:today',
        'check_out_date' => 'required|date|after:check_in_date',
        'adults' => 'required|integer|min:1',
        'children' => 'nullable|integer|min:0',
        'special_requests' => 'nullable|string|max:1000',
    ]);

    /** @var \App\Models\Room $room */
    $room = Room::with('roomType')->findOrFail($request->room_id);

    if ($room->status !== 'available') {
        return redirect()->back()
                         ->withErrors(['room_id' => 'Kamar yang dipilih sudah tidak tersedia. Silakan pilih kamar lain.'])
                         ->withInput();
    }

    $checkIn = Carbon::parse($request->check_in_date);
    $checkOut = Carbon::parse($request->check_out_date);
    $nights = $checkIn->diffInDays($checkOut);

    if ($nights <= 0) {
         return redirect()->back()
                         ->withErrors(['check_out_date' => 'Durasi menginap minimal 1 malam. Pastikan tanggal check-out setelah tanggal check-in.'])
                         ->withInput();
    }

    if (!$room->roomType) {
        return redirect()->back()
                         ->withErrors(['room_id' => 'Tipe kamar tidak ditemukan untuk kamar yang dipilih.'])
                         ->withInput();
    }
    
    $basePrice = $room->roomType->base_price;
    $totalAmount = $basePrice * $nights;

    $booking = Booking::create([
        'user_id' => Auth::id(),
        'room_id' => $room->id,
        'check_in_date' => $checkIn,
        'check_out_date' => $checkOut,
        'nights' => $nights,
        'adults' => $request->adults,
        'children' => $request->children ?? 0,
        'total_amount' => $totalAmount,
        'status' => 'pending', // Status booking awal
        'special_requests' => $request->special_requests,
    ]);

    // --- PENAMBAHAN LOGIKA PEMBAYARAN DIMULAI DI SINI ---
    if ($booking) {
        // Buat record payment awal
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_amount,
            'status' => 'pending', // Status payment awal
            // 'payment_method' bisa diisi nanti jika ada pilihan metode
        ]);

        // Opsional: Ubah status kamar menjadi 'booked' atau 'on_hold'
        // $room->status = 'on_hold'; // atau 'booked_pending_payment'
        // $room->save();

        // Arahkan ke halaman checkout/pembayaran
        return redirect()->route('payments.checkout', ['booking' => $booking->id])
                         ->with('success', 'Booking berhasil dibuat! Silakan lanjutkan ke pembayaran.');
    }
    // --- AKHIR PENAMBAHAN LOGIKA PEMBAYARAN ---

    // Fallback jika booking gagal dibuat (seharusnya jarang terjadi jika validasi lolos)
    return redirect()->route('bookings.create')->with('error', 'Gagal membuat booking, silakan coba lagi.');
}

    /**
     * Menampilkan detail booking.
     */
    public function show(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id /* && !Auth::user()->isAdmin() */) { // Sesuaikan jika ada role admin
            abort(403, 'Anda tidak memiliki akses untuk melihat booking ini.');
        }

        $booking->load(['user', 'room.roomType']);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Menampilkan daftar riwayat booking milik user.
     */
    public function history()
    {
        $userBookings = Booking::where('user_id', Auth::id())
                            ->with(['room.roomType'])
                            ->orderBy('check_in_date', 'desc')
                            ->paginate(10); // Jumlah item per halaman

        return view('bookings.history', compact('userBookings'));
    }

    /**
     * Menampilkan form untuk mengedit booking yang ada.
     */
    public function edit(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'ANDA TIDAK DIIZINKAN MENGEDIT BOOKING INI.');
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            // Menggunakan 'bookings.show' sesuai dengan nama route Anda
            return redirect()->route('bookings.show', $booking->id) 
                             ->with('error', 'Booking dengan status "' . ucfirst($booking->status) . '" tidak dapat diedit lagi.');
        }

        $booking->load('room.roomType');
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Mengupdate booking yang ada di database.
     */
    public function update(Request $request, Booking $booking)
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'ANDA TIDAK DIIZINKAN MENGUPDATE BOOKING INI.');
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            // Menggunakan 'bookings.show' sesuai dengan nama route Anda
            return redirect()->route('bookings.show', $booking->id)
                             ->with('error', 'Booking dengan status "' . ucfirst($booking->status) . '" tidak dapat diupdate lagi.');
        }

        $validatedData = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $checkIn = Carbon::parse($validatedData['check_in_date']);
        $checkOut = Carbon::parse($validatedData['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);

        if ($nights <= 0) {
            return redirect()->back()
                            ->withErrors(['check_out_date' => 'Durasi menginap minimal 1 malam.'])
                            ->withInput();
        }

        $room = $booking->room()->with('roomType')->first();
        if (!$room || !$room->roomType) {
            return redirect()->back()->with('error', 'Data kamar tidak ditemukan. Tidak dapat menghitung ulang harga.');
        }

        $totalAmount = $room->roomType->base_price * $nights;

        $booking->check_in_date = $checkIn;
        $booking->check_out_date = $checkOut;
        $booking->nights = $nights;
        $booking->adults = $validatedData['adults'];
        $booking->children = $validatedData['children'] ?? 0;
        $booking->special_requests = $validatedData['special_requests'];
        $booking->total_amount = $totalAmount;
        // Pertimbangkan logika untuk status jika diperlukan (misal: kembali ke pending jika ada perubahan besar)
        $booking->save();

        // Menggunakan 'bookings.show' sesuai dengan nama route Anda
        return redirect()->route('bookings.show', $booking->id)
                         ->with('success', 'Booking berhasil diperbarui.');
    }

    /**
     * Menghapus (membatalkan) booking.
     * Sebaiknya ganti status menjadi 'cancelled' daripada menghapus record.
     */
    public function destroy(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'ANDA TIDAK DIIZINKAN MEMBATALKAN BOOKING INI.');
        }

        // Kebijakan pembatalan: misalnya, hanya bisa dibatalkan jika status 'pending' atau 'confirmed'
        // dan mungkin ada batasan waktu sebelum check-in.
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->route('bookings.show', $booking->id) // Menggunakan 'bookings.show'
                             ->with('error', 'Booking dengan status "' . ucfirst($booking->status) . '" tidak dapat dibatalkan lagi.');
        }

        // Contoh: Ubah status menjadi 'cancelled'
        $booking->status = 'cancelled';
        // Anda mungkin ingin menyimpan siapa yang membatalkan dan kapan
        // $booking->cancelled_by = Auth::id();
        // $booking->cancelled_at = now();
        $booking->save();
        
        // Opsional: Jika kamar di-mark sebagai 'booked', kembalikan statusnya menjadi 'available'
        // if ($booking->room) {
        //     $booking->room->status = 'available';
        //     $booking->room->save();
        // }

        return redirect()->route('bookings.history') // Mengarah ke riwayat booking setelah pembatalan
                         ->with('success', 'Booking berhasil dibatalkan.');
    }
}
