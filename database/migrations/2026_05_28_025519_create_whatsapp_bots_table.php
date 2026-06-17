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
            Schema::create('whatsapp_bots', function (Blueprint $table) {
                $table->id();
                $table->string('store_name')->nullable();
                $table->foreignId('business_id')->constrained()->cascadeOnDelete();
                $table->string('phone_number');
                $table->string('api_provider')->default('fonnte');
                $table->text('api_key')->nullable();
                $table->string('webhook_url')->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_configured')->default(false);
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_bots');
    }
};
