<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Cart;
use App\Model\Theme;



use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;

class CartController extends Controller
{
    public function show_cart($userId){

        $cartOfUser = Cart::Where('cart_user',$userId)->join('Theme','Theme.Id','=','cart.cart_product')
        ->where('cart_user',$userId)->orderBy('cart_id','desc')->get();

        return view('pages.cart.show_cart')->with('cartOfUser',$cartOfUser);
    }

    public function save_cart(Request $request){
        // $data = $request->all();
      
        // //TÌM CART CỦA USER ĐÓ VỚi SẢN PHẨM ĐÓ, NẾU CÓ RỒI CHỈ CẦN UPDATE SỐ LƯỢNG, KHÔNG CẦN THÊM NỮA
        // // //tạm thờI gán user bằng một cái đã, chưa làm user
        // $cart_find = Cart::Where('cart_user',1)->where('cart_product',$data['cart_product'])->first();
        // $productPrice = Theme::Select('price_promotion')->where('id',$cart_find['cart_product'])->first(); 

        // if($cart_find){
        //     $cart_find['cart_quantity'] += $data['qty'];
        //     $cart_find['cart_totalPrice'] = (float)$productPrice['price_promotion'] * (float)$cart_find ['cart_quantity'];  
        //     $cart_find->save();
        //     return redirect('http://127.0.0.1:8000/product-detail/'.$cart_find['cart_product']);
        // }

        // $cart = new Cart();

        // //tạm thờI gán user bằng một cái đã, chưa làm user
        // $cart['cart_user'] = 1;
        // $cart['cart_product'] = $data['cart_product'];

        // //KIỂM TRA NẾU TRONG CART CỦA USER ĐÓ CÓ SẢN PHẨM RỒI THÌ TĂNG SỐ LƯỢNG LÊN
        // $cartOfUser = Cart::Where('cart_user',$cart['cart_user'])->get();
        // foreach($cartOfUser as $key => $value){
        //     if($value['cart_product'] ==  $cart['cart_product']){
        //         $cart['cart_quantity'] += $data['qty'];
        //     }
        //     else{
        //         $cart['cart_quantity'] = $data['qty'];
        //     }
        // }

        // $productPrice = Theme::Select('price_promotion')->where('id',$cart['cart_product'])->first(); 

        // //tính tổng tiềN
        // $cart['cart_totalPrice'] = (float)$productPrice['price_promotion'] * (float)$cart['cart_quantity'];
                 
        // $cart->save();
        // return redirect('http://127.0.0.1:8000/product-detail/'.$cart['cart_product']);
        return redirect('http://127.0.0.1:8000/product-detail/7527');
    }
}
