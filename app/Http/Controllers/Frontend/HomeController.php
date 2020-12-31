<?php 
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Validator;
session_start();



class HomeController extends Controller{
    public function registerAccount(Request $request){
        $validator = Validator::make($request->all(), [
            'full_name'     => 'required',
            'phone_number'     => 'required',
            'email'=>'required',
            'email'=>'required'
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }
        // params
        $preItem = $request->all();
        $birthday = $preItem['year'].'-'.$preItem['month'].'-'.$preItem['day'];
        $user = new User();
        $user->name = $preItem['full_name'];
        $user->email = $preItem['email'];
        $user->gender = $preItem['gender'];
        $user->phone = $preItem['phone_number'];
        $user->birthday = $birthday ;
        $user->password = bcrypt($preItem['password']);
        $user->save();
        auth()->login($user, true);
		return redirect('/');
    }
}