<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'client_id', 'plot_id', 'pre_need_plan_id', 'columbary_niche_id',
    'contract_date',
    'total_amount', 'payment_type', 'status', 'pdf_path',
])]
class Contract extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'contract_date' => 'date',
            'total_amount' => 'float',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function plot(): BelongsTo
    {
        return $this->belongsTo(Plot::class);
    }

    public function preNeedPlan(): BelongsTo
    {
        return $this->belongsTo(PreNeedPlan::class);
    }

    public function columbaryNiche(): BelongsTo
    {
        return $this->belongsTo(ColumbaryNiche::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function installmentSchedules(): HasMany
    {
        return $this->hasMany(InstallmentSchedule::class);
    }

    public function burials(): HasMany
    {
        return $this->hasMany(Burial::class);
    }
}
