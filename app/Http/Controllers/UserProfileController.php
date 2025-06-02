<?php

namespace App\Http\Controllers;

use App\Models\User; // Import model User Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     */
    public function show()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('profile', [
            'user' => $user,
        ]);
    }

    /**
     * Mengupdate informasi profil pengguna.
     */
    public function updateInformation(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validateWithBag('updateProfileInformation', [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->forceFill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Informasi profil berhasil diperbarui.');
    }

    /**
     * Mengupdate password pengguna.
     */
    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $user->forceFill([
            'password' => Hash::make($validatedData['password']),
        ]);
        $user->save(); // Dipisahkan dari forceFill untuk kejelasan

        // Auth::logoutOtherDevices($request->password); // Pertimbangkan untuk logout dari device lain

        return redirect()->route('profile.show')->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
