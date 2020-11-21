<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['payer', 'payee', 'value'];
    public $timestamps = true;

    public function user_payer()
    {
        return parent::belongsTo(User::class, 'id', 'payer');
    }

    public function user_payee()
    {
        return parent::belongsTo(User::class, 'id', 'payee');
    }
}
