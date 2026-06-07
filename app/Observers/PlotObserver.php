<?php

namespace App\Observers;

use App\Models\Plot;
use App\Models\ActivityLog;

class PlotObserver
{
    public function created(Plot $plot): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'plot',
            'description'  => "Created plot {$plot->plot_number}",
            'subject_type' => Plot::class,
            'subject_id'   => $plot->id,
        ]);
    }

    public function updated(Plot $plot): void
    {
        if ($plot->isDirty('lat') || $plot->isDirty('lng')) return;

        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'plot',
            'description'  => "Updated plot {$plot->plot_number}",
            'subject_type' => Plot::class,
            'subject_id'   => $plot->id,
            'properties'   => json_encode(['old' => $plot->getOriginal(), 'new' => $plot->getChanges()]),
        ]);
    }

    public function deleted(Plot $plot): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'plot',
            'description'  => "Deleted plot {$plot->plot_number}",
            'subject_type' => Plot::class,
            'subject_id'   => $plot->id,
        ]);
    }
}
