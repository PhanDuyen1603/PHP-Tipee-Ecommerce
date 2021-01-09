<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Category_Theme;
use App\Model\Theme;
use App\Model\Join_Category_Theme;
use App\Model\Rating;
use App\Model\Cart;

use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;


class ProductController extends Controller
{
    public function postAddRating(Request $request){
        $data = $request->all();
        $rating = new Rating();

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
        
        $rating->save();

        return redirect('http://127.0.0.1:8000/product-detail/'.$rating->rating_product);
    }



    public function product_detail($product_id){
        // 3 table: theme, category_theme, join_category_theme
        // theme.id = join_category_theme.id_theme,
        //category_theme.categoryID = join_category_theme.id_category_theme

        $data_product = Theme::where('theme.id',$product_id)->get();
        $category_theme = "16";
        

        // LẤY CÁC SẢN PHẨM LIÊN QUAN THÔNG QUA join_category_theme
        $related_product = Theme::join('join_category_theme', 'join_category_theme.id_theme', '=', 'theme.id')
        ->where('id_category_theme',$category_theme)->whereNotIn('theme.id',[$product_id])->get();
        
        // LẤY RATING
        $ratings = Rating::where('rating_product',$product_id)->orderBy('rating_id','desc')->limit(7)->get();

        $rating_star = Rating::where('rating_product',$product_id)->avg('rating_star');
        $rating_star = round($rating_star);


        //tạm thờI gán user bằng một cái đã, chưa làm user
        $userId = 1;
        $count_product = Cart::Where('cart_user',$userId)->sum('cart_quantity');

        return view('pages.product.show_detail')->with('data_product',$data_product)->with('related_product',$related_product)
        ->with('rating_star',$rating_star)->with('ratings',$ratings)->with('count_product',$count_product);;//->with('productDetails',$productDetails);
    }

   
}
