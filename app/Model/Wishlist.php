<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{  
    protected $fillable =[
        'id',
        'userId',
        'productId',
        'created_at',
        'updated_at'
    ];
    protected $table = 'WishList';
    protected $primaryKey = 'id';
}
