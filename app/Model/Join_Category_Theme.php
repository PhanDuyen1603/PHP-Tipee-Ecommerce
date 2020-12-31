<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Join_Category_Theme extends Model
{
    public $timestamps = false;
    protected $table = 'join_category_theme';
    protected $fillable =[
        'join_category_themeID',
        'id_theme',
        'id_category_theme'
    ];
}
