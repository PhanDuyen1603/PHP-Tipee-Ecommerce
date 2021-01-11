<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    protected $fillable =[
        'rating_product',
        'rating_user',
        'rating_star',
        'rating_title',
        'rating_content',
        'created_at',
        'updated_at',
    ];
    protected $table = 'ratings';
    protected $primaryKey = 'rating_id';
}
