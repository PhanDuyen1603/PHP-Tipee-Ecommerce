<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    protected $table = 'category';
    protected $fillable =[
        'categoryID',
        'categoryName',
        'categorySlug',
        'categoryName_en',
        'categoryDescription_en',
        'categoryDescription',
        'categoryParent',
        'categoryShort',
        'categoryIndex',
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
