<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SentClientNotification extends Model
{
    protected $fillable = [
        'client_id', 'type', 'channel', 'subject', 'body',
        'reference_type', 'reference_id', 'status', 'response',
    ];

    protected $table = 'sent_client_notifications';

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
