<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Food Services
            [
                'name' => 'Sarapan Prasmanan',
                'description' => 'Sarapan prasmanan dengan menu internasional dan lokal yang lezat',
                'price' => 150000,
                'category' => 'food',
                'is_active' => true,
                'image' => 'breakfast-buffet.jpg'
            ],
            [
                'name' => 'Room Service - Makan Siang',
                'description' => 'Layanan makan siang langsung ke kamar dengan menu pilihan chef',
                'price' => 200000,
                'category' => 'food',
                'is_active' => true,
                'image' => 'lunch-service.jpg'
            ],
            [
                'name' => 'Makan Malam Romantis',
                'description' => 'Makan malam romantis di balkon dengan pemandangan kota',
                'price' => 500000,
                'category' => 'food',
                'is_active' => true,
                'image' => 'romantic-dinner.jpg'
            ],

            // Spa Services
            [
                'name' => 'Pijat Relaksasi',
                'description' => 'Pijat relaksasi selama 60 menit untuk menghilangkan stress',
                'price' => 300000,
                'category' => 'spa',
                'is_active' => true,
                'image' => 'relaxation-massage.jpg'
            ],
            [
                'name' => 'Facial Treatment',
                'description' => 'Perawatan wajah premium dengan produk organik',
                'price' => 250000,
                'category' => 'spa',
                'is_active' => true,
                'image' => 'facial-treatment.jpg'
            ],
            [
                'name' => 'Couple Spa Package',
                'description' => 'Paket spa untuk pasangan dengan pijat dan perawatan lengkap',
                'price' => 800000,
                'category' => 'spa',
                'is_active' => true,
                'image' => 'couple-spa.jpg'
            ],

            // Laundry Services
            [
                'name' => 'Laundry Express',
                'description' => 'Layanan laundry cepat dalam 4 jam',
                'price' => 50000,
                'category' => 'laundry',
                'is_active' => true,
                'image' => 'express-laundry.jpg'
            ],
            [
                'name' => 'Dry Cleaning',
                'description' => 'Layanan dry cleaning untuk pakaian formal',
                'price' => 75000,
                'category' => 'laundry',
                'is_active' => true,
                'image' => 'dry-cleaning.jpg'
            ],

            // Transport Services
            [
                'name' => 'Airport Transfer',
                'description' => 'Layanan antar jemput bandara dengan mobil mewah',
                'price' => 400000,
                'category' => 'transport',
                'is_active' => true,
                'image' => 'airport-transfer.jpg'
            ],
            [
                'name' => 'City Tour',
                'description' => 'Tur keliling kota dengan guide profesional',
                'price' => 600000,
                'category' => 'transport',
                'is_active' => true,
                'image' => 'city-tour.jpg'
            ],

            // Other Services
            [
                'name' => 'Baby Sitting',
                'description' => 'Layanan pengasuhan anak profesional',
                'price' => 100000,
                'category' => 'other',
                'is_active' => true,
                'image' => 'baby-sitting.jpg'
            ],
            [
                'name' => 'Meeting Room',
                'description' => 'Sewa ruang meeting dengan fasilitas lengkap',
                'price' => 500000,
                'category' => 'other',
                'is_active' => true,
                'image' => 'meeting-room.jpg'
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
