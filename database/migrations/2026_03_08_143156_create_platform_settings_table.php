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
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id(); // [cite: 258]
            $table->string('key', 100)->unique(); // [cite: 259, 263]
            $table->text('value')->nullable(); // [cite: 260, 264]
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // [cite: 265]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
    }
};
