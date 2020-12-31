<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Discount_for_brand extends Model
{
    protected $table = 'discount_for_brand';
    protected $fillable =[
        'id',
        'brand_id',
        'brand_name',
        'percent',
        'start_event',
        'end_event',
        'created_at',
        'updated_at'
    ];
}
