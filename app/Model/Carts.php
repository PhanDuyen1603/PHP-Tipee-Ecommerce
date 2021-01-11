<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $fillable =[
        'cart_product',
        'cart_user',
        'cart_quantity',
        'cart_totalPrice',
        'updated_at',
        'created_at'
    ];
    protected $table = 'carts';
    protected $primaryKey = 'cart_id';
}
