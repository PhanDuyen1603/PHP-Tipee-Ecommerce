<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;
    protected $table = 'province';
    protected $fillable =[
        'provinceid',
        'name',
        'order_sort'
    ];
}
