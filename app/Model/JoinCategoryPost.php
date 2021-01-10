<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JoinCategoryPost extends Model
{
    public $timestamps = false;
    protected $table = 'join_category_post';
    protected $fillable =[
        'join_category_postID',
        'id_post',
        'id_category'
    ];
}
