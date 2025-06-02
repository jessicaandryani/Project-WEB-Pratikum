<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Jika Anda akan mengirim email
// use App\Mail\BookingConfirmedByAdmin; // Buat Mailable ini jika perlu
// use App\Mail\PaymentRejectedToUser; // Buat Mailable ini jika perlu

class AdminPaymentController extends Controller
{
    /**
     * Menampilkan daftar pembayaran yang menunggu konfirmasi/verifikasi admin.
     */
    public function listPendingConfirmations()
    {
        $paymentsToVerify = Payment::where('status', 'waiting_confirmation')
                                    ->with(['booking.user:id,name', 'booking.room.roomType:id,name', 'booking.room:id,room_number,room_type_id'])
                                    ->orderBy('updated_at', 'asc') // Tampilkan yang paling lama menunggu dulu
                                    ->paginate(15);

        return view('admin.payments.pending_verification', compact('paymentsToVerify'));
    }

    /**
     * Menampilkan form/detail untuk verifikasi satu pembayaran.
     */
    public function showVerificationForm(Payment $payment)
    {
         $payment->load(['booking.user', 'booking.room.roomType', 'booking.payments' => function($q){
            $q->orderBy('created_at', 'desc');
         }]);
         // Pastikan booking memiliki data yang diperlukan juga
         if ($payment->booking) {
            $payment->booking->load('user', 'room.roomType');
         }
         return view('admin.payments.verify_payment_detail', compact('payment'));
         // Nama view saya ubah sedikit untuk lebih deskriptif
    }

    /**
     * Aksi untuk mengonfirmasi pembayaran.
     */
    public function confirmPaymentAction(Request $request, Payment $payment)
    {
        if ($payment->status !== 'waiting_confirmation') {
            return redirect()->route('admin.payments.pending')->with('error', 'Pembayaran ini tidak lagi menunggu verifikasi atau sudah diproses.');
        }

        // Ubah status payment
        $payment->status = 'completed';
        $payment->paid_at = now();
        $payment->payment_details = array_merge((array)$payment->payment_details, ['verified_by_admin_id' => Auth::id(), 'verified_at' => now()->toDateTimeString()]);
        $payment->save();

        // Ubah status booking terkait
        if ($payment->booking) {
            $booking = $payment->booking;
            $booking->status = 'confirmed';
            $booking->confirmed_at = now();
            $booking->save();

            // Opsional: Kirim notifikasi ke user bahwa bookingnya sudah dikonfirmasi
            // if ($booking->user) {
            //     Mail::to($booking->user->email)->send(new BookingConfirmedByAdmin($booking));
            // }
        }

        return redirect()->route('admin.payments.pending')->with('success', 'Pembayaran untuk booking ' . ($payment->booking->booking_code ?? $payment->booking_id) . ' berhasil diverifikasi dan booking telah dikonfirmasi.');
    }

    /**
     * Aksi untuk menolak pembayaran.
     */
    public function rejectPaymentAction(Request $request, Payment $payment)
    {
        // Validasi alasan penolakan jika diperlukan
        $request->validate(['rejection_reason' => 'required_if:reject_action,true|string|max:500']);

        if ($payment->status !== 'waiting_confirmation') {
            return redirect()->route('admin.payments.pending')->with('error', 'Pembayaran ini tidak lagi menunggu verifikasi atau sudah diproses.');
        }

        $reason = $request->input('rejection_reason', 'Pembayaran tidak dapat diverifikasi.');

        $payment->status = 'failed'; // Atau 'rejected'
        $paymentDetails = (array) $payment->payment_details;
        $paymentDetails['rejection_info'] = [
            'reason' => $reason,
            'rejected_by_admin_id' => Auth::id(),
            'rejected_at' => now()->toDateTimeString()
        ];
        $payment->payment_details = $paymentDetails;
        $payment->save();

        if ($payment->booking && $payment->booking->status !== 'cancelled') {
             $payment->booking->status = 'pending'; // Kembalikan ke pending agar user bisa coba bayar ulang atau booking dibatalkan
             $payment->booking->save();
             // Opsional: Kirim notifikasi ke user bahwa pembayaran ditolak
             // if ($payment->booking->user) {
             //    Mail::to($payment->booking->user->email)->send(new PaymentRejectedToUser($payment, $reason));
             // }
        }

        return redirect()->route('admin.payments.pending')->with('success', 'Pembayaran untuk booking ' . ($payment->booking->booking_code ?? $payment->booking_id) . ' telah ditolak. Alasan: ' . $reason);
    }
}
