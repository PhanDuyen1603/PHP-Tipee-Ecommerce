<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductVariableSkuValue extends Model
{
    public $timestamps = false;
    protected $table = 'product_variable_sku_value';
    protected $fillable =[
        'id',
        'id_product',
        'variable_productID',
        'variable_parentID',
        'product_variable_sku_id',
        'status',
        'created',
        'updated'
    ];
}
