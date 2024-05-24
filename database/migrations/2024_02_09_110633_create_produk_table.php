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
        Schema::create('produk_table', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('jumlah');
            $table->string('detail');
            $table->unsignedBigInteger('pedagang'); // Kolom kunci asing baru
            $table->timestamps();

            // Menambahkan kunci asing dengan aturan CASCADE
            $table->foreign('pedagang')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_table');
    }



    /**
     * Reverse the migrations.
     */
    public function upload(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->after('remember_token');
        });
    }
};
