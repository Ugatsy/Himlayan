<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->string('plot_number', 50)->unique();
            $table->string('section', 100)->nullable();
            $table->decimal('lat', 10, 8)->default(0);
            $table->decimal('lng', 11, 8)->default(0);
            $table->tinyInteger('capacity')->unsigned()->default(1);
            $table->tinyInteger('current_occupants')->unsigned()->default(0);
            $table->enum('status', ['available', 'reserved', 'occupied', 'full'])->default('available');
            $table->decimal('price', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};
