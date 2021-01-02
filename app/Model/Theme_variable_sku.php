<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Theme_variable_sku extends Model
{
    public $timestamps = false;
    protected $table = 'theme_variable_sku';
    protected $fillable =[
        'id',
        'id_theme',
        'sku',
        'price',
        'description',
        'thumbnail',
        'icon',
        'qty',
        'status',
        'created',
        'updated'
    ];
}
