<?php

namespace App\Console\Commands;

use App\Models\Burial;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendBurialReminders extends Command
{
    protected $signature = 'reminders:burial';
    protected $description = 'Send notifications for burials scheduled tomorrow';

    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        Burial::whereDate('burial_date', $tomorrow)
            ->where('burial_status', 'scheduled')
            ->with('scheduledBy')
            ->each(function ($burial) {
                if ($burial->scheduledBy) {
                    Notification::create([
                        'user_id' => $burial->scheduledBy->id,
                        'title'   => 'Burial Tomorrow',
                        'body'    => "{$burial->deceased_name} — {$burial->burial_date->format('M d, Y g:i A')} — Plot {$burial->plot->plot_number}",
                        'type'    => 'burial_reminder',
                        'link'    => "/burials/{$burial->id}",
                    ]);
                }
            });

        $this->info('Burial reminders sent.');
    }
}
