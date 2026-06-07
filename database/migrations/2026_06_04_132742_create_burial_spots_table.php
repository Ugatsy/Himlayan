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
        Schema::create('burial_spots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('plot_number')->unique();
            $table->string('section')->nullable();
            $table->year('birth_year')->nullable();
            $table->year('death_year')->nullable();
            $table->enum('status', ['occupied', 'reserved', 'available'])->default('available');
            $table->text('notes')->nullable();
            $table->decimal('map_x', 8, 2)->default(0);
            $table->decimal('map_y', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('burial_spots');
    }
};
