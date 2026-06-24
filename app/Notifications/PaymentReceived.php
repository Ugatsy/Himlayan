<?php

namespace App\Notifications;

use App\Models\Payment;
use App\Models\SentClientNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Payment $payment) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        if ($notifiable->email) $channels[] = 'mail';
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Received — HIMLAYAN')
            ->greeting('Dear ' . $notifiable->full_name . ',')
            ->line('We have received your payment:')
            ->line('**Amount:** ₱' . number_format($this->payment->amount_paid, 2))
            ->line('**Receipt #:** ' . ($this->payment->receipt_number ?? 'N/A'))
            ->line('**Date:** ' . $this->payment->paid_at->format('M d, Y g:i A'))
            ->line('**Contract #:** ' . $this->payment->contract_id)
            ->action('View Payment', url('/payments/' . $this->payment->id))
            ->line('Thank you for your payment.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'payment_id' => $this->payment->id,
            'amount' => $this->payment->amount_paid,
            'receipt_number' => $this->payment->receipt_number,
            'type' => 'payment_received',
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        $data = $this->toArray($notifiable);
        SentClientNotification::create([
            'client_id' => $notifiable->id,
            'type' => 'payment_received',
            'channel' => 'database',
            'subject' => 'Payment Received: ₱' . number_format($this->payment->amount_paid, 2),
            'body' => 'Payment of ₱' . number_format($this->payment->amount_paid, 2)
                . ' received — Receipt #: ' . ($this->payment->receipt_number ?? 'N/A'),
            'reference_type' => 'payment',
            'reference_id' => $this->payment->id,
            'status' => 'sent',
        ]);
        return $data;
    }
}
