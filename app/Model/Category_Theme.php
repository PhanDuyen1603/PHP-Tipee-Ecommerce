<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category_Theme extends Model
{
    public $timestamps = false; 
    protected $table = 'category_theme';
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
        'theme_category_icon',
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
