<?php


namespace App\Repositories;


use App\Model\Transaction;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }
}
