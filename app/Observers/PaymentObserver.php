<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\ActivityLog;

class PaymentObserver
{
    public function created(Payment $payment): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'payment',
            'description'  => "Payment of ₱{$payment->amount_paid} received for contract #{$payment->contract_id}",
            'subject_type' => Payment::class,
            'subject_id'   => $payment->id,
        ]);
    }

    public function deleted(Payment $payment): void
    {
        ActivityLog::create([
            'user_id'      => auth()->id(),
            'type'         => 'payment',
            'description'  => "Payment of ₱{$payment->amount_paid} deleted",
            'subject_type' => Payment::class,
            'subject_id'   => $payment->id,
        ]);
    }
}
