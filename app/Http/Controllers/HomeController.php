<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();



class HomeController extends Controller
{
    public function index(){
        $allCategories = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        
        // $all_product = DB::table('tbl_product')->join('tbl_category','product_category','=','category_id')
        // ->join('tbl_brand','product_brand','=','brand_id')->orderby('product_id','desc')->get();

        $allProducts = DB::table('tbl_product')->where('product_status','1')->orderby('product_id','desc')->limit(4)->get(); 
        //return view('pages.home')->with('allCategories',$allCategories)->with('allProducts',$allProducts);
        return view('home.index');//->with('allCategories',$allCategories)->with('allProducts',$allProducts);
    }

}
