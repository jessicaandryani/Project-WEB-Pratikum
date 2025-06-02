@extends('layouts.app')

@section('title', 'Edit Booking - ' . $booking->booking_code)

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        {{-- PERBAIKAN 1: Menggunakan 'bookings.show' --}}
        <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Detail Booking
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Booking: {{ $booking->booking_code }}</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- PERBAIKAN 2: Menggunakan 'bookings.update' untuk action form --}}
    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')

        <div class="mb-6 p-4 border border-blue-200 bg-blue-50 rounded-md">
            <h3 class="text-lg font-semibold text-blue-700 mb-2">Informasi Kamar (Tidak Dapat Diubah)</h3>
            <p class="text-sm text-gray-700"><strong>Tipe Kamar:</strong> {{ $booking->room->roomType->name ?? 'N/A' }}</p>
            <p class="text-sm text-gray-700"><strong>Nomor Kamar:</strong> {{ $booking->room->room_number ?? 'N/A' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label for="check_in_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-in</label>
                <input type="date" name="check_in_date" id="check_in_date"
                       value="{{ old('check_in_date', $booking->check_in_date ? $booking->check_in_date->format('Y-m-d') : '') }}"
                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('check_in_date') border-red-500 @enderror"
                       required>
                @error('check_in_date')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-out</label>
                <input type="date" name="check_out_date" id="check_out_date"
                       value="{{ old('check_out_date', $booking->check_out_date ? $booking->check_out_date->format('Y-m-d') : '') }}"
                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('check_out_date') border-red-500 @enderror"
                       required>
                @error('check_out_date')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label for="adults" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Dewasa</label>
                <input type="number" name="adults" id="adults" value="{{ old('adults', $booking->adults) }}" min="1"
                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('adults') border-red-500 @enderror"
                       required>
                @error('adults')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="children" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Anak (Opsional)</label>
                <input type="number" name="children" id="children" value="{{ old('children', $booking->children) }}" min="0"
                       class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('children') border-red-500 @enderror">
                @error('children')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Permintaan Khusus (Opsional)</label>
            <textarea name="special_requests" id="special_requests" rows="4"
                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md @error('special_requests') border-red-500 @enderror">{{ old('special_requests', $booking->special_requests) }}</textarea>
            @error('special_requests')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-3">
            {{-- PERBAIKAN 3: Menggunakan 'bookings.show' untuk link Batal --}}
            <a href="{{ route('bookings.show', $booking->id) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition">
                Batal
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
