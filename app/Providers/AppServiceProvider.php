<?php

namespace App\Providers;

use App\Models\Burial;
use App\Models\Contract;
use App\Models\Payment;
use App\Models\Plot;
use App\Observers\BurialObserver;
use App\Observers\ContractObserver;
use App\Observers\PaymentObserver;
use App\Observers\PlotObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Plot::observe(PlotObserver::class);
        Burial::observe(BurialObserver::class);
        Payment::observe(PaymentObserver::class);
        Contract::observe(ContractObserver::class);
    }
}
