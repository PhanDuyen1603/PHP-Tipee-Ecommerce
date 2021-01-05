<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Customer_forget_pass_otp extends Model{
    protected $table = 'customer_forget_pass_otp';
    public $timestamps = true;
    protected $fillable =[
        'id',
        'email',
        'user_id',
        'otp_mail',
        'status',
        'created_at',
        'updated_at',
    ];
}

