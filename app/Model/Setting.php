<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;
    protected $table = 'settings';
    protected $fillable =[
        'id',
        'name_setting',
        'value_setting',
        'created',
        'updated',
        'status'
    ];
}
