@extends('layouts.app')

@section('title', 'Booking - Hotel Del Luna')
@section('content')
<a href="{{ route('user.dashboard') }}" class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">Back</a>

<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Pesan Kamar</h2>

    @if(session('success'))
        <div class="bg-green-100 p-3 rounded mb-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('bookings.store') }}">
        @csrf
    

        <div class="mb-4">
            <label for="room_id" class="block font-medium">Pilih Kamar</label>
            <select name="room_id" id="room_id" class="w-full border rounded p-2">
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->room_number }} - {{ $room->roomType->name }}</option>
                @endforeach
            </select>
            @error('room_id') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="check_in_date" class="block font-medium">Tanggal Check-in</label>
            <input type="date" name="check_in_date" id="check_in_date" class="w-full border rounded p-2" required>
            @error('check_in_date') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="check_out_date" class="block font-medium">Tanggal Check-out</label>
            <input type="date" name="check_out_date" id="check_out_date" class="w-full border rounded p-2" required>
            @error('check_out_date') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="adults" class="block font-medium">Jumlah Dewasa</label>
            <input type="number" name="adults" id="adults" class="w-full border rounded p-2" min="1" required>
            @error('adults') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="children" class="block font-medium">Jumlah Anak</label>
            <input type="number" name="children" id="children" class="w-full border rounded p-2" min="0">
            @error('children') <p class="text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="special_requests" class="block font-medium">Permintaan Khusus</label>
            <textarea name="special_requests" id="special_requests" class="w-full border rounded p-2"></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Pesan Sekarang</button>
    </form>
</div>
@endsection
