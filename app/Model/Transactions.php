<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';
    protected $fillable =[
        'id',
        'id_payment',
        'amount',
        'balance_transaction',
        'order_id',
        'currency',
        'description',
        'payment_created',
        'payment_method'
    ];
}
