<?php
namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Discount_code;
use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;

class CustomerLoginController extends Controller
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
    public function registerCustomer(){
        return view('customer.auth.register');
    }
    public function createCustomer(Request $rq){
        $validation_rules = array(
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|max:10|unique:users',
            'slt_province' => 'required|max:255',
            'slt_district' => 'required|max:255',
            'slt_ward' => 'required|max:255',
            'address' => 'required|max:255',
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
            'password.confirmed' => 'Xác nhận mật khẩu không đúng',
            'phone.required' => 'Hãy nhập số điện thoại',
            'phone.max' => 'Số điện thoại tối đa 12 ký tự',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'address.required' => 'Hãy nhập vào địa chỉ của bạn',
            'address.max' => 'Địa chỉ được phép nhập tối đa 255 ký tự',
            'slt_province.required' => 'Chọn tỉnh thành',
            'slt_district.required' => 'Chọn quận/huyện',
            'slt_ward.required' => 'Chọn phường/xã',
        );
        $validator = Validator::make($rq->all(), $validation_rules, $messages);
        if($validator->fails()) {
            return  Redirect::back()->withErrors($validator);
        }

        $new_cus = new User();
        $new_cus->name = $rq->full_name;
        $new_cus->email = $rq->email;
        $new_cus->birthday = $rq->birthday_year.'-'.$rq->birthday_month.'-'.$rq->birthday_day;
        $new_cus->phone = $rq->phone;
        $new_cus->address = $rq->address;
        $new_cus->province = $rq->slt_province;
        $new_cus->district = $rq->slt_district;
        $new_cus->ward = $rq->slt_ward;
        $new_cus->password = bcrypt($rq->password);
        $new_cus->save();

        Auth::login($new_cus);

        // $check_discount_for_new_customer = Helpers::get_option_minhnn('on-off-discount-for-new-customer');
        // if($check_discount_for_new_customer == 'on'):
        //     while (true) {
        //         $code_discount = Helpers::auto_code_discount();
        //         $checkcode = Discount_code::where('discount_code.code', '=', $code_discount)->get();
        //         if(count($checkcode)==0){
        //             break;
        //         }
        //     }

        //     $date = date("d");
        //     $month = date("m");
        //     $year = date("Y");
        //     $hours = date("H");
        //     $min = date("i");
        //     $sec = date("s");
        //     $expired =date('Y-m-d H:i:s',mktime($hours,$min,$sec,$month,($date+60),$year));
        //     $convert_expired = date('d-m-Y H:i:s',strtotime($expired));
            
        //     $discount = new Discount_code;
        //     $discount->code = $code_discount;
        //     $discount->expired =$expired;
        //     $discount->type = 'onetime';
        //     $discount->percent = Helpers::get_option_minhnn('discount-for-new-customer');
        //     $discount->status = 0;
        //     $discount->save();

        //     $data = array(
        //         'name'=>$new_cus->first_name.' '.$new_cus->last_name,
        //         'email'=>$new_cus->email,
        //         'code_discount' => $discount->code,
        //         'expired' => $discount->expired,
        //         'subject_default'=>'Phiếu giảm giá từ Siêu thị Ánh Dương chào mừng thành viên mới!'
        //     );
        //     Mail::send('email.user_register',
        //         $data,
        //         function($message) use ($data) {
        //             $message->from($data['email'],'DADA BEAUTY');
        //             $message->to($data['email'])
        //                 ->subject($data['subject_default']);
        //         }
        //     );
        // endif;
        return redirect()->route('index');
    }
}