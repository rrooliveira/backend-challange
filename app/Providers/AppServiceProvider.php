<?php

namespace App\Providers;

use App\Model\Transaction;
use App\Observers\TransactionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        Transaction::observe(TransactionObserver::class);
    }
}
