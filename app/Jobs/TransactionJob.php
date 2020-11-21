<?php

namespace App\Jobs;

use App\Services\TransactionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $value;
    protected $payer;
    protected $payee;

    public function __construct(float $value, int $payer, int $payee)
    {
        $this->value = $value;
        $this->payer = $payer;
        $this->payee = $payee;
    }

    public function handle(TransactionService $transactionService)
    {
        $transactionService->makeTransaction($this->value, $this->payer, $this->payee);
    }
}
