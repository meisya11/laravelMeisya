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
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->enum('role', ['admin', 'pedagang', 'pembeli'])->default('pembeli');
            $table->string('deskripsi')->nullable();
            $table->time('jam')->nullable();
            $table->time('sampai')->nullable();
            $table->enum('kategori', ['Bahan Mentah', 'Makanan', 'Jasa', 'Perabotan', 'Mainan', 'Minuman', 'Lainnya'])->default('Lainnya');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
