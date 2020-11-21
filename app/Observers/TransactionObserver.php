<?php

namespace App\Observers;

use App\Jobs\EmailTransactionJob;
use App\Mail\TesteEmail;
use App\Model\Transaction;
use Illuminate\Support\Facades\Mail;

class TransactionObserver
{
    public function created(Transaction $transaction)
    {
        EmailTransactionJob::dispatch($transaction->value, $transaction->payer, $transaction->payee);
    }

    public function updated(Transaction $transaction)
    {
    }

    public function deleted(Transaction $transaction)
    {
    }

    public function restored(Transaction $transaction)
    {
    }

    public function forceDeleted(Transaction $transaction)
    {
    }
}
