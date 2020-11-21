<?php


namespace App\Contracts;


use App\Model\User;

interface WalletInterface
{
    public function credit(User $payee, float $value);

    public function debit(User $payer, float $value);
}
