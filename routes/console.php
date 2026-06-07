<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('reminders:burial', function () {
    $this->call(\App\Console\Commands\SendBurialReminders::class);
})->purpose('Send burial reminders for tomorrow');

Artisan::command('reminders:installment', function () {
    $this->call(\App\Console\Commands\SendInstallmentReminders::class);
})->purpose('Send installment due reminders');
