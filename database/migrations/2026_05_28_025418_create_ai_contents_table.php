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
        Schema::create('ai_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['caption', 'image', 'video', 'voice']);
            $table->string('status')->default('draft'); // draft, rendering, completed, failed (Dari alter)
            $table->text('prompt'); // Input user
            $table->longText('project_data'); // Output AI / Timeline JSON (Diubah dari result)
            $table->string('output_url')->nullable(); // URL video hasil render (Dari alter)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_contents');
    }
};
