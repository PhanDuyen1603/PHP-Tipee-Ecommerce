<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public $timestamps = false;
    protected $table = 'pages';
    protected $fillable =[
        'id',
        'title',
        'slug',
        'description',
        'content',
        'thubnail',
        'thubnail_alt',
        'template',
        'created',
        'updated',
        'status'
    ];
}
