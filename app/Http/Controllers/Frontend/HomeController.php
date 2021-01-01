<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Show the application’s login form.
     *
     * @return \Illuminate\Http\Response
     */
    protected $guard = 'web';
    protected function guard(){
        return Auth::guard('web');
    }
    
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/customer';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('logout');
    }
    public function logout(){
        Auth::user()->logout();
        return redirect()->route('index');
    }
    
    public function registerAccount (Request $rq){
        $validation_rules = array(
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'phone_number' => 'required|max:10|unique:users',
        );
        $messages = array(
            'full_name.required' => 'Hãy nhập họ của bạn',
            'full_name.max' => '"Họ" tối đa 255 ký tự',
            'email.required' => 'Hãy nhập vào địa chỉ Email',
            'email.email' => 'Địa chỉ Email không đúng định dạng',
            'email.max' => 'Địa chỉ Email tối đa 255 ký tự',
            'email.unique' => 'Địa chỉ Email đã tồn tại',
            'password.required' => 'Hãy nhập mật khẩu',
            'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
            
            'phone_number.required' => 'Hãy nhập số điện thoại',
            'phone_number.max' => 'Số điện thoại tối đa 12 ký tự',
            'phone_number.unique' => 'Số điện thoại đã tồn tại',
        );
        $validator = Validator::make($rq->all(), $validation_rules, $messages);
        if($validator->fails()) {
            return  Redirect::back()->withErrors($validator);
        }

        $new_cus = new User();
        $new_cus->name = $rq->full_name;
        $new_cus->email = $rq->email;
        $new_cus->birthday = $rq->year.'-'.$rq->month.'-'.$rq->day;
        $new_cus->phone = $rq->phone;
        $new_cus->password = bcrypt($rq->password);
        dd($new_cus);
        $new_cus->save();
        Auth::login($new_cus);
        return redirect()->route('index');
    }
}