<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    protected $fillable = [
        'oder_detail_id',
        'order_product',   
        'order_quantity',          
        'order_price',
        'order',
        'updated_at',
        'created_at'
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
    protected $table = 'order_details';
    protected $primaryKey = 'oder_detail_id';
}
