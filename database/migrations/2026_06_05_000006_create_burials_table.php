<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('burials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plot_id')->constrained()->onDelete('restrict');
            $table->foreignId('contract_id')->constrained()->onDelete('restrict');
            $table->string('deceased_name');
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death');
            $table->dateTime('burial_date');
            $table->enum('burial_status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->foreignId('scheduled_by')->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE burials ADD FULLTEXT INDEX ft_deceased_name (deceased_name)');
    }

    public function down(): void
    {
        Schema::dropIfExists('burials');
    }
};
