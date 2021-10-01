<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VariableProduct extends Model
{
    public $timestamps = false;
    protected $table = 'variable_product';
    protected $fillable =[
        'variable_productID',
        'variable_product_name',
        'variable_product_description',
        'variable_product_slug',
        'thubnail',
        'thubnail_alt',
        'variable_product_content',
        'variable_product_parent',
        'variable_product_name_en',
        'variable_product_description_en',
        'variable_product_content_en',
        'variable_product_status',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'created',
        'updated'
    ];
}
