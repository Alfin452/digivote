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
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // [cite: 95]
            $table->string('slug', 120)->unique(); // [cite: 100]
            $table->string('name'); // [cite: 101]
            $table->string('org'); // [cite: 103]
            $table->text('description')->nullable(); // [cite: 106]
            $table->string('icon', 10)->default(''); // [cite: 108]
            $table->unsignedInteger('price_per_vote')->default(2000); // [cite: 109]
            $table->unsignedTinyInteger('min_vote')->default(1); // [cite: 111]
            $table->enum('status', ['draft', 'soon', 'live', 'done'])->default('draft'); // [cite: 112]
            $table->dateTime('started_at')->nullable(); // [cite: 114, 115]
            $table->dateTime('ended_at')->nullable(); // [cite: 116]
            $table->unsignedTinyInteger('fee_percent')->default(5); // [cite: 120, 123]
            $table->timestamps(); // [cite: 121, 122]

            // Indexes untuk optimasi query [cite: 126, 127]
            $table->index('status');
            $table->index('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
