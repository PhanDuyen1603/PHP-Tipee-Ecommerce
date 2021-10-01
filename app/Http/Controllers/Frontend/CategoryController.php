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
use App\User,DB;
use App\Model\CategoryProduct;
use App\Model\Carts;

class CategoryController extends Controller
{
    public function category($slug){
        $category = CategoryProduct::where('categorySlug',$slug)->first();
        $products=DB::table('category_products')
        ->join('join_category_product','category_products.categoryID','=','join_category_product.id_category_product')
        ->join('products','join_category_product.id_product','=','products.id')
        ->where('category_products.categorySlug','=',$slug)
        ->where('products.status','=',0)
        ->orderBy('products.updated', 'DESC')
        ->groupBy('products.slug')
        ->select('products.*','category_products.categoryName','category_products.categorySlug','category_products.categoryDescription','category_products.categoryID','category_products.categoryContent')
        ->paginate(10);

        if(Auth::user()){
            $userId = Auth::user()->id;
            $count_cart = Carts::where('cart_user',$userId)->sum('cart_quantity');  
        }else{
            $count_cart = 0;
        }

        return view('product.category', compact('products','category'))->with('count_cart',$count_cart);
    }
    
}
