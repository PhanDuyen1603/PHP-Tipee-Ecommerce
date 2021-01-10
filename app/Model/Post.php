<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $table = 'posts';
    protected $fillable =[
        'id',
        'title',
        'slug',
        'description',
        'content',
        'title_en',
        'description_en',
        'content_en',
        'thubnail',
        'thubnail_alt',
        'created',
        'updated',
        'status',
        'gallery_images',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'gallery_checked',
        'order_short',
        'hit',

    ];
}
