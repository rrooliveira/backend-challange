<?php

namespace App\Mail;

use App\Model\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $value;
    private $payer;
    private $payee;

    public function __construct(float $value, User $payer, User $payee)
    {
        $this->value = $value;
        $this->payer = $payer;
        $this->payee = $payee;
    }

    public function build()
    {
        //return $this->view('view.name');
        return $this->markdown('emails.transactions.processed')
            ->subject('Recebimento de Pagamento!!!')
            ->with([
               'value' => $this->value,
               'payer' => $this->payer,
               'payee' => $this->payee
           ]);
    }
}
