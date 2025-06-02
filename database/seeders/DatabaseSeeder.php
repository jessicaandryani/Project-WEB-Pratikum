<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            ServiceSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
