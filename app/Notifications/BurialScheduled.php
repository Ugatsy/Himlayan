<?php

namespace App\Notifications;

use App\Models\Burial;
use App\Models\SentClientNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BurialScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Burial $burial) {}

    public function via(object $notifiable): array
    {
        $channels = ['database'];
        if ($notifiable->email) $channels[] = 'mail';
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Burial Scheduled — HIMLAYAN')
            ->greeting('Dear ' . $notifiable->full_name . ',')
            ->line('A burial has been scheduled for:')
            ->line('**Deceased:** ' . $this->burial->deceased_name)
            ->line('**Date:** ' . $this->burial->burial_date->format('M d, Y g:i A'))
            ->line('**Plot:** ' . ($this->burial->plot?->plot_number ?? 'N/A'))
            ->line('**Status:** ' . ucfirst($this->burial->burial_status))
            ->action('View Details', url('/burials/' . $this->burial->id))
            ->line('Please arrive on time. Bring the Burial Permit (AF 58).');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'burial_id' => $this->burial->id,
            'deceased_name' => $this->burial->deceased_name,
            'burial_date' => $this->burial->burial_date->toDateTimeString(),
            'type' => 'burial_scheduled',
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        $data = $this->toArray($notifiable);
        SentClientNotification::create([
            'client_id' => $notifiable->id,
            'type' => 'burial_scheduled',
            'channel' => 'database',
            'subject' => 'Burial Scheduled: ' . $this->burial->deceased_name,
            'body' => 'Burial for ' . $this->burial->deceased_name
                . ' scheduled on ' . $this->burial->burial_date->format('M d, Y g:i A')
                . ' at plot ' . ($this->burial->plot?->plot_number ?? 'N/A'),
            'reference_type' => 'burial',
            'reference_id' => $this->burial->id,
            'status' => 'sent',
        ]);
        return $data;
    }
}
