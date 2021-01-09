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

class ProductController extends Controller
{
    public function single($slug){
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
        return view('product.single', compact('products','category'));
    }
    
}
