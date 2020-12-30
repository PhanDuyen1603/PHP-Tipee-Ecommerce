<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class CartController extends Controller
{
    public function show_cart()
    {
        // Không quan trọng khi làm đồ án

        // // begin SEO
        // $meta_desc = "Giỏ hàng của bạn";
        // $meta_keywords = "Giỏ hàng";
        // $meta_title = "Giỏ hàng";
        // $url_canonical = $request->url();
        // // end SEO

        $allCategories = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        $allBrands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
   
        return view('pages.cart.show_cart')->with('allCategories',$allCategories)->with('allBrands',$allBrands);

    }

    public function add_cart(Request $request){       
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,30),5);
        $cart = Session::get('cart');

        //  //Nếu có sản phẩm trong cart rồi
        if($cart){
            $is_available = 0;
            //kiểm tra trong cart xem có nếu có sản phẩm đó rồi thì tăng lên 1 thôi
            foreach($cart as $key => $value){
                if($value['product_id']==$data['cart_product_id']){
                    $is_available++;
                }
            }
            //nếu thêm một sản phẩm khác không có trong cart
            if($is_available == 0){
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_id' => $data['cart_product_id'],
                    'product_name' => $data['cart_product_name'],
                    'product_price' => $data['cart_product_price'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty']
                );
                Session::put('cart',$cart);
             }   
        }else{ 
            $cart[] = array(
                'session_id' => $session_id,
                'product_id' => $data['cart_product_id'],
                'product_name' => $data['cart_product_name'],
                'product_price' => $data['cart_product_price'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty']
            );
            Session::put('cart',$cart);
        }
        
        Session::save();
    }

    public function save_cart(Request $request){        
        $productId = $request->productId_hidden;
        $quantity = $request->qty;
        $allCategories = DB::table('tbl_category')->where('category_status','1')->orderby('category_id','desc')->get();
        $allBrands = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $product = DB::table('tbl_product')->where('product_id',$productId)->get();
       
        return view('pages.cart.show_cart')->with('allCategories',$allCategories)->with('allBrands',$allBrands);
    }
}
