<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class JtAddress extends Model
{
    protected $table = 'jt_address';
    protected $fillable =[
        'id',
        'prov',
        'city',
        'area',
    ];
}
