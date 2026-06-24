<?php

namespace App\Notifications;

use App\Models\InstallmentSchedule;
use App\Models\SentClientNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstallmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public InstallmentSchedule $installment) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        if ($notifiable->email) $channels[] = 'mail';
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $contract = $this->installment->contract;
        return (new MailMessage)
            ->subject('Installment Payment Reminder — HIMLAYAN')
            ->greeting('Dear ' . $notifiable->full_name . ',')
            ->line('This is a reminder for your upcoming installment payment:')
            ->line('**Amount Due:** ₱' . number_format($this->installment->amount_due, 2))
            ->line('**Due Date:** ' . $this->installment->due_date->format('M d, Y'))
            ->line('**Contract #:** ' . $this->installment->contract_id)
            ->line('**Plot:** ' . ($contract->plot?->plot_number ?? 'N/A'))
            ->action('View Contract', url('/contracts/' . $this->installment->contract_id))
            ->line('Please settle your payment on or before the due date.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'installment_id' => $this->installment->id,
            'amount_due' => $this->installment->amount_due,
            'due_date' => $this->installment->due_date->toDateString(),
            'type' => 'installment_reminder',
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        $data = $this->toArray($notifiable);
        SentClientNotification::create([
            'client_id' => $notifiable->id,
            'type' => 'installment_reminder',
            'channel' => 'database',
            'subject' => 'Installment Due: ₱' . number_format($this->installment->amount_due, 2),
            'body' => 'Installment payment of ₱' . number_format($this->installment->amount_due, 2)
                . ' due on ' . $this->installment->due_date->format('M d, Y'),
            'reference_type' => 'installment',
            'reference_id' => $this->installment->id,
            'status' => 'sent',
        ]);
        return $data;
    }
}
