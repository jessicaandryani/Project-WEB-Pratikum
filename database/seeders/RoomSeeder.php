<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $roomTypes = RoomType::all();
        
        // Standard Rooms (Lantai 2-4)
        $standardType = $roomTypes->where('name', 'Kamar Standard')->first();
        for ($floor = 2; $floor <= 4; $floor++) {
            for ($room = 1; $room <= 10; $room++) {
                Room::create([
                    'room_number' => $floor . str_pad($room, 2, '0', STR_PAD_LEFT),
                    'room_type_id' => $standardType->id,
                    'status' => $this->getRandomStatus(),
                    'floor' => $floor,
                    'notes' => null
                ]);
            }
        }

        // Deluxe Rooms (Lantai 5-7)
        $deluxeType = $roomTypes->where('name', 'Kamar Deluxe')->first();
        for ($floor = 5; $floor <= 7; $floor++) {
            for ($room = 1; $room <= 8; $room++) {
                Room::create([
                    'room_number' => $floor . str_pad($room, 2, '0', STR_PAD_LEFT),
                    'room_type_id' => $deluxeType->id,
                    'status' => $this->getRandomStatus(),
                    'floor' => $floor,
                    'notes' => null
                ]);
            }
        }

        // Presidential Suites (Lantai 8-10)
        $suiteType = $roomTypes->where('name', 'Suite Presidensial')->first();
        for ($floor = 8; $floor <= 10; $floor++) {
            for ($room = 1; $room <= 4; $room++) {
                Room::create([
                    'room_number' => $floor . str_pad($room, 2, '0', STR_PAD_LEFT),
                    'room_type_id' => $suiteType->id,
                    'status' => $this->getRandomStatus(),
                    'floor' => $floor,
                    'notes' => null
                ]);
            }
        }
    }

    private function getRandomStatus(): string
    {
        $statuses = ['available', 'occupied', 'maintenance', 'cleaning'];
        $weights = [70, 15, 10, 5]; // 70% available, 15% occupied, etc.
        
        $random = rand(1, 100);
        $cumulative = 0;
        
        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $statuses[$index];
            }
        }
        
        return 'available';
    }
}
