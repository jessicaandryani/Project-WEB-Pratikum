@extends('layouts.admin_app') {{-- Pastikan menggunakan layout admin Anda --}}

@section('title', 'Kelola Kamar - Admin')
@section('page-title', 'Manajemen Kamar Hotel')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 pb-4 border-b border-gray-200">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Daftar Kamar</h1>
            <p class="mt-1 text-sm text-gray-500">Kelola semua kamar dan tipe kamar yang tersedia di hotel.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex space-x-3">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                Dashboard
            </a>
            {{-- Tombol Tambah Kamar Baru (dikomentari jika route belum siap) --}}
            <a href="{{-- route('admin.rooms.create') --}}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 opacity-50 cursor-not-allowed" title="Fitur Tambah Kamar belum diimplementasikan">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Tambah Kamar Baru
            </a>
        </div>
    </div>

    @include('partials.admin.flash_messages')

    {{-- Area Filter --}}
    <div class="mb-6 bg-white p-4 shadow-md rounded-lg border border-gray-200">
        <form method="GET" action="{{ route('admin.rooms.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="search_room_number" class="block text-sm font-medium text-gray-700">Cari No. Kamar</label>
                <input type="text" name="search_room_number" id="search_room_number" value="{{ request('search_room_number') }}" placeholder="e.g. 101" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="room_type_id" class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
                <select name="room_type_id" id="room_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Semua Tipe</option>
                    @foreach($roomTypes as $type) {{-- Pastikan $roomTypes di-pass dari controller --}}
                        <option value="{{ $type->id }}" {{ request('room_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status Kamar</label>
                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="cleaning" {{ request('status') == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                </select>
            </div>
            <div class="flex items-center space-x-2">
                 <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    Filter
                </button>
                @if(request()->has('search_room_number') || request()->filled('room_type_id') || request()->filled('status'))
                    <a href="{{ route('admin.rooms.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition ease-in-out duration-150">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>


    @if($rooms->count() > 0)
        <div class="bg-white shadow-xl overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Kamar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Kamar</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Dasar</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Lantai</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rooms as $room)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $room->room_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $room->roomType->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                @php
                                    $statusClass = 'bg-gray-100 text-gray-800 border border-gray-300'; // Default
                                    if($room->status === 'available') $statusClass = 'bg-green-100 text-green-800 border border-green-300';
                                    elseif(in_array($room->status, ['occupied', 'checked_in'])) $statusClass = 'bg-red-100 text-red-800 border border-red-300';
                                    elseif($room->status === 'maintenance') $statusClass = 'bg-yellow-100 text-yellow-800 border border-yellow-300';
                                    elseif($room->status === 'cleaning') $statusClass = 'bg-blue-100 text-blue-800 border border-blue-300';
                                    elseif(in_array($room->status, ['on_hold', 'booked_pending_payment'])) $statusClass = 'bg-orange-100 text-orange-800 border border-orange-300';
                                @endphp
                                <span class="px-2.5 py-1 inline-flex text-xs leading-4 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $room->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-semibold">Rp {{ number_format($room->roomType->base_price ?? 0, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $room->floor ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    {{-- PERBAIKAN PADA KOMENTAR AKSI --}}
                                    {{-- Pastikan route 'admin.rooms.edit' dan 'admin.rooms.destroy' sudah Anda buat jika ingin mengaktifkan tombol ini --}}
                                    
                                    {{-- Tombol Edit (dikomentari dengan benar) --}}
                                    {{--
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="text-yellow-500 hover:text-yellow-700 p-1 rounded-md hover:bg-yellow-50" title="Edit Kamar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                                    </a>
                                    --}}

                                    {{-- Form Hapus (dikomentari dengan benar) --}}
                                    {{--
                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1 rounded-md hover:bg-red-50" title="Hapus Kamar">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </form>
                                    --}}
                                    <span class="text-xs text-gray-400 italic">Aksi belum aktif</span> {{-- Placeholder jika aksi belum ada --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
             @if($rooms->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $rooms->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    @else
        <div class="text-center py-12 bg-white shadow-lg sm:rounded-lg">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <h3 class="mt-2 text-xl font-medium text-gray-900">Tidak Ada Kamar</h3>
            <p class="mt-1 text-sm text-gray-500">Belum ada data kamar yang ditambahkan atau sesuai filter.</p>
             <div class="mt-6">
                <a href="{{-- route('admin.rooms.create') --}}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 opacity-50 cursor-not-allowed" title="Fitur Tambah Kamar belum diimplementasikan">
                    Tambah Kamar Baru
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
