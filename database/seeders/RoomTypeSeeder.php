<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    public function run(): void
    {
        $roomTypes = [
            [
                'name' => 'Kamar Standard',
                'description' => 'Kamar yang nyaman dan elegan dengan fasilitas modern. Dilengkapi dengan tempat tidur queen size, AC, TV LED 32", WiFi gratis, dan kamar mandi pribadi dengan shower.',
                'base_price' => 800000,
                'max_occupancy' => 2,
                'amenities' => [
                    'AC', 'TV LED 32"', 'WiFi Gratis', 'Kamar Mandi Pribadi', 
                    'Shower', 'Handuk', 'Sabun & Shampoo', 'Hair Dryer',
                    'Meja Kerja', 'Lemari Pakaian'
                ],
                'image' => 'standard-room.jpg'
            ],
            [
                'name' => 'Kamar Deluxe',
                'description' => 'Kamar luas dengan perabotan premium dan pemandangan kota. Dilengkapi dengan tempat tidur king size, sofa, balkon pribadi, dan fasilitas premium lainnya.',
                'base_price' => 1200000,
                'max_occupancy' => 3,
                'amenities' => [
                    'AC', 'TV LED 43"', 'WiFi Gratis', 'Kamar Mandi Mewah', 
                    'Bathtub', 'Balkon Pribadi', 'Mini Bar', 'Coffee Maker',
                    'Sofa', 'Meja Kerja', 'Safe Box', 'Pemandangan Kota'
                ],
                'image' => 'deluxe-room.jpg'
            ],
            [
                'name' => 'Suite Presidensial',
                'description' => 'Kemewahan tertinggi dengan ruang tamu terpisah dan pemandangan panorama kota. Suite mewah dengan fasilitas lengkap untuk pengalaman tak terlupakan.',
                'base_price' => 2500000,
                'max_occupancy' => 4,
                'amenities' => [
                    'AC', 'TV LED 55"', 'WiFi Premium', 'Ruang Tamu Terpisah', 
                    'Jacuzzi', 'Balkon Luas', 'Mini Bar Premium', 'Kitchen Set',
                    'Dining Table', 'Living Room', 'Master Bedroom', 'Guest Bedroom',
                    'Safe Box', 'Pemandangan Panorama', 'Butler Service'
                ],
                'image' => 'presidential-suite.jpg'
            ]
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}
