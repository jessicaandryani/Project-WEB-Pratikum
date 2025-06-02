<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Pastikan Log facade di-import

// Jika Anda berencana mengirim email notifikasi, uncomment baris yang relevan di bawah
// use Illuminate\Support\Facades\Mail;
// use App\Mail\PaymentAwaitingAdminConfirmation; // Anda perlu membuat Mailable ini jika digunakan

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman checkout atau instruksi pembayaran untuk booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function checkout(Booking $booking)
    {
        if (Auth::id() !== $booking->user_id) {
            abort(403, 'ANDA TIDAK DIIZINKAN MELIHAT HALAMAN PEMBAYARAN INI.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->route('bookings.show', $booking->id)->with('info', 'Booking ini tidak lagi memerlukan pembayaran atau sudah diproses.');
        }

        $payment = Payment::where('booking_id', $booking->id)
                            ->where('status', 'pending')
                            ->latest()
                            ->first();

        if (!$payment) {
             if ($booking->status === 'pending') {
                // Mencoba membuat record payment jika tidak ada dan booking masih pending.
                // Ini juga akan mengambil record yang sudah ada jika kriteria cocok.
                $payment = Payment::firstOrCreate(
                    ['booking_id' => $booking->id, 'status' => 'pending'], // Kriteria untuk mencari atau membuat
                    ['amount' => $booking->total_amount] // Nilai untuk diisi jika record baru dibuat
                );
                // Mencatat informasi ke log jika record baru dibuat atau ditemukan.
                Log::info('Payment record processed (created or found) for booking ID: ' . $booking->id . ' with payment ID: ' . $payment->id);
             } else {
                // Jika booking tidak lagi pending dan payment tidak ditemukan, ini kondisi aneh.
                return redirect()->route('bookings.show', $booking->id)->with('error', 'Detail pembayaran tidak ditemukan atau booking tidak lagi dalam status pending.');
             }
        }

        // Pastikan payment berhasil diambil atau dibuat sebelum melanjutkan
        if (!$payment) {
             return redirect()->route('bookings.show', $booking->id)->with('error', 'Gagal memproses atau menemukan detail pembayaran.');
        }

        $booking->load('room.roomType', 'user');

        return view('payments.checkout', compact('booking', 'payment'));
    }

    /**
     * Menangani konfirmasi pembayaran dari sisi pengguna.
     * Pengguna menyatakan bahwa mereka sudah melakukan pembayaran.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment  // Route Model Binding untuk Payment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmUserPayment(Request $request, Payment $payment)
    {
        // Otorisasi: Pastikan user adalah pemilik payment (melalui booking)
        // dan payment yang di-pass memang ada dan terkait dengan booking.
        if (!$payment->booking || Auth::id() !== $payment->booking->user_id) {
            abort(403, 'Anda tidak diizinkan melakukan aksi ini.');
        }

        // Hanya proses jika status payment saat ini adalah 'pending'
        if ($payment->status === 'pending') {
            $payment->status = 'waiting_confirmation'; // Status baru: menunggu konfirmasi admin
            
            // Opsional: Jika Anda mengimplementasikan unggah bukti pembayaran
            // Pastikan form di Blade memiliki enctype="multipart/form-data"
            // if ($request->hasFile('payment_proof') && $request->file('payment_proof')->isValid()) {
            //     // Validasi file tambahan jika perlu (ukuran, tipe)
            //     // $request->validate(['payment_proof' => 'image|mimes:jpeg,png,jpg,gif|max:2048']);
            //
            //     // Simpan file bukti pembayaran
            //     // Pastikan Anda sudah menjalankan `php artisan storage:link`
            //     $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            //
            //     // Simpan path file ke payment_details atau field khusus jika ada
            //     $paymentDetails = (array) $payment->payment_details; // Cast ke array untuk memastikan
            //     $paymentDetails['user_uploaded_proof'] = $path;
            //     $payment->payment_details = $paymentDetails;
            // }
            
            $payment->save();

            // Opsional: Kirim notifikasi email ke admin bahwa ada pembayaran yang perlu diverifikasi
            // $adminEmail = config('mail.admin_address'); // Anda perlu mendefinisikan ini di config atau .env
            // if ($adminEmail) {
            //    Mail::to($adminEmail)->send(new PaymentAwaitingAdminConfirmation($payment)); // Anda perlu membuat Mailable 'PaymentAwaitingAdminConfirmation'
            // }

            return redirect()->route('bookings.show', $payment->booking_id)
                             ->with('success', 'Konfirmasi pembayaran Anda telah diterima. Booking Anda akan segera diproses setelah pembayaran diverifikasi oleh admin.');
        }

        // Jika status bukan 'pending', kembalikan dengan pesan info
        return redirect()->route('bookings.show', $payment->booking_id)
                         ->with('info', 'Status pembayaran ini sudah tidak bisa dikonfirmasi dari sisi Anda atau sudah dalam proses.');
    }
}
