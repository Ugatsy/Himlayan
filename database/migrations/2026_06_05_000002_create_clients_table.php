<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('contact_number', 20);
            $table->string('email')->nullable();
            $table->text('address');
            $table->string('id_number', 100);
            $table->string('id_type', 50)->comment('e.g. PhilSys, Passport, UMID');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
