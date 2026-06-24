<?php

namespace App\Notifications;

use App\Models\BurialPermit;
use App\Models\SentClientNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BurialPermitIssued extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public BurialPermit $permit) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        if ($notifiable->email) $channels[] = 'mail';
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $contract = $this->permit->contract;
        return (new MailMessage)
            ->subject('Burial Permit (AF 58) Issued — HIMLAYAN')
            ->greeting('Dear ' . $notifiable->full_name . ',')
            ->line('A Burial Permit (AF 58) has been issued for:')
            ->line('**Deceased:** ' . $this->permit->deceased_name)
            ->line('**Permit #:** ' . $this->permit->permit_number)
            ->line('**Date of Death:** ' . $this->permit->date_of_death->format('M d, Y'))
            ->line('**Plot:** ' . ($contract->plot?->plot_number ?? 'N/A'))
            ->action('View Permit', url('/burial-permits/' . $this->permit->id))
            ->line('Please keep this permit with you for the interment.');

    }

    public function toArray(object $notifiable): array
    {
        return [
            'permit_id' => $this->permit->id,
            'permit_number' => $this->permit->permit_number,
            'deceased_name' => $this->permit->deceased_name,
            'type' => 'burial_permit_issued',
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        $data = $this->toArray($notifiable);
        SentClientNotification::create([
            'client_id' => $notifiable->id,
            'type' => 'burial_permit_issued',
            'channel' => 'database',
            'subject' => 'Burial Permit Issued: ' . $this->permit->permit_number,
            'body' => 'Burial Permit (AF 58) issued for ' . $this->permit->deceased_name
                . ' — Permit #: ' . $this->permit->permit_number,
            'reference_type' => 'burial_permit',
            'reference_id' => $this->permit->id,
            'status' => 'sent',
        ]);
        return $data;
    }
}
