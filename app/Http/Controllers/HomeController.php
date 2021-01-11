<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Model\Product;
use App\WebService\WebService;
use Illuminate\Support\Facades\Auth,Cart;
//  $path = public_path('\cart\vendor\autoload.php');
// require_once str_replace('public\cart', 'cart', $path);
use Mail;

session_start();



class HomeController extends Controller
{
    public function index(){
        $productNews = Product::orderBy('id','desc')->limit(10)->get();
        $productSales = Product::skip(10)->take(10)->orderBy('id','desc')->limit(10)->get();
        $productFavourite = Product::skip(20)->take(10)->orderBy('id','desc')->limit(10)->get();
        return view('home.index', compact('productNews','productSales','productFavourite'));
    }
    // search
    public function themeSearch(Request $request){
        if(isset($request->query_string)){
            $name_product = $request->query_string;
            $list_category=DB::table('category_theme')
                ->whereNotIn('categoryID', [69])
                ->where('status_category','=',0)
                ->orderBy('categoryName', 'ASC')
                ->get();
            $data_customers=DB::table('category_theme')
                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                ->join('theme','join_category_theme.id_theme','=','theme.id')
                ->where('theme.title', 'like', '%'.$name_product.'%')
                ->where('theme.status','=',0)
                ->groupBy('theme.slug')
                ->orderByRaw('theme.order_short DESC')
                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                ->paginate(10);
                dd($data_customers);
                // return view('theme.search')
                //     ->with('list_categories',$list_category)
                //     ->with('productSearch',$data_customers);
        } else{
            return view('errors.404');
        }
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
