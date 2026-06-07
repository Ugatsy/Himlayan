<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('columbary_niches', function (Blueprint $table) {
            $table->id();
            $table->string('niche_number', 50)->unique();
            $table->string('section', 100)->nullable();
            $table->string('row', 50)->nullable();
            $table->integer('tier')->nullable();
            $table->enum('status', ['available', 'reserved', 'occupied'])->default('available');
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('map_x', 8, 2)->default(0);
            $table->decimal('map_y', 8, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('columbary_niches');
    }
};
