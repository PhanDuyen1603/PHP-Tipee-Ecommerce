<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'ac_news';

    protected $fillable = [
        'title',
        'description',
        'content',
        'thumbnail',
        'status'
    ];
}
