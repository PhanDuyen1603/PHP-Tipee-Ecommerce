<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariableSku extends Model
{
    public $timestamps = false;
    protected $table = 'product_variable_sku';
    protected $fillable =[
        'id',
        'id_product',
        'sku',
        'price',
        'description',
        'thumbnail',
        'icon',
        'qty',
        'status',
        'created',
        'updated'
    ];
}
