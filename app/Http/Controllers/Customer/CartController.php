<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Cart;
use App\Model\Theme;
use App\Model\Users;
use Session;
use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;
session_start();

class CartController extends Controller
{


    public function show_cart($userId){
        $cart_user = Cart::Where('cart_user',$userId)->join('Theme','Theme.Id','=','cart.cart_product')
        ->where('cart_user',$userId)->orderBy('cart_id','desc')->get();

        $user_info = Users::Where('id',$userId)->join('Cart','Cart.cart_user','=','Users.id')->get();

        return view('pages.cart.show_cart')->with('cart_user',$cart_user)->with('user_info',$user_info);
       
    }

    public function delete_cart(Request $request){
        $data = $request->all(); 
        $cart = Session::get('cartss');
        $cart_deleted = Cart::Where('cart_user',$data['userId'])->where('cart_product',$data['cart_product'])->get();
        var_dump($cart_deleted);
        if($cart==true){
            Session::forget('cartss');             
        }
        if(!$cart_deleted->isEmpty()){
            $cart_deleted->delete();
        }

        $cart_user = Cart::Where('cart_user',$data['userId'])->join('Theme','Theme.Id','=','cart.cart_product')
        ->where('cart_user',$data['userId'])->orderBy('cart_id','desc')->get();

        $user_info = Users::Where('id',$data['userId'])->join('Cart','Cart.cart_user','=','Users.id')->get();

        return view('pages.cart.show_cart')->with('cart_user',$cart_user)->with('user_info',$user_info);
    }

    public function save_cart(Request $request){
  
        //LẤY CART TỪ SESSION
        $data = $request->all();      
   
        //tạm thờI gán user bằng 1
        $userId = 1;

        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cartss = Session::get('cartss');
       
        if($cartss){
            foreach($cartss as $key => $val){
                if(strval($val['cart_product_ss'])== strval($data['cart_product'])){
                    $val['cart_quantity_ss'] =  $val['cart_quantity_ss'] + $data['cart_quantity'];    
                }
            }
            var_dump($cartss);
            Session::put('cartss',$cartss);
        }else{
            $cartss[] = array(
                // 'session_id' => $session_id,
                'cart_product_ss' => $data['cart_product'],
                'cart_quantity_ss' => $data['cart_quantity'] + 0,
                );
            Session::put('cartss',$cartss);
        }
        Session::save();
        // Session::forget('cartss');

      
        
         // KIỂM TRA CÓ CART CỦA USER CHƯA?
        $cart_user = Cart::Where('cart_user',$userId)->get();
          
        if(!$cart_user->isEmpty()){
            foreach($cart_user as $key => $value){
                if($value['cart_product'] ==  $data['cart_product']){ // NẾU CÓ USER, CÓ SẢN PHẨM ĐÓ CHƯA? 
                    $value['cart_quantity'] += $data['cart_quantity'];  //NẾU CÓ SẢN PHẨM RỒI THÌ TĂNG SỐ LƯỢNG
                    $value->save();
                }
                else{ 
                    //NẾU CHƯA CÓ SẢN PHẨM THÌ GÁN SẢN PHẨM VÀ SỐ LƯỢNG
                    $value['cart_product'] = $data['cart_product'];
                    $value['cart_quantity'] = $data['cart_quantity'];
                    $value->save();
                }
            }
        }else{  //NẾU CHƯA CÓ USER THÌ TẠO CART MỚI
  
            $newCart = new Cart();
            $newCart['cart_user'] = $userId;
            $newCart['cart_product'] = $data['cart_product'];
            $newCart['cart_quantity'] = $data['cart_quantity'];
            $productPrice = Theme::Select('price_promotion')->where('id',$data['cart_product'])->first(); 
            $newCart['cart_totalPrice'] =  (float)$productPrice['price_promotion'] * (float)$newCart['cart_quantity'];
            $newCart->save();


        }
        // Session::forget('cartss');
        return redirect('http://127.0.0.1:8000/product-detail/'.$data['cart_product']); 
    }


}
