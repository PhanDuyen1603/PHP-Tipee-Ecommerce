<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Addtocard extends Model
{
    public $timestamps = false;
    protected $table = 'addtocard';
    protected $fillable =[
        'cart_id',
        'cart_hoten',
        'cart_phone',
        'cart_email',
        'cart_address',
        'cart_province',
        'cart_district',
        'cart_ward',
        'cart_note',
        'cart_total',
        'order_total_not_discount',
        'cart_content',
		'cart_pay_method',
        'type_shipping',
        'shipping_fee',
		'cart_excerpt',
		'cart_view',
        'user_id',
        'id_discount_code',
		'cart_code',
        'created',
        'updated',
        'cart_status'
    ];
}
