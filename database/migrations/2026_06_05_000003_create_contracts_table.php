<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('restrict');
            $table->foreignId('plot_id')->constrained()->onDelete('restrict');
            $table->date('contract_date');
            $table->decimal('total_amount', 10, 2);
            $table->enum('payment_type', ['cash', 'credit_card', 'installment']);
            $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
