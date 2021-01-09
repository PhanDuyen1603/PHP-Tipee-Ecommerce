<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    public $timestamps = false;
    protected $table = 'wishlist';
    protected $fillable =[
        'id',
        'id_product',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
