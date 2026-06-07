<?php

namespace App\Observers;

use App\Models\Burial;
use App\Models\ActivityLog;

class BurialObserver
{
    public function created(Burial $burial): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'burial',
            'description'  => "Scheduled burial for {$burial->deceased_name} in plot {$burial->plot->plot_number}",
            'subject_type' => Burial::class,
            'subject_id'   => $burial->id,
        ]);
    }

    public function updated(Burial $burial): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'burial',
            'description'  => "Updated burial record for {$burial->deceased_name}",
            'subject_type' => Burial::class,
            'subject_id'   => $burial->id,
            'properties'   => json_encode(['old' => $burial->getOriginal(), 'new' => $burial->getChanges()]),
        ]);
    }

    public function deleted(Burial $burial): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'burial',
            'description'  => "Deleted burial record for {$burial->deceased_name}",
            'subject_type' => Burial::class,
            'subject_id'   => $burial->id,
        ]);
    }
}
