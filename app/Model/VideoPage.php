<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VideoPage extends Model
{
    protected $table = 'video_page';
    protected $fillable =[
        'id',
        'url',
        'title',
        'order',
        'thumb',
        'thumb_alt',
        'status',
        'created_at',
        'updated_at',
    ];
}