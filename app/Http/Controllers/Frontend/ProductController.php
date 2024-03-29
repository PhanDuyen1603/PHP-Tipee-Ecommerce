<?php
namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;
use App\Models\User,DB;
use App\Model\CategoryProduct;
use App\Model\Product;
use App\Model\Ratings;
use App\Model\Carts;
use App\Model\Wishlist;

class ProductController extends Controller
{
    public function show_wishList(){
        if(Auth::user()){
            $userId = Auth::user()->id;
            
            $count_cart = Carts::where('cart_user',$userId)->sum('cart_quantity');  
            $wishListOfUser = WishList::Where('wish_user',$userId)->join('Products','Products.id','=','wish_product')
            ->orderBy('wish_id','desc')->get();           
        }
        return view('pages.product.show_wishList')->with('wishListOfUser',$wishListOfUser)->with('count_cart',$count_cart);
    }

    public function save_wishList(Request $request){
        $data = $request->all();
        if(Auth::user()){
            $userId = Auth::user()->id;
            $wishListOfUser = Wishlist::Where('wish_user',$userId)->where('wish_product',$data['wish_product'])->first();
            if($wishListOfUser != null){
                $wishListOfUser->delete();
            }else{
                $new_wishList = new Wishlist();
                $new_wishList['wish_user'] = $userId;
                $new_wishList['wish_product'] = $data['wish_product'];
                $new_wishList->save();
            }
        }
        return redirect()->back();
    }



    public function productDetail($slug){
        $data_customers = Product::where('slug',$slug)->first();
        $category = '';
        $wishTimes = 0;
        if(Auth::user()){
            $userId = Auth::user()->id;
            $count_cart = Carts::where('cart_user',$userId)->sum('cart_quantity');  
            $wishListOfUser = WishList::Where('wish_user',$userId)->Where('wish_product',$data_customers['id'])->first();
            
        }else{
            $count_cart = 0;
        }
       // LẤY RATING
       $ratings = Ratings::join('Users','Users.id','=','Ratings.rating_user')->where('rating_product',$data_customers->id)->orderBy('rating_id','desc')->limit(7)->get();
       $rating_star = Ratings::where('rating_product',$data_customers->id)->avg('rating_star');
       $rating_star = round($rating_star);

       $wishTimes = Wishlist::Where('wish_product',$data_customers['id'])->count();

        return view('product.single', compact('data_customers','category'))
        ->with('rating_star',$rating_star)->with('ratings',$ratings)->with('count_cart',$count_cart)->with('wishListOfUser',$wishListOfUser)->with('wishTimes',$wishTimes);
    }



    public function add_rating(Request $request){
         //rating
        
        $data = $request->all();
        $rating = new Ratings();

        $rating->rating_product = $data['proId'];
        if($data['star'] != null){
            $rating->rating_star = $data['star'];
        }else{
            $rating->rating_star = $data['oldStar'];
        }
       
        if($data['rating_title'] != null){
            $rating->rating_title = $data['rating_title'];
        }else{
            $rating->rating_title = "Không có tiêu đề";
        }
                   
        $rating->rating_content = $data['rating_content'];
        
        $rating->rating_user = Auth::user()->id;
        $rating->save();
        return redirect()->back();//->with('status', 'Email hoặc Password không chính xác');
        //return view('product.single', compact('data_customers','category'));
    }

    
    
}
