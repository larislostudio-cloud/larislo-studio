<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->cascadeOnDelete();
            $table->string('phone_number');
            $table->text('message');
            $table->enum('direction', ['in', 'out']); // 'in' = masuk, 'out' = balasan sistem
            $table->timestamps();

            $table->index('phone_number'); // Untuk pencarian cepat
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_logs');
    }
};
