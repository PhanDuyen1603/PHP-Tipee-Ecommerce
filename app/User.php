<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
// use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    // use HasRoles;
    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'type'
    ];

	public function existed($params)
    {
        return DB::table('users as s')
            ->select('*')
            ->where('email', '=', $params['email'])
            ->get()->first();
    }

    public static function getAll()
    {
        return DB::table('users as s')
            ->select('id', 'name')
            ->get()->toArray();
    }

 
}
