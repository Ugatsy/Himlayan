<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'full_name', 'contact_number', 'email',
        'address', 'lot_interest', 'message', 'status',
    ];
}
