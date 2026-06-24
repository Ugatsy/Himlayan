<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'full_name', 'contact_number', 'email',
    'address', 'id_number', 'id_type',
])]
class Client extends Model
{
    use HasFactory, Notifiable;

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function routeNotificationForMail(): ?string
    {
        return $this->email;
    }

    public function routeNotificationForSms(): ?string
    {
        return $this->contact_number;
    }
}
