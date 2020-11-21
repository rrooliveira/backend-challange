<?php

namespace App\Jobs;

use App\Mail\TransactionEmail;
use App\Model\User;
use App\Services\UserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class EmailTransactionJob implements ShouldQueue
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

    public function handle(UserService $userService)
    {
        //Payer
        $this->payer = $userService->checkIfUserIsValid($this->payer);

        //Payee
        $this->payee = $userService->checkIfUserIsValid($this->payee);

        // Send email after transaction confirmation
        Mail::to($this->payee->email)
            ->send(new TransactionEmail($this->value, $this->payer, $this->payee));
    }
}
