<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $rooms = Room::where('status', 'occupied')->get();

        // Buat beberapa booking sample
        $bookings = [
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->subDays(2),
                'check_out_date' => Carbon::now()->addDays(3),
                'adults' => 2,
                'children' => 0,
                'status' => 'confirmed',
                'special_requests' => 'Kamar dengan pemandangan kota',
                'confirmed_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->addDays(5),
                'check_out_date' => Carbon::now()->addDays(8),
                'adults' => 1,
                'children' => 1,
                'status' => 'pending',
                'special_requests' => 'Extra bed untuk anak',
                'confirmed_at' => null,
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now()->subDays(5),
                'check_out_date' => Carbon::now()->subDays(2),
                'adults' => 2,
                'children' => 0,
                'status' => 'checked_out',
                'special_requests' => null,
                'confirmed_at' => Carbon::now()->subDays(6),
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->random()->id,
                'check_in_date' => Carbon::now(),
                'check_out_date' => Carbon::now()->addDays(2),
                'adults' => 3,
                'children' => 1,
                'status' => 'checked_in',
                'special_requests' => 'Late check-out',
                'confirmed_at' => Carbon::now()->subDays(3),
            ]
        ];

        foreach ($bookings as $bookingData) {
            $room = Room::find($bookingData['room_id']);
            $nights = Carbon::parse($bookingData['check_out_date'])->diffInDays(Carbon::parse($bookingData['check_in_date']));
            $totalAmount = $room->roomType->base_price * $nights;

            $booking = Booking::create(array_merge($bookingData, [
                'nights' => $nights,
                'total_amount' => $totalAmount,
            ]));

            // Buat payment untuk booking yang confirmed atau checked_out
            if (in_array($booking->status, ['confirmed', 'checked_out', 'checked_in'])) {
                Payment::create([
                    'booking_id' => $booking->id,
                    'payment_method' => 'bank_transfer',
                    'amount' => $totalAmount,
                    'status' => 'completed',
                    'transaction_id' => 'TXN' . strtoupper(uniqid()),
                    'payment_details' => [
                        'bank' => 'BCA',
                        'account_number' => '1234567890',
                        'account_name' => 'Hotel Del Luna'
                    ],
                    'paid_at' => $booking->confirmed_at,
                ]);
            }
        }
    }
}
