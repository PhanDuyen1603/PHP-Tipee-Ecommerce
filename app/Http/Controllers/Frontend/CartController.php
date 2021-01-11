<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Model\Carts;
use App\Model\Product;
use App\Model\Orders;

use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;

class CartController extends Controller
{
    public function show_order(){

    }

    public function order_cart(Request $request){
        $data = $request->all(); 
        $newOrder = new Orders();
        $newOrder['order_customer'] = $data['order_customer'];
        $newOrder['order_product'] = $data['order_product'];
        $newOrder['order_price'] = $data['order_price'];
        $newOrder['order_address'] = $data['order_address'];
        $newOrder['order_state'] = 'Đang giao';
        $newOrder->save();

        // $user_order = Orders::Where('order_customer',$newOrder['order'])

        // return view('pages.cart.show_orderState')->with('user_order',$user_order);
    }

    public function show_cart(){
        if(Auth::User()){
            $userId = Auth::User()->id;
            $cartOfUser = Carts::Where('cart_user',$userId)->join('Products','Products.Id','=','carts.cart_product')
            ->orderBy('cart_id','desc')->limit(10)->get();
            $user_info = User::Where('id',$userId)->get();
            return view('pages.cart.show_cart')->with('cartOfUser',$cartOfUser)->with('user_info',$user_info);
        }    
    }

    public function delete_cart(Request $request){
        $data = $request->all();
        // $cartOfUser = Carts::Where('cart_user',$data['userId'])->where('cart_product',$data['cart_product'])->first();
        $cartOfUser = Carts::Where('cart_id',$data['cart_id'])->first();
        $cartOfUser->delete();
        $deleteMsg = "Đã xoá sản phẩm khỏi giỏ hàng";
        return redirect()->back()->with('deleteMsg',$deleteMsg);
        
    }

   public function save_cart(Request $request){
       $data = $request->all();
      
        //TÌM CART CỦA USER ĐÓ VỚi SẢN PHẨM ĐÓ
        // NẾU CÓ RỒI THÌ CỘNG THÊM SỐ LƯỢNG
        // CHƯA CÓ THÌ GÁN
       if(Auth::user())
       {
            $cart_find = Carts::Where('cart_user',$data['cart_user'])->where('cart_product',$data['cart_product'])->first();
            if($cart_find){
                $cart_find['cart_quantity'] += $data['input'];
                $productPrice = Product::Select('price_promotion')->where('id',$cart_find['cart_product'])->first(); 
                $cart_find['cart_totalPrice'] = (float)$productPrice['price_promotion'] * (float)$cart_find ['cart_quantity'];  
                $cart_find->save();
 
            }else{
                $newCart = new Carts();
                $newCart['cart_user'] = $data['cart_user'];
                $newCart['cart_product'] = $data['cart_product'];
                $newCart['cart_quantity'] = $data['input'];
                $productPrice = Product::Select('price_promotion')->where('id',$newCart['cart_product'])->first(); 
                $newCart['cart_totalPrice'] = (float)$productPrice['price_promotion'] * (float)$newCart['cart_quantity'];
                $newCart->save();

            }
       }
               
        return redirect()->back();
    }
}
