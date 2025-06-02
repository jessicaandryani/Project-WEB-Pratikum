@extends('layouts.app')

@section('title', 'Dashboard Tamu - Hotel Del Luna')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard Tamu</h1>
                    <p class="mt-1 text-sm text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-600 font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('bookings.create') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Pesan Kamar</h3>
                            <p class="text-sm text-gray-500">Buat reservasi baru</p>
                        </div>
                    </div>
                </a>
            
                <a href="{{ route('bookings.history') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Riwayat Booking</h3>
                            <p class="text-sm text-gray-500">Lihat semua reservasi Anda</p>
                        </div>
                    </div>
                </a>
            
                <a href="{{ route('profile.show') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow border border-gray-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">Profil Saya</h3>
                            <p class="text-sm text-gray-500">Kelola informasi akun</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Current Bookings -->
        <div class="mb-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Reservasi Aktif</h2>
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Booking Terkini</h3>
                </div>
                <div class="p-6">
                    @php
                        $userBookings = \App\Models\Booking::where('user_id', Auth::id())
                            ->whereIn('status', ['pending', 'confirmed', 'checked_in'])
                            ->with(['room.roomType'])
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp

                    @if($userBookings->count() > 0)
                        <div class="space-y-4">
                            @foreach($userBookings as $booking)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $booking->room->roomType->name }}</h4>
                                            <p class="text-sm text-gray-600">Kamar {{ $booking->room->room_number }}</p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }} - 
                                                {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                            </p>
                                            <p class="text-sm text-gray-500">{{ $booking->nights }} malam • {{ $booking->adults }} dewasa</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status === 'checked_in') bg-blue-100 text-blue-800
                                                @endif">
                                                @if($booking->status === 'pending') Menunggu Konfirmasi
                                                @elseif($booking->status === 'confirmed') Dikonfirmasi
                                                @elseif($booking->status === 'checked_in') Check-in
                                                @endif
                                            </span>
                                            <p class="text-lg font-semibold text-gray-900 mt-2">
                                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada reservasi</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat reservasi kamar pertama Anda.</p>
                            <a href="{{ route('bookings.create') }}">
                                <div class="mt-6">
                                <button  type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pesan Kamar
                                </button>
                                </div>
                            </a>
                            
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Hotel Services -->
        <div>
            <h2 class="text-lg font-medium text-gray-900 mb-4">Layanan Hotel</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $services = \App\Models\Service::where('is_active', true)->take(8)->get();
                @endphp

                @foreach($services as $service)
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                        <div class="flex items-center mb-3">
                            <div class="h-8 w-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                @if($service->category === 'food')
                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                @elseif($service->category === 'spa')
                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                @elseif($service->category === 'transport')
                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h3 class="ml-2 text-sm font-medium text-gray-900">{{ $service->name }}</h3>
                        </div>
                        <p class="text-xs text-gray-600 mb-2">{{ Str::limit($service->description, 60) }}</p>
                        <p class="text-sm font-semibold text-indigo-600">
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
