<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRegisterEmail extends Model
{
    protected $table = 'user_register_email';
    protected $fillable =[
        'id',
        'email',
        'created_at',
        'updated_at',
    ];
}
