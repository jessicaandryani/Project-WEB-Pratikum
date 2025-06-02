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
            // Mengubah kolom payment_method menjadi nullable
            // Pastikan nama kolom 'payment_method' sudah benar sesuai dengan tabel Anda
            $table->string('payment_method')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Mengembalikan kolom payment_method menjadi not nullable jika di-rollback
            // Hati-hati jika sudah ada data NULL di kolom ini saat menjalankan down(),
            // Anda mungkin perlu menangani data tersebut terlebih dahulu atau memastikan kolomnya bisa kembali ke not nullable.
            // Untuk amannya, Anda bisa membiarkan ini kosong jika tidak yakin,
            // atau pastikan tidak ada data NULL jika ingin mengembalikan ke not nullable.
            // $table->string('payment_method')->nullable(false)->change();
        });
    }
};
