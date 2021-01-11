<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable =[
        'cart_product',
        'cart_user',
        'cart_quantity',
        'updated_at',
        'created_at'
    ];
    protected $table = 'cart';
    protected $primaryKey = 'cart_id';
}
