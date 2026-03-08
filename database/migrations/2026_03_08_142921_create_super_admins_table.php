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
        Schema::create('super_admins', function (Blueprint $table) {
            $table->id(); // [cite: 242]
            $table->string('name', 150); // [cite: 248]
            $table->string('email', 150)->unique(); // [cite: 249]
            $table->string('password'); // [cite: 250]
            $table->boolean('is_active')->default(true); // [cite: 251]
            $table->timestamps(); // [cite: 252, 254]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_admins');
    }
};
