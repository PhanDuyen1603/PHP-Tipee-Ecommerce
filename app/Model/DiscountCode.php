<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $table = 'discount_code';
    protected $fillable =[
        'id',
        'code',
        'expired',
        'type',
        'percent',
        'discount_money',
        'apply_for_order',
        'status',
        'created_at',
        'updated_at'
    ];
}
