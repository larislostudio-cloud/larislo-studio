<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('price');
            $table->integer('duration_days')->default(30);
            $table->integer('ai_credits_limit');
            $table->boolean('scheduler_enabled')->default(false);
            $table->json('features')->nullable();
            $table->timestamps();
        });

        // PENTING: Jangan ada kode Schema::table('users') di sini!
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
