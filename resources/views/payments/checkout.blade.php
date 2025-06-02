@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Pembayaran Booking - ' . $booking->booking_code)

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Checkout Pembayaran</h1>
                <p class="mt-1 text-sm text-gray-500">Selesaikan pembayaran untuk booking <span class="font-semibold text-indigo-600">{{ $booking->booking_code }}</span>.</p>
            </div>
            <a href="{{ route('bookings.history') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Riwayat Booking
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">Info:</p> {{-- Diubah dari Berhasil! menjadi Info: agar lebih sesuai dengan pesan dari controller --}}
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                 <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">Error:</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Ringkasan Booking</h3>
            </div>
            <div class="px-6 py-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Kode Booking</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->booking_code }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Nama Tamu</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->user->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Kamar</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $booking->room->roomType->name ?? 'N/A' }} (No: {{ $booking->room->room_number ?? 'N/A' }})
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Tanggal Menginap</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->isoFormat('LL') : '-' }}
                            sampai
                            {{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->isoFormat('LL') : '-' }}
                            ({{ $booking->nights }} malam)
                        </dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Total Tagihan</dt>
                        <dd class="mt-1 text-2xl font-semibold text-indigo-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="px-6 py-5 bg-gray-50 border-t border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Instruksi Pembayaran</h3>
            </div>
            <div class="px-6 py-6">
                <div class="prose prose-sm max-w-none text-gray-700">
                    <p>Silakan lakukan pembayaran sejumlah <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong> ke salah satu rekening berikut:</p>
                    <ul>
                        <li><strong>Bank BCA:</strong> 123-456-7890 a/n Hotel Del Luna</li>
                        <li><strong>Bank Mandiri:</strong> 098-765-4321 a/n Hotel Del Luna</li>
                    </ul>
                    <p>Mohon selesaikan pembayaran sebelum <strong>{{ \Carbon\Carbon::parse($booking->created_at)->addHours(2)->isoFormat('LLLL') }}</strong> (2 jam setelah pemesanan).</p>
                    <p>Setelah melakukan pembayaran, mohon konfirmasi dengan menekan tombol di bawah ini. Booking Anda akan segera kami proses setelah pembayaran diverifikasi oleh admin.</p>
                    <p class="mt-4 text-xs text-gray-500">ID Pembayaran Anda: {{ $payment->id }} (Simpan untuk referensi)</p>
                </div>

                <div class="mt-8 border-t pt-6">
                    @if($payment->status === 'pending')
                        <form action="{{ route('payments.confirm_user_payment', $payment->id) }}" method="POST" class="text-center">
                            @csrf
                            {{-- Opsional: Tambahkan input untuk unggah bukti pembayaran jika diperlukan --}}
                            {{-- <div class="mb-4">
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700">Unggah Bukti Pembayaran (Opsional)</label>
                                <input type="file" name="payment_proof" id="payment_proof" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @error('payment_proof')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Saya Sudah Melakukan Pembayaran
                            </button>
                        </form>
                    @elseif($payment->status === 'waiting_confirmation')
                        <div class="text-center p-4 bg-yellow-50 text-yellow-700 rounded-md">
                            <p class="font-medium">Konfirmasi pembayaran Anda sedang menunggu verifikasi oleh admin.</p>
                            <p class="text-sm">Mohon tunggu, kami akan segera memproses booking Anda.</p>
                        </div>
                    @else
                         <div class="text-center p-4 bg-blue-50 text-blue-700 rounded-md">
                            <p class="font-medium">Status Pembayaran: {{ ucfirst(str_replace('_', ' ', $payment->status)) }}</p>
                         </div>
                    @endif
                </div>

                <div class="mt-8 text-center">
                     <a href="{{ route('bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                        Lihat Detail Booking Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
