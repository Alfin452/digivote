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
        Schema::create('teams', function (Blueprint $table) {
            $table->id(); // [cite: 143]
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete(); // [cite: 145, 167]
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete(); // [cite: 145, 169]
            $table->string('number', 5); // [cite: 146, 149]
            $table->string('name'); // [cite: 147, 150]
            $table->string('location')->nullable(); // [cite: 148, 151]
            $table->unsignedTinyInteger('member_count')->default(1); // [cite: 154]

            // Revisi kesepakatan: Menggunakan image_path untuk foto kandidat
            $table->string('image_path')->nullable();

            $table->unsignedInteger('vote_count')->default(0); // [cite: 156]
            $table->timestamp('created_at')->useCurrent(); // [cite: 158]

            // Indexes sesuai brief [cite: 164, 165, 166]
            $table->unique(['event_id', 'number']);
            $table->index(['event_id', 'category_id']);
            $table->index(['event_id', 'vote_count']); // Untuk sorting leaderboard
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
