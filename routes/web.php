<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRoomController;


// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes (TANPA MIDDLEWARE 'guest' PADA GRUP INI)
// Route::middleware('guest')->group(function () { // Baris ini diubah/dihapus
// Atau biarkan saja tanpa grup jika hanya ini isinya
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

// }); // Penutup grup middleware('guest') dihapus

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User routes (role: user)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Booking routes for users
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/payments/{booking}/checkout', [PaymentController::class, 'checkout'])->name('payments.checkout');
    Route::post('/payments/{payment}/confirm-user', [PaymentController::class, 'confirmUserPayment'])->name('payments.confirm_user_payment');
    Route::get('/bookings/user/history', [BookingController::class, 'history'])->name('bookings.history');
    Route::get('/bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});

// Admin routes (role: admin)
// Admin routes (role: admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/checkin', [AdminBookingController::class, 'checkIn'])->name('bookings.checkin');
    Route::patch('/bookings/{booking}/checkout', [AdminBookingController::class, 'checkOut'])->name('bookings.checkout');
    Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancelBooking'])->name('bookings.cancel');
    
    // Route untuk menampilkan form edit admin
    Route::get('/bookings/{booking}/edit-form', [AdminBookingController::class, 'editAdmin'])->name('bookings.edit.form'); 
    
    // ROUTE YANG PERLU ANDA PASTIKAN ADA DAN BENAR:
    Route::put('/bookings/{booking}/update-action', [AdminBookingController::class, 'updateAdmin'])->name('bookings.update.action');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create'); // Jika admin bisa buat user baru
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');

    Route::get('/rooms', [AdminRoomController::class, 'index'])->name('rooms.index');

    
    Route::get('/payments/pending-verification', [AdminPaymentController::class, 'listPendingConfirmations'])->name('payments.pending');
    Route::get('/payments/{payment}/verify-detail', [AdminPaymentController::class, 'showVerificationForm'])->name('payments.verify.detail');
    Route::post('/payments/{payment}/confirm-action', [AdminPaymentController::class, 'confirmPaymentAction'])->name('payments.confirmAction');
    Route::post('/payments/{payment}/reject-action', [AdminPaymentController::class, 'rejectPaymentAction'])->name('payments.rejectAction');
});

// Shared authenticated routes (both user and admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile/information', [UserProfileController::class, 'updateInformation'])->name('profile.update.information');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.update.password');
});
