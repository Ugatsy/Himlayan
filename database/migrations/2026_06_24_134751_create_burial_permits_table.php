<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('burial_permits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained()->onDelete('restrict');
            $table->string('permit_number', 50)->unique();
            $table->string('deceased_name', 255);
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death');
            $table->string('death_certificate_number', 100)->nullable();
            $table->decimal('burial_permit_fee', 10, 2)->default(0);
            $table->foreignId('issued_by')->constrained('users');
            $table->timestamp('issued_at')->nullable();
            $table->enum('status', ['issued', 'used', 'cancelled'])->default('issued');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('burial_permits');
    }
};
