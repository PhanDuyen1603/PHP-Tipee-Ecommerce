<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Variable_Theme extends Model
{
    public $timestamps = false;
    protected $table = 'variable_theme';
    protected $fillable =[
        'variable_themeID',
        'variable_theme_name',
        'variable_theme_description',
        'variable_theme_slug',
        'thubnail',
        'thubnail_alt',
        'variable_theme_content',
        'variable_theme_parent',
        'variable_theme_name_en',
        'variable_theme_description_en',
        'variable_theme_content_en',
        'variable_theme_status',
        'seo_title',
        'seo_keyword',
        'seo_description',
        'created',
        'updated'
    ];
}
