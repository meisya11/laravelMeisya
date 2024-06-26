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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->unsignedBigInteger('pedagang_id')->nullable();
            $table->foreign('pedagang_id')->references('id')->on('users')->onDelete('set null');
            $table->json('lokasi');
            $table->string('alamat');
            $table->enum('status',['waiting', 'taken'])->default('waiting');
            $table->datetime('order_time')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
