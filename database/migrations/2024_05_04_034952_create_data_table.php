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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('kd_provinsi', 20);
            $table->string('tahun', 16);
            $table->decimal('luas_panen', 10, 2); // Maksimal 2 angka di belakang koma
            $table->decimal('produktivitas', 10, 2);
            $table->decimal('produksi', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
