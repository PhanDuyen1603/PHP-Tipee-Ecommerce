<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Theme_Join_Variable_Theme extends Model
{
    public $timestamps = false;
    protected $table = 'theme_join_variable_theme';
    protected $fillable =[
        'theme_join_variable_themeID',
        'id_theme',
        'code_variable_theme',
        'variable_themeID',
        'theme_join_variable_theme_img',
		'theme_join_variable_theme_icon',
        'theme_join_variable_theme_price',
		'theme_join_variable_theme_description',
		'theme_join_variable_theme_code',
        'status',
        'created',
        'updated'
    ];
}
