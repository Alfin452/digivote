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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // [cite: 173]
            $table->string('xendit_id', 100)->unique(); // [cite: 176, 182]
            $table->foreignId('event_id')->constrained('events'); // [cite: 178, 183, 208]
            $table->foreignId('team_id')->constrained('teams'); // [cite: 178, 184, 209]
            $table->string('voter_name', 150)->nullable(); // [cite: 179, 185]
            $table->unsignedTinyInteger('vote_qty')->default(1); // [cite: 180, 186]
            $table->unsignedInteger('amount'); // [cite: 181, 187]
            $table->enum('status', ['pending', 'paid', 'expired', 'failed'])->default('pending'); // [cite: 188, 198]
            $table->dateTime('paid_at')->nullable(); // [cite: 189, 193]
            $table->dateTime('expired_at')->nullable(); // [cite: 190]
            $table->json('xendit_payload')->nullable(); // [cite: 191]
            $table->string('ip_address', 45)->nullable(); // [cite: 192, 194]
            $table->timestamps(); // [cite: 195, 196]

            // Indexes sesuai brief [cite: 204, 205, 206, 207]
            $table->index('xendit_id');
            $table->index(['event_id', 'status']);
            $table->index('team_id');
            $table->index('paid_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
