<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Theme_variable_sku_value extends Model
{
    public $timestamps = false;
    protected $table = 'theme_variable_sku_value';
    protected $fillable =[
        'id',
        'id_theme',
        'variable_themeID',
        'variable_parentID',
        'theme_variable_sku_id',
        'status',
        'created',
        'updated'
    ];
}
