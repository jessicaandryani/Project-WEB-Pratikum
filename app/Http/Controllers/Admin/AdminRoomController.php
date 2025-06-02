<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room; // Pastikan model Room diimport
use App\Models\RoomType; // Import RoomType untuk filter
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{
    /**
     * Menampilkan daftar semua kamar.
     */
    public function index(Request $request)
    {
        $query = Room::with('roomType')->orderBy('room_number', 'asc');

        if ($request->filled('status') && $request->status != '') { // Tambahkan pengecekan
            $query->where('status', $request->status);
        }
        if ($request->filled('room_type_id') && $request->room_type_id != '') { // Tambahkan pengecekan
            $query->where('room_type_id', $request->room_type_id);
        }
        // Tambahkan pencarian berdasarkan nomor kamar jika perlu
        if ($request->filled('search_room_number') && $request->search_room_number != '') { // Tambahkan pengecekan
            $query->where('room_number', 'like', '%' . $request->search_room_number . '%');
        }

        $rooms = $query->paginate(15)->withQueryString();
        $roomTypes = RoomType::orderBy('name')->get(); // Untuk filter

        return view('admin.rooms.index', compact('rooms', 'roomTypes'));
    }

    // Method lain (create, store, edit, update, destroy) untuk kamar dan tipe kamar
    // akan ditambahkan di sini.
}
