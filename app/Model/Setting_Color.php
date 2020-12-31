<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting_Color extends Model
{
    public $timestamps = false;
    protected $table = 'setting_color';
    protected $fillable =[
        'id',
        'title',
        'slug',
        'color',
        'color1',
        'color2',
        'created',
        'updated',
        'status'
    ];
}
