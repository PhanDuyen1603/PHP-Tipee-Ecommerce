<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Model\Theme;
use App\WebService\WebService;
use Illuminate\Support\Facades\Auth,Cart;
// echo $path = base_path().'\cart\vendor\autoload.php';
// require_once  $path;
// include_once base_path('cart/vendor/autoload.php');

session_start();



class HomeController extends Controller
{
    public function index(){
        \Cart::content()->count();
        $allProducts = Theme::all();
       
        return view('home.index')->with('allProducts',$allProducts);
    }
    public function postLoginCustomer(Request $request)
    {
        $login = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if($request->remember_me == 1){
            $remember_me = true;
        } else{
        	$remember_me = false;
        }
        
        if (Auth::attempt($login, $remember_me)) {
            return redirect()->route('index');
        } else {
            return redirect()->back()->with('status', 'Email hoặc Password không chính xác');
        }
    }
}
