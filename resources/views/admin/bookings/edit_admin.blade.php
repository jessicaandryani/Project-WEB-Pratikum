@extends('layouts.admin_app') {{-- Sesuaikan dengan layout admin Anda --}}

@section('title', 'Edit Booking (Admin) - ' . $booking->booking_code)

@section('page-title', 'Edit Booking: ' . $booking->booking_code) {{-- Untuk header di layout admin --}}

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition text-sm font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Kembali ke Detail Booking (Admin)
        </a>
    </div>

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    @if ($errors->any()) {{-- Menampilkan semua error validasi --}}
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Oops! Ada beberapa kesalahan dengan input Anda:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Pastikan route 'admin.bookings.update.action' sesuai dengan definisi Anda di routes/web.php --}}
    <form action="{{ route('admin.bookings.update.action', $booking->id) }} method="POST" class="bg-white shadow-xl rounded-lg overflow-hidden">
        @csrf
        @method('PUT')

        <div class="px-6 py-5 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Edit Detail Reservasi (Admin)
            </h3>
            <p class="mt-1 text-sm text-gray-500">
                Admin dapat mengubah detail reservasi, termasuk status dan total harga.
            </p>
        </div>

        <div class="px-6 py-6">
            <div class="mb-6 p-4 border border-gray-200 bg-gray-50 rounded-md">
                <h4 class="text-md font-semibold text-gray-700 mb-2">Informasi Tamu & Kamar Awal</h4>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    <p><strong class="text-gray-500">Tamu:</strong> {{ $booking->user->name ?? 'N/A' }} ({{ $booking->user->email ?? 'N/A' }})</p>
                    <p><strong class="text-gray-500">Telepon:</strong> {{ $booking->user->phone ?? '-' }}</p>
                    <p><strong class="text-gray-500">Tipe Kamar:</strong> {{ $booking->room->roomType->name ?? 'N/A' }}</p>
                    <p><strong class="text-gray-500">Nomor Kamar:</strong> {{ $booking->room->room_number ?? 'N/A' }}</p>
                     {{-- Untuk fitur ganti kamar, Anda perlu logika tambahan dan dropdown kamar tersedia --}}
                    {{-- <div>
                        <label for="room_id" class="block text-sm font-medium text-gray-700 mb-1">Ganti Kamar (Opsional)</label>
                        <select name="room_id" id="room_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('room_id') border-red-500 @enderror">
                            <option value="{{ $booking->room_id }}">{{ $booking->room->roomType->name }} - No {{ $booking->room->room_number }} (Saat Ini)</option>
                            @foreach($availableRooms ?? [] as $room)
                                <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->roomType->name }} - No {{ $room->room_number }} ({{ $room->status }})
                                </option>
                            @endforeach
                        </select>
                        @error('room_id') <p class="mt-2 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div> --}}
                </dl>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="check_in_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-in <span class="text-red-500">*</span></label>
                    <input type="date" name="check_in_date" id="check_in_date"
                           value="{{ old('check_in_date', $booking->check_in_date ? $booking->check_in_date->format('Y-m-d') : '') }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('check_in_date') border-red-500 @enderror"
                           required>
                    @error('check_in_date')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-out <span class="text-red-500">*</span></label>
                    <input type="date" name="check_out_date" id="check_out_date"
                           value="{{ old('check_out_date', $booking->check_out_date ? $booking->check_out_date->format('Y-m-d') : '') }}"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('check_out_date') border-red-500 @enderror"
                           required>
                    @error('check_out_date')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="adults" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Dewasa <span class="text-red-500">*</span></label>
                    <input type="number" name="adults" id="adults" value="{{ old('adults', $booking->adults) }}" min="1"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('adults') border-red-500 @enderror"
                           required>
                    @error('adults')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="children" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Anak</label>
                    <input type="number" name="children" id="children" value="{{ old('children', $booking->children) }}" min="0"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('children') border-red-500 @enderror">
                    @error('children')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Booking <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('status') border-red-500 @enderror">
                        <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="checked_in" {{ old('status', $booking->status) == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                        <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Completed (Checked Out)</option>
                        <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        {{-- Tambahkan status lain jika ada --}}
                    </select>
                    @error('status')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="total_amount" class="block text-sm font-medium text-gray-700 mb-1">Total Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="total_amount" id="total_amount" value="{{ old('total_amount', $booking->total_amount) }}" min="0" step="1000"
                           class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('total_amount') border-red-500 @enderror"
                           required>
                    @error('total_amount')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Permintaan Khusus</label>
                <textarea name="special_requests" id="special_requests" rows="3"
                          class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('special_requests') border-red-500 @enderror">{{ old('special_requests', $booking->special_requests) }}</textarea>
                @error('special_requests')
                    <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-end space-x-3">
            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Batal
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Simpan Perubahan (Admin)
            </button>
        </div>
    </form>
</div>
@endsection
