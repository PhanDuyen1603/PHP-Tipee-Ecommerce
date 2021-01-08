<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slishow extends Model
{
    public $timestamps = false;
    protected $table = 'slishow';
    protected $fillable =[
        'id',
        'name',
        'src',
        'src_mobile',
        'order',
        'link',
        'description',
        'target',
        'created',
        'updated',
        'status'
    ];
}
