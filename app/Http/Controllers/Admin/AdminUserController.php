<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Pastikan model User diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk hashing password
use Illuminate\Validation\Rule; // Untuk validasi unik
use Illuminate\Validation\Rules\Password; // Untuk aturan validasi password
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna.
     */
    public function index(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');

        // Filter berdasarkan peran
        if ($request->filled('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter berdasarkan pencarian nama atau email
        if ($request->filled('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }
        
        // Filter berdasarkan status aktif
        if ($request->has('is_active') && $request->is_active !== '') {
             $query->where('is_active', (bool)$request->is_active);
        }


        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     * Anda perlu membuat view: resources/views/admin/users/create.blade.php
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'], // Aturan password yang kuat
            'role' => ['required', 'string', Rule::in(['admin', 'user'])], // Pastikan role valid
            'is_active' => ['required', 'boolean'],
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
            'is_active' => $validatedData['is_active'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail pengguna (opsional, jika diperlukan).
     * Anda perlu membuat view: resources/views/admin/users/show.blade.php
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Menampilkan form untuk mengedit pengguna.
     * Anda perlu membuat view: resources/views/admin/users/edit.blade.php
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Mengupdate data pengguna di database.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'role' => ['required', 'string', Rule::in(['admin', 'user'])],
            'is_active' => ['required', 'boolean'],
            // Password opsional saat update
            'password' => ['nullable', 'string', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->address = $validatedData['address'];
        $user->role = $validatedData['role'];
        $user->is_active = $validatedData['is_active'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus pengguna dari database.
     * Pertimbangkan "soft delete" atau menonaktifkan pengguna daripada menghapus permanen.
     */
    public function destroy(User $user)
    {
        // Jangan biarkan admin menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        
        // Pertimbangkan untuk tidak menghapus admin utama atau user dengan role tertentu
        // if ($user->role === 'super_admin') {
        //     return redirect()->route('admin.users.index')->with('error', 'Super admin tidak dapat dihapus.');
        // }

        // Jika menggunakan Soft Deletes, gunakan $user->delete();
        // Jika ingin menonaktifkan:
        // $user->is_active = false;
        // $user->save();
        // return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dinonaktifkan.');

        // Menghapus permanen:
        try {
            $user->delete();
            return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error jika ada foreign key constraint, misal user punya booking
            return redirect()->route('admin.users.index')->with('error', 'Gagal menghapus pengguna. Mungkin pengguna ini memiliki data terkait (misalnya booking). Nonaktifkan pengguna sebagai alternatif.');
        }
    }
}
