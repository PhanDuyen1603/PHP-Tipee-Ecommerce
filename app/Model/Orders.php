<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $fillable =[
        'id',
        'order_id',
        'email',
        'phone',
        'address',
        'last_name_kanji',
        'first_name_kanji',
        'last_name_kana',
        'first_name_kana',
        'company_name',
        'zip_code',
        'district',
        'city',
        'option',
        'total',
        'status',
        'payment',
        'admin_note'
    ];
}
