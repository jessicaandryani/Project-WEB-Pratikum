@extends('layouts.app') {{-- Sesuaikan dengan layout admin Anda --}}

@section('title', 'Kelola Booking - Admin')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Semua Booking</h1>
                <p class="mt-1 text-sm text-gray-500">Lihat dan kelola semua reservasi yang masuk.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Tambahkan filter di sini jika diperlukan --}}
        {{-- <div class="mb-4 p-4 bg-white shadow rounded-lg">
            <form method="GET" action="{{ route('admin.bookings.index') }}">
                <label for="status" class="mr-2">Filter Status:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="waiting_confirmation" {{ request('status') == 'waiting_confirmation' ? 'selected' : '' }}>Menunggu Konfirmasi Bayar</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </form>
        </div> --}}


        @if($bookings->count() > 0)
            <div class="bg-white shadow-xl overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tamu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Booking</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Bayar</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}">{{ $booking->booking_code }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->user->email ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->room->roomType->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">No: {{ $booking->room->room_number ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->isoFormat('D MMM YY') }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->nights }} malam</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{-- ... kelas warna status booking ... --}}
                                        @if($booking->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-300
                                        @elseif($booking->status === 'confirmed') bg-green-100 text-green-800 border border-green-300
                                        @elseif($booking->status === 'checked_in') bg-blue-100 text-blue-800 border border-blue-300
                                        @elseif($booking->status === 'completed') bg-gray-200 text-gray-700 border border-gray-300
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800 border border-red-300
                                        @else bg-gray-100 text-gray-800 border border-gray-300
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php $latestPayment = $booking->payments->first(); @endphp
                                    @if($latestPayment)
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{-- ... kelas warna status payment ... --}}
                                        @if($latestPayment->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-300
                                        @elseif($latestPayment->status === 'waiting_confirmation') bg-orange-100 text-orange-800 border border-orange-300
                                        @elseif($latestPayment->status === 'completed') bg-green-100 text-green-800 border border-green-300
                                        @elseif($latestPayment->status === 'failed') bg-red-100 text-red-800 border border-red-300
                                        @else bg-gray-100 text-gray-800 border border-gray-300
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $latestPayment->status)) }}
                                    </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-gray-100 text-gray-800 border border-gray-300">Belum Ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Detail</a>
                                    @if($latestPayment && $latestPayment->status === 'waiting_confirmation')
                                        <a href="{{ route('admin.payments.verify.detail', $latestPayment->id) }}" class="text-green-600 hover:text-green-900">Verifikasi Bayar</a>
                                    @endif
                                    {{-- Tambahkan aksi admin lain di sini (misal: Check-in, Check-out) --}}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($bookings->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $bookings->links() }}
                </div>
                @endif
            </div>
        @else
            <div class="text-center py-12 bg-white shadow-lg sm:rounded-lg">
                <p class="text-gray-500">Tidak ada data booking yang ditemukan.</p>
            </div>
        @endif
    </div>
</div>
@endsection
