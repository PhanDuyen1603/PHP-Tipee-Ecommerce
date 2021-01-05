<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    public $timestamps = false;
    protected $table = 'ward';
    protected $fillable =[
        'wardid',
        'name',
        'districtid'
    ];
}
