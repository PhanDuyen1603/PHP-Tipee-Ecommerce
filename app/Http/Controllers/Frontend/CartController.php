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
use Carbon\Carbon;

use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;

class CartController extends Controller
{    
    public function update_orderState(Request $request){
        $data = $request->all();
        $order_update = Orders::Where('order_id',$data['order_id'])->first();
        $order_update['order_state'] = $data['order_state'];
        $order_update->save();
        // dd($data['order_state']);
        return redirect()->back();
    }

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
            $dt = Carbon::now(); 
            $newOrder['order_receivedDate'] = $dt->addDays(3);
            $newOrder->save();
            $newOderDetails['order'] = $newOrder['order_id'];
            $newOderDetails->save();

            $cart->delete();
        }
        return $this->show_order()->with('new_order',$newOderDetails['order_id']);
    }

    public function show_order(){
        //HIỂN THỊ ĐƠN HÀNG ĐANG GIAO (CHƯA GIAO)

        $dt = Carbon::now();

        $userId = Auth::user()->id;      
       
        $user_order = Orders::Where('order_customer',$userId)->where('orders.order_receivedDate', '>', NOW())
        ->join('Order_details','order','=','order_id')
        ->join('Products','products.id','=','order_product')->orderBy('order_id','desc')->get();

        $orders = Orders::Where('order_customer',$userId)->where('orders.order_receivedDate', '>', NOW())->get();
        $totalPrice = 0;
        foreach($orders as $key => $val){
            $totalPrice += $val->order_totalPrice;
        }

        if(Auth::user()){   
            $userId = Auth::user()->id;
            $count_cart = Carts::where('cart_user',$userId)->sum('cart_quantity');  
        }else{
            $count_cart = 0;
        }

        return view('pages.cart.show_orderState')->with('user_order', $user_order)->with('count_cart',$count_cart)->with('totalPrice',$totalPrice);
    }

    public function show_all_order(){
        //HIỂN THỊ TẤT CẢ ĐƠN HÀNG
        $userId = Auth::user()->id;
        $user_order = Orders::Where('order_customer',$userId)->join('Order_details','order','=','order_id')
        ->join('Products','products.id','=','order_product')->orderBy('order_id','desc')->get();

        foreach($user_order as $key => $order){
            if($order['order_receivedDate'] <= NOW()){
                $order['order_state'] = 'Đã giao';
                $order->save();
            }
        }

        if(Auth::user()){
            $userId = Auth::user()->id;
            $count_cart = Carts::where('cart_user',$userId)->sum('cart_quantity');  
        }else{
            $count_cart = 0;
        }

        return view('pages.cart.show_all_order')->with('user_order', $user_order)->with('count_cart',$count_cart);
    }

    public function show_cart(){
        if(Auth::User()){
            $userId = Auth::User()->id;
            $cartOfUser = Carts::Where('cart_user',$userId)->join('Products','Products.id','=','carts.cart_product')
            ->orderBy('cart_id','desc')->limit(10)->get();
            $user_info = User::Where('id',$userId)->get();

            $count_cart = Carts::where('cart_user',$userId)->sum('cart_quantity'); 

            return view('pages.cart.show_cart')->with('cartOfUser',$cartOfUser)->with('user_info',$user_info)->with('count_cart',$count_cart);
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
