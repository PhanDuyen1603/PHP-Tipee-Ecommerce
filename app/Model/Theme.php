<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    public $timestamps = false;
    protected $table = 'theme';
    protected $fillable =[
        'id',
        'title',
        'theme_code',
        'subtitle',
        'slug',
        'description',
        'content',
        'price_origin',
        'price_promotion',
        'start_event',
        'end_event',
        'countdown',
        'group_combo',
        'id_brand',
        'title_en',
        'item_new',
        'description_en',
        'content_en',
        'product_detail_weight',
        'product_detail_size',
        'product_detail_ingredients',
        'product_detail_source',
        'product_expiry_date',
        'subtitle_en',
        'thubnail',
        'thubnail_alt',
		'store_status',
        'created',
        'updated',
        'status',
        'gallery_images',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'gallery_checked',
        'order_short'
    ];
}
