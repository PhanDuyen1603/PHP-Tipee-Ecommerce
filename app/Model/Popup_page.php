<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Popup_page extends Model
{
    protected $table = 'popup_page';
    protected $fillable =[
        'id',
        'title',
        'image',
        'image_alt',
        'status',
        'link',
        'created_at',
        'updated_at',
    ];
}
