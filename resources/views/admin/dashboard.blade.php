@extends('layouts.admin_app') {{-- Menggunakan layout admin yang baru --}}

@section('title', 'Dashboard Admin - Hotel Del Luna')

@section('page-title', 'Dashboard Utama Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">


    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
             <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                    <p class="font-bold">Gagal!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0"><div class="p-2 bg-blue-100 rounded-md flex items-center justify-center"><svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div></div>
                    <div class="ml-4 w-0 flex-1"><dl><dt class="text-sm font-medium text-gray-500 truncate">Total Kamar</dt><dd class="text-xl font-semibold text-gray-900">{{ $totalRooms ?? 0 }}</dd></dl></div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3"><div class="text-xs"><span class="text-green-600 font-medium">{{ $availableRooms ?? 0 }} tersedia</span><span class="text-gray-400 mx-1"> • </span><span class="text-red-600 font-medium">{{ $occupiedRooms ?? 0 }} terisi</span></div></div>
        </div>
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5"><div class="flex items-center"><div class="flex-shrink-0"><div class="p-2 bg-green-100 rounded-md flex items-center justify-center"><svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div></div><div class="ml-4 w-0 flex-1"><dl><dt class="text-sm font-medium text-gray-500 truncate">Total Booking</dt><dd class="text-xl font-semibold text-gray-900">{{ $totalBookings ?? 0 }}</dd></dl></div></div></div>
            <div class="bg-gray-50 px-5 py-3"><div class="text-xs"><span class="text-yellow-600 font-medium">{{ $pendingBookings ?? 0 }} pending</span><span class="text-gray-400 mx-1"> • </span><span class="text-green-600 font-medium">{{ $confirmedBookings ?? 0 }} terkonfirmasi</span><span class="text-gray-400 mx-1"> • </span><span class="text-blue-600 font-medium">{{ $checkedInBookings ?? 0 }} check-in</span></div></div>
        </div>
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5"><div class="flex items-center"><div class="flex-shrink-0"><div class="p-2 bg-orange-100 rounded-md flex items-center justify-center"><svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div></div><div class="ml-4 w-0 flex-1"><dl><dt class="text-sm font-medium text-gray-500 truncate">Pembayaran Verifikasi</dt><dd class="text-xl font-semibold text-gray-900">{{ $paymentsWaitingConfirmation ?? 0 }}</dd></dl></div></div></div>
            @if(($paymentsWaitingConfirmation ?? 0) > 0)
            <div class="bg-gray-50 px-5 py-3"><a href="{{ route('admin.payments.pending') }}" class="text-xs font-medium text-orange-600 hover:text-orange-800">Lihat & Verifikasi &rarr;</a></div>
            @endif
        </div>
        <div class="bg-white overflow-hidden shadow-lg rounded-lg">
            <div class="p-5"><div class="flex items-center"><div class="flex-shrink-0"><div class="p-2 bg-teal-100 rounded-md flex items-center justify-center"><svg class="h-6 w-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 11V9h4v2h-4z"></path></svg></div></div><div class="ml-4 w-0 flex-1"><dl><dt class="text-sm font-medium text-gray-500 truncate">Pendapatan Hari Ini</dt><dd class="text-lg font-semibold text-gray-900">Rp {{ number_format($todayRevenue ?? 0, 0, ',', '.') }}</dd><dt class="mt-1 text-sm font-medium text-gray-500 truncate">Pendapatan Bulan Ini</dt><dd class="text-lg font-semibold text-gray-900">Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}</dd></dl></div></div></div>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Aksi Cepat Admin</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            <a href="{{ route('admin.payments.pending') }}" class="bg-gradient-to-br from-orange-500 to-red-500 text-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex flex-col items-center justify-center text-center h-32"><div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 11V9h4v2h-4z"></path></svg></div><h3 class="text-sm font-semibold">Verifikasi Pembayaran</h3><p class="text-xs opacity-80">{{ $paymentsWaitingConfirmation ?? 0 }} menunggu</p></a>
            <a href="{{ route('admin.bookings.index') }}" class="bg-gradient-to-br from-green-500 to-teal-500 text-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex flex-col items-center justify-center text-center h-32"><div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div><h3 class="text-sm font-semibold">Kelola Booking</h3><p class="text-xs opacity-80">Semua reservasi</p></a>
            <a href="{{ route('admin.rooms.index') }}" class="bg-gradient-to-br from-blue-500 to-indigo-500 text-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex flex-col items-center justify-center text-center opacity-60 cursor-not-allowed h-32" title="Fitur Kelola Kamar belum tersedia"><div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg></div><h3 class="text-sm font-semibold">Kelola Kamar</h3><p class="text-xs opacity-80">Tipe & fasilitas</p></a>
            <a href="{{ route('admin.users.index') }}" class="bg-gradient-to-br from-purple-500 to-pink-500 text-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex flex-col items-center justify-center text-center opacity-60 cursor-not-allowed h-32" title="Fitur Kelola Pengguna belum tersedia"><div class="mb-2"><svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div><h3 class="text-sm font-semibold">Kelola Pengguna</h3><p class="text-xs opacity-80">Admin & tamu</p></a>
        </div>
    </div>

    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Booking Terbaru & Menunggu Konfirmasi</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua Booking</a>
        </div>
        <div class="bg-white shadow-xl overflow-hidden sm:rounded-lg">
             <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Booking</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Pembayaran</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentAndPendingPaymentBookings ?? [] as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center ring-1 ring-gray-300">
                                            <span class="text-sm font-medium text-gray-700">{{ $booking->user ? substr($booking->user->name, 0, 1) : '?' }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name ?? 'Tamu Dihapus' }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->user->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->room && $booking->room->roomType ? $booking->room->roomType->name : 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">Kamar {{ $booking->room->room_number ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->isoFormat('D MMM YY') }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->nights }} malam</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $bookingStatusClass = 'bg-gray-100 text-gray-800 border border-gray-300'; // Default
                                        if($booking->status === 'pending') $bookingStatusClass = 'bg-yellow-100 text-yellow-800 border border-yellow-300';
                                        elseif($booking->status === 'confirmed') $bookingStatusClass = 'bg-green-100 text-green-800 border border-green-300';
                                        elseif($booking->status === 'checked_in') $bookingStatusClass = 'bg-blue-100 text-blue-800 border border-blue-300';
                                        elseif($booking->status === 'completed' || $booking->status === 'checked_out') $bookingStatusClass = 'bg-gray-200 text-gray-700 border border-gray-300';
                                        elseif($booking->status === 'cancelled') $bookingStatusClass = 'bg-red-100 text-red-800 border border-red-300';
                                    @endphp
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{ $bookingStatusClass }}">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php $latestPayment = $booking->payments->first(); @endphp
                                    @if($latestPayment)
                                        @php
                                            $paymentStatusClass = 'bg-gray-100 text-gray-800 border border-gray-300'; // Default
                                            if($latestPayment->status === 'pending') $paymentStatusClass = 'bg-yellow-100 text-yellow-800 border border-yellow-300';
                                            elseif($latestPayment->status === 'waiting_confirmation') $paymentStatusClass = 'bg-orange-100 text-orange-800 border border-orange-300';
                                            elseif($latestPayment->status === 'completed') $paymentStatusClass = 'bg-green-100 text-green-800 border border-green-300';
                                            elseif($latestPayment->status === 'failed') $paymentStatusClass = 'bg-red-100 text-red-800 border border-red-300';
                                        @endphp
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{ $paymentStatusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $latestPayment->status)) }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-300">
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-800 mr-2" title="Lihat Detail Booking">Detail</a>
                                    @if($latestPayment && $latestPayment->status === 'waiting_confirmation')
                                        <a href="{{ route('admin.payments.verify.detail', $latestPayment->id) }}" class="text-green-600 hover:text-green-800" title="Verifikasi Pembayaran Ini">Verifikasi</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                    Tidak ada booking terbaru atau yang menunggu konfirmasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($recentAndPendingPaymentBookings) && $recentAndPendingPaymentBookings instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $recentAndPendingPaymentBookings->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $recentAndPendingPaymentBookings->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
