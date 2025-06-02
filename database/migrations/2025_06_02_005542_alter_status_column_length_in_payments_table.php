<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Mengubah kolom 'status' agar memiliki panjang yang cukup.
            // VARCHAR(50) seharusnya cukup untuk berbagai macam status.
            // Jika sebelumnya adalah ENUM, ini akan mengubahnya menjadi VARCHAR.
            $table->string('status', 50)->change(); // Misalnya, panjang 50
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Jika Anda ingin mengembalikan ke kondisi sebelumnya,
            // Anda perlu tahu tipe dan panjang kolom status sebelumnya.
            // Contoh jika sebelumnya VARCHAR(20):
            // $table->string('status', 20)->change();
            // Atau jika sebelumnya ENUM:
            // $table->enum('status', ['pending', 'completed', 'failed'])->change();
            // Berhati-hatilah dengan method down() jika sudah ada data yang
            // tidak sesuai dengan tipe/panjang lama.
            // Untuk amannya, Anda bisa membiarkan method down() kosong
            // atau pastikan data yang ada bisa dikembalikan ke tipe lama.
        });
    }
};
