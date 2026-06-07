<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\ActivityLog;

class ContractObserver
{
    public function created(Contract $contract): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'contract',
            'description'  => "Created contract #{$contract->id} for {$contract->client->full_name} — plot {$contract->plot->plot_number}",
            'subject_type' => Contract::class,
            'subject_id'   => $contract->id,
        ]);
    }

    public function updated(Contract $contract): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'contract',
            'description'  => "Updated contract #{$contract->id}",
            'subject_type' => Contract::class,
            'subject_id'   => $contract->id,
            'properties'   => json_encode(['old' => $contract->getOriginal(), 'new' => $contract->getChanges()]),
        ]);
    }

    public function deleted(Contract $contract): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'contract',
            'description'  => "Deleted contract #{$contract->id}",
            'subject_type' => Contract::class,
            'subject_id'   => $contract->id,
        ]);
    }
}
