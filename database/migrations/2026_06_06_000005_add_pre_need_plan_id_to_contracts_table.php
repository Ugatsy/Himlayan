<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->foreignId('pre_need_plan_id')->nullable()->constrained('pre_need_plans')->nullOnDelete()->after('plot_id');
            $table->foreignId('columbary_niche_id')->nullable()->constrained('columbary_niches')->nullOnDelete()->after('pre_need_plan_id');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['pre_need_plan_id']);
            $table->dropForeign(['columbary_niche_id']);
            $table->dropColumn(['pre_need_plan_id', 'columbary_niche_id']);
        });
    }
};
