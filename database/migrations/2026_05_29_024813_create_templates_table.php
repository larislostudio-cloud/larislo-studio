<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pembuat template
            $table->string('title');
            $table->enum('type', ['caption', 'image', 'video', 'prompt']);
            $table->integer('price')->default(0);
            $table->text('description')->nullable();
            $table->string('file_path')->nullable(); // Path file asli (private)
            $table->string('thumbnail')->nullable(); // Gambar preview (public)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
