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
        Schema::create('smoothings', function (Blueprint $table) {
            $table->id();
            $table->string('kd_provinsi', 20);
            $table->string('tahun', 16);
            $table->decimal('produksi', 10, 2)->nullable();
            $table->decimal('prediksi', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smoothings');
    }
};
