<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
   
    protected $fillable =[
        'name',
        'gender',
        'phone',
        'birthday',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
    ];

    protected $table = 'users';
    protected $primaryKey = 'id';
}