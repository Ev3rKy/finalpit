<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bill;
use App\Observers\BillObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Bill::observe(BillObserver::class);
    }
}