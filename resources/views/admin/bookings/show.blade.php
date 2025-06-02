@extends('layouts.app') {{-- Sesuaikan dengan layout admin Anda --}}

@section('title', 'Detail Booking (Admin) - ' . $booking->booking_code)

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Detail Booking: <span class="text-indigo-600">{{ $booking->booking_code }}</span></h1>
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm font-medium">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Booking
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Lengkap Reservasi</h3>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    {{-- Detail Booking --}}
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Kode Booking</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->booking_code }}</dd>
                    </div>
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Nama Tamu</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->user->name ?? 'N/A' }} ({{ $booking->user->email ?? 'N/A' }})</dd>
                    </div>
                     <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Telepon Tamu</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->user->phone ?? '-' }}</dd>
                    </div>
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Kamar</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $booking->room->roomType->name ?? 'N/A' }} (No: {{ $booking->room->room_number ?? 'N/A' }})
                        </dd>
                    </div>
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Check-in</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->check_in_date ? \Carbon\Carbon::parse($booking->check_in_date)->isoFormat('dddd, D MMMM YYYY') : '-' }}</dd>
                    </div>
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Check-out</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->check_out_date ? \Carbon\Carbon::parse($booking->check_out_date)->isoFormat('dddd, D MMMM YYYY') : '-' }}</dd>
                    </div>
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->nights }} malam</dd>
                    </div>
                     <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Jumlah Tamu</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->adults }} Dewasa, {{ $booking->children }} Anak</dd>
                    </div>
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Total Harga</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 font-semibold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</dd>
                    </div>
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status Booking</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{-- ... kelas warna status booking ... --}}
                                @if($booking->status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-300
                                @elseif($booking->status === 'confirmed') bg-green-100 text-green-800 border border-green-300
                                @elseif($booking->status === 'checked_in') bg-blue-100 text-blue-800 border border-blue-300
                                @elseif($booking->status === 'completed') bg-gray-200 text-gray-700 border border-gray-300
                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800 border border-red-300
                                @else bg-gray-100 text-gray-800 border border-gray-300
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
                        <dt class="text-sm font-medium text-gray-500">Dibuat Pada</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $booking->created_at->isoFormat('LLLL') }}</dd>
                    </div>
                    @if($booking->confirmed_at)
                    <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Dikonfirmasi Admin Pada</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ \Carbon\Carbon::parse($booking->confirmed_at)->isoFormat('LLLL') }}</dd>
                    </div>
                    @endif

                    {{-- Detail Pembayaran Terkait --}}
                    @if($booking->payments->count() > 0)
                        <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 bg-gray-50 rounded-b-lg">
                            <dt class="text-sm font-medium text-gray-600">Riwayat Pembayaran</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul class="divide-y divide-gray-200">
                                    @foreach($booking->payments->sortByDesc('created_at') as $payment)
                                        <li class="py-2">
                                            <div class="flex justify-between">
                                                <span class="font-medium">Rp {{ number_format($payment->amount,0,',','.') }}</span>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{-- ... kelas warna status payment ... --}}
                                                    @if($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($payment->status === 'waiting_confirmation') bg-orange-100 text-orange-800
                                                    @elseif($payment->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($payment->status === 'failed') bg-red-100 text-red-800
                                                    @elseif($payment->status === 'refunded') bg-purple-100 text-purple-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_',' ',$payment->status)) }}
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                ID: {{ $payment->id }} | Metode: {{ $payment->payment_method ?? 'N/A' }}
                                                @if($payment->paid_at) | Dibayar: {{ \Carbon\Carbon::parse($payment->paid_at)->isoFormat('D MMM YY, HH:mm') }} @endif
                                                @if($payment->transaction_id) | Trans. ID: {{ $payment->transaction_id }} @endif
                                            </div>
                                             @if($payment->status === 'waiting_confirmation')
                                                <div class="mt-2">
                                                    <a href="{{ route('admin.payments.verify.detail', $payment->id) }}" class="text-sm font-medium text-green-600 hover:text-green-800">
                                                        Verifikasi Pembayaran Ini &rarr;
                                                    </a>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </dd>
                        </div>
                    @else
                        <div class="py-3 sm:py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Pembayaran</dt>
                            <dd class="mt-1 text-sm text-gray-700 sm:mt-0 sm:col-span-2">Belum ada data pembayaran.</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Aksi Admin --}}
             <div class="px-4 py-4 sm:px-6 border-t border-gray-200 bg-gray-50">
                <h4 class="text-md font-medium text-gray-700 mb-3">Aksi Admin</h4>
                <div class="flex flex-wrap gap-3">
                    @php $latestPayment = $booking->payments->where('status', '!=', 'failed')->sortByDesc('created_at')->first(); @endphp
                    @if($latestPayment && $latestPayment->status === 'waiting_confirmation')
                        <a href="{{ route('admin.payments.verify.detail', $latestPayment->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                            Verifikasi Pembayaran
                        </a>
                    @endif

                    @if($booking->status === 'confirmed')
                        {{-- Form untuk Check-in --}}
                        <form action="{{ route('admin.bookings.checkin', $booking->id) }}" method="POST" onsubmit="return confirm('Konfirmasi Check-in untuk tamu ini?');">
                            @csrf
                            @method('PATCH') {{-- atau POST jika Anda lebih suka --}}
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                Check-in Tamu
                            </button>
                        </form>
                    @elseif($booking->status === 'checked_in')
                         {{-- Form untuk Check-out --}}
                        <form action="{{ route('admin.bookings.checkout', $booking->id) }}" method="POST" onsubmit="return confirm('Konfirmasi Check-out untuk tamu ini? Booking akan ditandai selesai.');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-teal-600 hover:bg-teal-700">
                                Check-out & Selesaikan
                            </button>
                        </form>
                    @endif

                    @if($booking->status !== 'cancelled' && $booking->status !== 'completed' && $booking->status !== 'checked_out' )
                         {{-- Form untuk Batalkan Booking oleh Admin --}}
                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin MEMBATALKAN booking ini dari sisi Admin?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Batalkan Booking (Admin)
                            </button>
                        </form>
                    @endif
                    {{-- Tambahkan link untuk edit booking jika diperlukan --}}
                     <a href="{{ route('admin.bookings.edit.form', $booking->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Edit Detail Booking (Admin)
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
