<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;
    protected $table = 'district';
    protected $fillable =[
        'districtid',
        'name',
        'provinceid',
        'order_sort'
    ];
}
