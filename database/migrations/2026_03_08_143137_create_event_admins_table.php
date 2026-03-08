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
        Schema::create('event_admins', function (Blueprint $table) {
            $table->id(); // [cite: 214]
            $table->string('name', 150); // [cite: 215, 222]
            $table->string('email', 150)->unique(); // [cite: 216, 223]
            $table->string('password'); // [cite: 217, 224]
            $table->foreignId('event_id')->nullable()->constrained('events')->nullOnDelete(); // [cite: 218, 236]
            $table->enum('role', ['event_admin', 'viewer'])->default('event_admin'); // [cite: 219, 226, 230]
            $table->boolean('is_active')->default(true); // [cite: 220, 227]
            $table->dateTime('last_login')->nullable(); // [cite: 232]
            $table->timestamps(); // [cite: 233, 234]

            $table->index('event_id'); // [cite: 235]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_admins');
    }
};
