<?php


namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance'];
}
