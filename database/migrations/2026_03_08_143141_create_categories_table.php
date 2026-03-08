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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // [cite: 131]
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete(); // [cite: 133, 139]
            $table->string('name', 100); // [cite: 134, 135]
            $table->unsignedTinyInteger('sort_order')->default(0); // [cite: 136]
            $table->timestamp('created_at')->useCurrent(); // [cite: 137]

            $table->index('event_id'); // [cite: 138]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
