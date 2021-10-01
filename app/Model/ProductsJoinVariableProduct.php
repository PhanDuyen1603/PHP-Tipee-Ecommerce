<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductJoinVariableProduct extends Model
{
    public $timestamps = false;
    protected $table = 'product_join_variable_product';
    protected $fillable =[
        'product_join_variable_productID',
        'id_product',
        'code_variable_product',
        'variable_productID',
        'product_join_variable_product_img',
		'product_join_variable_product_icon',
        'product_join_variable_product_price',
		'product_join_variable_product_description',
		'product_join_variable_product_code',
        'status',
        'created',
        'updated'
    ];
}
