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
        'created_at',
        'order_receivedDate'
        // 'last_name_kanji',
        // 'first_name_kanji',
        // 'last_name_kana',
        // 'first_name_kana',
        // 'company_name',
        // 'zip_code',
        // 'district',
        // 'city',
        // 'option',
        // 'total',
        // 'status',
        // 'payment',
        // 'admin_note'
    ];
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
}
