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
        Schema::create('credit_packages', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g., "Paket Hemat", "Paket Bisnis"
        $table->integer('credits'); // Jumlah kredit
        $table->integer('price'); // Harga dalam Rupiah
        $table->integer('bonus')->default(0); // Kredit bonus
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_packages');
    }
};
