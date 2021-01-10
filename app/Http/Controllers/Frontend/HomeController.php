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
use App\User,DB;
use App\Model\CategoryProduct;
use Carbon\Carbon,URL;

class HomeController extends Controller
{
    public function registerAccount(Request $rq){
        $validation_rules = array(
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'phone' => 'required|unique:users',
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
            'phone.required' => 'Hãy nhập số điện thoại',
            'phone.unique' => 'Số điện thoại đã tồn tại',
        );
        $validator = Validator::make($rq->all(), $validation_rules, $messages);
        if($validator->fails()) {
            return  Redirect::back()->withErrors($validator);
        }
        $token_mail = Helpers::generateRandomString(36);

        $new_cus = new User();
        $email = $rq->email;
        $new_cus->name = $rq->full_name;
        $new_cus->email = $rq->email;
        $new_cus->birthday = $rq->year.'-'.$rq->month.'-'.$rq->day;
        $new_cus->token_mail = $token_mail;
        $new_cus->phone = $rq->phone;
        $new_cus->gender = $rq->gender;
        $new_cus->password = bcrypt($rq->password);
        $new_cus->save();
        // Auth::login($new_cus);
        $data = array(
            'name'=> $rq->full_name,
            'email_admin'=> 'bapcaicuatui@gmail.com',
            'email'=> $email,
            'link_check_login'=>URL::to('/login/token/'.$token_mail),
        );
        Mail::send('email.templales.mail',
            $data,
            function($message) use ($data) {
                $message->from($data['email_admin'],$data['name']);
                $message->to($data['email'])
                    // ->cc($data['cc_email'],$data['name_email_admin'])
                    ->subject("Tippe xin chào: ".$data['name']);
            }
        );
        return redirect()->route('users.mail.proceed')->with(['email'=>$email]);
    }
    public function loginMail($string){
        $authUser = User::where('token_mail', $string)->first();
        if ($authUser) {
            $tomorrow = Carbon::now();
            $updated_at = $authUser->updated_at;
            // 1 month
            $is_expired = $updated_at->addMinutes(60*12*30);
            if($tomorrow < $is_expired){
                        Auth::login($authUser);

                // auth('customer')->login($authUser, true);
                return Redirect::to('/');
            }else{
                return redirect()->route('index')->with(['proceed'=>'true']); 
            }
        }
        else{
            return Redirect::to('/');
        }
    }
    public function successMail(){
        return view('email.success');

    }
    public function forgetPassword(){
        return view('email.forgetPassword');

    }
    public function actionForgetPassword(Request $rq){
        $user = User::where('email', '=', $rq->email)->first();
        if($user){
            session_start();
            $forget_password = Helpers::generateRandomString(36);
            $_SESSION["email_forget"] = $rq->email;
            $user->update(['forget_password'=>$forget_password]);
            $data = array(
                'email_admin'=> 'bapcaicuatui@gmail.com',
                'email'=>$user->email,
                'name'=>$user->full_name,
                'forget_password'=>$user->forget_password,
                'link_check_login'=>URL::to('/forget-password-step2/'.$forget_password),
            );
            Mail::send('email.templales.forget-password',
                $data,
                function($message) use ($data) {
                    $message->from($data['email_admin'],$data['name']);
                    $message->to($data['email'])
                        // ->cc($data['cc_email'],$data['name_email_admin'])
                        ->subject("Quên mật khẩu");
                });
            return redirect()->route('forgetPassword')->with('notify', 'Vui lòng check mail.');
        } else{
            return redirect()->route('forgetPassword')->withErrors('Email not exist.');
        }
    }
    public function actionForgetPasswordStep2(Request $rq,$token){
        session_start();
        $user = User::where('forget_password', $token)->first();
        if($user){
            return view('email.forgetPasswordStep2');
        }else{
            die("Bạn không phải user");
        }

    }
    public function actionForgetPasswordStep3(Request $rq){
        session_start();
            $validator = Validator::make($rq->all(), [
                'new_password'     => 'required|min:6|required_with:confirm_new_password|same:confirm_new_password',
                'confirm_new_password'     => 'required|min:6',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator);
            }
            $customer = User::where('email', '=', $_SESSION["email_forget"])->first();
            $customer->password = bcrypt($rq->new_password);
            $customer->save();
            session_unset();
            session_destroy();
            $msg = "Mật khẩu đã được thay đổi.";
            $url=  route('index');
            if($msg) echo "<script language='javascript'>alert('".$msg."');</script>";
            echo "<script language='javascript'>document.location.replace('".$url."');</script>";
    }
}
