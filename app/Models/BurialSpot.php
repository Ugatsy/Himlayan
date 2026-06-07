<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BurialSpot extends Model
{
    protected $fillable = [
        'name',
        'plot_number',
        'section',
        'birth_year',
        'death_year',
        'status',
        'notes',
        'map_x',
        'map_y',
    ];

    protected $casts = [
        'map_x' => 'float',
        'map_y' => 'float',
    ];
}
