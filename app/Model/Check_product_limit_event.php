<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Check_product_limit_event extends Model
{
    protected $table = 'check_product_limit_event';
    protected $fillable =[
        'id',
        'product_id',
        'user_phone',
        'user_id',
        'item_limit',
        'user_name',
        'created_at',
        'updated_at'
    ];
}
