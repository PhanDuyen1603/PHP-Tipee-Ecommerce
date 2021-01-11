<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JoinCategoryProduct extends Model
{
    public $timestamps = false;
    protected $table = 'join_category_product';
    protected $fillable =[
        'join_category_productID',
        'id_product',
        'id_category_product'
    ];
}
