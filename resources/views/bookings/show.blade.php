@extends('layouts.app')

@section('title', 'Detail Booking - ' . $booking->booking_code)

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        {{-- PERBAIKAN DI SINI: Mengubah 'user.bookings.history' menjadi 'bookings.history' --}}
        <a href="{{ route('bookings.history') }}" class="inline-flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Riwayat Booking
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h2 class="text-2xl leading-6 font-bold text-gray-900">
                Detail Booking
            </h2>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Informasi lengkap mengenai reservasi Anda.
            </p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kode Booking</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->booking_code }}</dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nama Tamu</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->user->name ?? Auth::user()->name }}</dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Kamar</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if($booking->room && $booking->room->roomType)
                            {{ $booking->room->roomType->name }} (Kamar No: {{ $booking->room->room_number }})
                        @else
                            Informasi Kamar Tidak Tersedia
                        @endif
                    </dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Check-in</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->isoFormat('LL') : '-' }}</dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Check-out</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->isoFormat('LL') : '-' }}</dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Durasi Menginap</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->nights }} malam</dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Jumlah Tamu</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->adults }} Dewasa
                        @if($booking->children > 0)
                        , {{ $booking->children }} Anak
                        @endif
                    </dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-semibold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Status Booking</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                            @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'checked_in') bg-blue-100 text-blue-800
                            @elseif($booking->status === 'completed') bg-gray-200 text-gray-800
                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Permintaan Khusus</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ $booking->special_requests ?? '-' }}</dd>
                </div>

                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Tanggal Pemesanan</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->created_at ? $booking->created_at->isoFormat('LLLL') : '-' }}</dd>
                </div>

                 @if($booking->confirmed_at && ($booking->status === 'confirmed' || $booking->status === 'checked_in' || $booking->status === 'completed'))
                <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Dikonfirmasi Pada</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->confirmed_at ? \Carbon\Carbon::parse($booking->confirmed_at)->isoFormat('LLLL') : '-' }}</dd>
                </div>
                @endif

            </dl>
        </div>
        {{-- Tambahkan bagian untuk aksi (Edit/Batalkan) jika status memungkinkan --}}
        @if($booking->status === 'pending' || $booking->status === 'confirmed')
            <div class="border-t border-gray-200 px-4 py-4 sm:px-6 flex justify-end space-x-3">
                @if($booking->status === 'pending' || $booking->status === 'confirmed') {{-- User bisa edit jika masih pending atau sudah dikonfirmasi (sebelum check-in) --}}
                    {{-- Pastikan nama route ini 'bookings.edit' sesuai dengan file routes/web.php Anda --}}
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400">
                        Edit Booking
                    </a>
                @endif
                {{-- User bisa batalkan jika masih pending atau sudah dikonfirmasi (sesuai kebijakan) --}}
                {{-- Pastikan nama route ini 'bookings.destroy' sesuai dengan file routes/web.php Anda --}}
                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                    @method('DELETE')
                    @csrf
                    {{-- PERBAIKAN STYLING TOMBOL BATALKAN --}}
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Batalkan Booking
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
