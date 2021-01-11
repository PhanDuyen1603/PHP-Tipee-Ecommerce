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
use App\Model\Order_details;

use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;

class CartController extends Controller
{
    private $order_new;
    
    public function save_order(Request $request){
        $data = $request->all(); 
        $userId = Auth::user()->id;
        $carts = Carts::Where('cart_user',$userId)->get();

        $newOrder = new Orders();
        $totalPrice = Carts::Where('cart_user',$userId)->sum('cart_totalPrice');
        $newOrder['order_totalPrice'] = (float)$totalPrice;

        foreach($carts as $key => $cart){
            $newOderDetails = new Order_details();
            $newOderDetails['order_product'] = $cart['cart_product'];
            $newOderDetails['order_quantity'] = $cart['cart_quantity'];
            $newOderDetails['order_price'] = $cart['cart_totalPrice'];
            
            $newOrder['order_customer'] = $userId ;  
            $newOrder['order_address'] = $data['order_address'];   

            $newOrder->save();
            $this->order_new = $newOrder['order_id'];
            $newOderDetails['order'] = $newOrder['order_id'];
            $newOderDetails->save();

            $cart->delete();
        }
        return $this->show_order()->with('new_order',$newOderDetails['order_id']);
    }

    public function show_order(){
        $userId = Auth::user()->id;
        //LẤY ĐƠN HÀNG VỪA MỚI ORDER
        $user_order = Orders::Where('order_customer',$userId)->Where('order_id',$this->order_new)->join('Order_details','order','=','order_id')
        ->join('Products','products.id','=','order_product')->get();

        return view('pages.cart.show_orderState')->with('user_order', $user_order);
    }

    public function show_all_order(){
        $userId = Auth::user()->id;
        $user_order = Orders::Where('order_customer',$userId)->join('Order_details','order','=','order_id')
        ->join('Products','products.id','=','order_product')->get();

        return view('pages.cart.show_all_order')->with('user_order', $user_order);
    }

    public function show_cart(){
        if(Auth::User()){
            $userId = Auth::User()->id;
            $cartOfUser = Carts::Where('cart_user',$userId)->join('Products','Products.id','=','carts.cart_product')
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
