<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    public $timestamps = false; 
    protected $table = 'category_product';
    protected $fillable =[
        'categoryID',
        'categoryName',
        'categoryNameAs',
        'categorySlug',
        'categoryNameAs_en',
        'categoryName_en',
        'categoryContent',
        'categoryContent_en',
        'categoryDescription_en',
        'category_post_ajax',
        'category_post_ajax_child',
        'categoryDescription',
        'categoryParent',
        'categoryShort',
        'categoryIndex',
		'showhome',
        'product_category_icon',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'thubnail',
        'thubnail_alt',
        'created',
        'updated',
        'status_category'
    ];
}
