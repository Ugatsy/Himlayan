<?php

namespace App\Console\Commands;

use App\Models\InstallmentSchedule;
use App\Models\Notification;
use App\Notifications\InstallmentReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendInstallmentReminders extends Command
{
    protected $signature = 'reminders:installment';
    protected $description = 'Send notifications for installment payments due in 3 days';

    public function handle(): void
    {
        $threeDaysFromNow = Carbon::now()->addDays(3)->toDateString();

        InstallmentSchedule::whereDate('due_date', $threeDaysFromNow)
            ->where('status', 'unpaid')
            ->with('contract.client')
            ->each(function ($schedule) {
                Notification::create([
                    'user_id' => $schedule->contract->client_id,
                    'title'   => 'Installment Due Soon',
                    'body'    => "Installment of ₱{$schedule->amount_due} due on {$schedule->due_date->format('M d, Y')} for contract #{$schedule->contract_id}",
                    'type'    => 'installment_due',
                    'link'    => "/contracts/{$schedule->contract_id}",
                ]);

                if ($schedule->contract->client) {
                    $schedule->contract->client->notify(new InstallmentReminder($schedule));
                }
            });

        $this->info('Installment reminders sent.');
    }
}
