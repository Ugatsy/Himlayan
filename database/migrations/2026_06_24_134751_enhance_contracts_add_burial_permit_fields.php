<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->enum('lot_type', ['individual', 'family'])->nullable()->after('plot_id');
            $table->decimal('lot_area', 8, 2)->nullable()->after('lot_type');
            $table->string('dimension', 100)->nullable()->after('lot_area');
            $table->enum('contract_type', ['new', 'renewal'])->default('new')->after('contract_date');
            $table->date('commencement_date')->nullable()->after('contract_type');
            $table->date('expiration_date')->nullable()->after('commencement_date');
            $table->foreignId('prepared_by')->nullable()->constrained('users')->after('status');
            $table->timestamp('approved_by_treasurer_at')->nullable()->after('prepared_by');
            $table->timestamp('approved_by_mayor_at')->nullable()->after('approved_by_treasurer_at');
            $table->string('af_51_number', 50)->nullable()->after('approved_by_mayor_at');
            $table->date('af_51_date')->nullable()->after('af_51_number');
            $table->string('death_certificate_number', 100)->nullable()->after('af_51_date');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'lot_type', 'lot_area', 'dimension', 'contract_type',
                'commencement_date', 'expiration_date', 'prepared_by',
                'approved_by_treasurer_at', 'approved_by_mayor_at',
                'af_51_number', 'af_51_date', 'death_certificate_number',
            ]);
        });
    }
};
