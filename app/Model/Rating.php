<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable =[
        'rating_product',
        'rating_star',
        'rating_title',
        'rating_content',
        'created_at',
        'updated_at',
    ];
    protected $table = 'rating';
    protected $primaryKey = 'rating_id';
}
