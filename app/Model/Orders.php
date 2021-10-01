<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'order_customer', 
        'order_customer', 
        'order_totalPrice',
        'order_address',
        'order_state',
        'updated_at',
        'order_created',
        'order_receivedDate'

    ];
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
}
