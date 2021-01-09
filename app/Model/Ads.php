<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    public $timestamps = false;
    protected $table = 'ads';
    protected $fillable =[
        'id',
        'title',
        'link_ads',
        'show_title',
        'target_link',
        'thumbnail',
        'thumbnail_alt',
        'order',
        'created',
        'updated',
        'status'
    ];
}
