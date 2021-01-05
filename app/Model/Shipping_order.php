<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shipping_order extends Model
{
    protected $table = 'shipping_order';
    protected $fillable =[
        'id',
        'id_shipping',
        'cart_id',
        'type_shipping',
        'shipping_status',
        'created_at',
        'updated_at'
    ];
}
