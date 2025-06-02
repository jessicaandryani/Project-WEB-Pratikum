<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Standard, Deluxe, Suite, etc.
            $table->text('description');
            $table->decimal('base_price', 10, 2);
            $table->integer('max_occupancy');
            $table->json('amenities')->nullable(); // TV, AC, WiFi, etc.
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
