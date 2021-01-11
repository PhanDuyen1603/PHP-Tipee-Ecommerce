<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewWishlists extends Model
{
    protected $table = 'wishlists';
    protected $fillable =[
        'wish_product',
        'wish_user',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'wish_id';
}
