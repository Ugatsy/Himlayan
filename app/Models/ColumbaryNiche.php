<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'niche_number', 'section', 'row', 'tier',
    'status', 'price', 'map_x', 'map_y', 'notes',
])]
class ColumbaryNiche extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'price' => 'float',
            'map_x' => 'float',
            'map_y' => 'float',
            'tier' => 'integer',
        ];
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}
