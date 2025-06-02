@extends('layouts.app') {{-- Ganti dengan layout admin Anda --}}

@section('title', 'Verifikasi Detail Pembayaran - Admin')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.payments.pending') }}" class="inline-flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Verifikasi
            </a>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 mb-6">Detail Verifikasi Pembayaran</h1>

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Payment ID: <span class="text-indigo-600">{{ $payment->id }}</span>
                    untuk Booking: <a href="{{ route('admin.bookings.show', $payment->booking_id) }}" class="text-indigo-600 hover:underline">{{ $payment->booking->booking_code ?? 'N/A' }}</a>
                </h3>
            </div>
            <div class="px-6 py-6 space-y-6">
                {{-- Detail Booking --}}
                <div>
                    <h4 class="text-md font-semibold text-gray-700 mb-2">Informasi Booking</h4>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2 text-sm">
                        <div><dt class="font-medium text-gray-500">Tamu:</dt><dd class="text-gray-900">{{ $payment->booking->user->name ?? 'N/A' }}</dd></div>
                        <div><dt class="font-medium text-gray-500">Email:</dt><dd class="text-gray-900">{{ $payment->booking->user->email ?? 'N/A' }}</dd></div>
                        <div><dt class="font-medium text-gray-500">Kamar:</dt><dd class="text-gray-900">{{ $payment->booking->room->roomType->name ?? 'N/A' }} (No: {{ $payment->booking->room->room_number ?? 'N/A' }})</dd></div>
                        <div><dt class="font-medium text-gray-500">Check-in:</dt><dd class="text-gray-900">{{ \Carbon\Carbon::parse($payment->booking->check_in_date)->isoFormat('LL') }}</dd></div>
                        <div><dt class="font-medium text-gray-500">Check-out:</dt><dd class="text-gray-900">{{ \Carbon\Carbon::parse($payment->booking->check_out_date)->isoFormat('LL') }} ({{ $payment->booking->nights }} malam)</dd></div>
                    </dl>
                </div>

                {{-- Detail Payment --}}
                <div class="border-t pt-6">
                    <h4 class="text-md font-semibold text-gray-700 mb-2">Informasi Pembayaran</h4>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2 text-sm">
                        <div><dt class="font-medium text-gray-500">Jumlah Dibayar:</dt><dd class="text-gray-900 font-bold text-lg">Rp {{ number_format($payment->amount, 0, ',', '.') }}</dd></div>
                        <div><dt class="font-medium text-gray-500">Metode (jika ada):</dt><dd class="text-gray-900">{{ $payment->payment_method ?? '-' }}</dd></div>
                        <div><dt class="font-medium text-gray-500">Status Saat Ini:</dt>
                            <dd>
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-4 font-semibold rounded-full bg-orange-100 text-orange-800 border border-orange-300">
                                    {{ ucfirst(str_replace('_', ' ', $payment->status)) }}
                                </span>
                            </dd>
                        </div>
                        <div><dt class="font-medium text-gray-500">User Konfirmasi Pada:</dt><dd class="text-gray-900">{{ $payment->updated_at->isoFormat('LLLL') }}</dd></div>
                        {{-- Jika ada bukti pembayaran yang diupload user --}}
                        @if(isset($payment->payment_details['user_uploaded_proof']))
                        <div class="sm:col-span-2"><dt class="font-medium text-gray-500">Bukti Pembayaran User:</dt>
                            <dd class="mt-1">
                                {{-- Tampilkan gambar atau link ke file bukti. Pastikan path storage sudah di-link dan aman. --}}
                                <a href="{{ asset('storage/' . $payment->payment_details['user_uploaded_proof']) }}" target="_blank" class="text-indigo-600 hover:underline">
                                    Lihat Bukti
                                </a>
                                {{-- <img src="{{ asset('storage/' . $payment->payment_details['user_uploaded_proof']) }}" alt="Bukti Pembayaran" class="max-w-xs h-auto rounded border"> --}}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>

                {{-- Tombol Aksi --}}
                <div class="border-t pt-6 flex justify-end space-x-3">
                    <form action="{{ route('admin.payments.rejectAction', $payment->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin MENOLAK pembayaran ini? Booking akan dikembalikan ke status PENDING.');">
                        @csrf
                        {{-- Anda bisa menambahkan field alasan penolakan di sini jika diperlukan --}}
                        {{-- <textarea name="rejection_reason" placeholder="Alasan Penolakan (opsional)" class="w-full mb-2 ..."></textarea> --}}
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Tolak Pembayaran
                        </button>
                    </form>
                    <form action="{{ route('admin.payments.confirmAction', $payment->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin MENGONFIRMASI pembayaran ini? Booking akan menjadi CONFIRMED.');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Konfirmasi & Setujui Booking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
