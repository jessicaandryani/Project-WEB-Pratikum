@extends('layouts.app') {{-- Ganti dengan layout admin Anda jika berbeda --}}

@section('title', 'Verifikasi Pembayaran - Admin Hotel Del Luna')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pembayaran Menunggu Verifikasi</h1>
                <p class="mt-1 text-sm text-gray-500">Verifikasi pembayaran yang telah dikonfirmasi oleh pengguna.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard Admin
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

        @if($paymentsToVerify->count() > 0)
            <div class="bg-white shadow-xl overflow-hidden sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Payment</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Booking</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode (Jika Ada)</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Konfirmasi User</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($paymentsToVerify as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $payment->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 hover:text-indigo-800">
                                    <a href="{{ route('admin.bookings.show', $payment->booking_id) }}">{{ $payment->booking->booking_code ?? 'N/A' }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $payment->booking->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-semibold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $payment->payment_method ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">{{ $payment->updated_at->isoFormat('D MMM YY, HH:mm') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        {{-- Link ke halaman detail verifikasi (opsional) --}}
                                        <a href="{{ route('admin.payments.verify.detail', $payment->id) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded-md hover:bg-blue-50" title="Lihat Detail & Verifikasi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v4a1 1 0 102 0V5zm0 6a1 1 0 10-2 0v2a1 1 0 102 0v-2z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        {{-- Tombol Aksi Langsung --}}
                                        <form action="{{ route('admin.payments.confirmAction', $payment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin mengonfirmasi pembayaran ini?');">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 p-1 rounded-md hover:bg-green-50" title="Konfirmasi Pembayaran">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                        {{-- Tombol Tolak (membutuhkan form untuk alasan jika perlu) --}}
                                        <form action="{{ route('admin.payments.rejectAction', $payment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menolak pembayaran ini?');">
                                            @csrf
                                            {{-- Anda bisa menambahkan input hidden untuk alasan penolakan atau membuatnya lebih kompleks --}}
                                            {{-- <input type="hidden" name="rejection_reason" value="Bukti tidak valid"> --}}
                                            <button type="submit" class="text-red-600 hover:text-red-800 p-1 rounded-md hover:bg-red-50" title="Tolak Pembayaran">
                                                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($paymentsToVerify->hasPages())
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $paymentsToVerify->links() }}
                </div>
                @endif
            </div>
        @else
            <div class="text-center py-16 bg-white shadow-lg sm:rounded-lg">
                 <svg class="mx-auto h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                <h3 class="mt-4 text-xl font-semibold text-gray-800">Tidak Ada Pembayaran</h3>
                <p class="mt-2 text-sm text-gray-500">Saat ini tidak ada pembayaran yang menunggu verifikasi.</p>
            </div>
        @endif
    </div>
</div>
@endsection
