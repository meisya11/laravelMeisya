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
        Schema::create('produk_tables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('jumlah');
            $table->string('detail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_tables');
    }
    public function upload(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->after('remember_token');
        });
    }
};
