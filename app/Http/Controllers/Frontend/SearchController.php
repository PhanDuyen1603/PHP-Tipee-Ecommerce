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

class SearchController extends Controller
{
    public function search(Request $request){
        if(isset($request->query_string)){
            $name_product = $request->query_string;
            $list_category=DB::table('category_products')
                ->whereNotIn('categoryID', [69])
                ->where('status_category','=',0)
                ->orderBy('categoryName', 'ASC')
                ->get();
            $data_customers=DB::table('category_products')
                ->join('join_category_product','category_products.categoryID','=','join_category_product.id_category_product')
                ->join('products','join_category_product.id_product','=','products.id')
                ->where('products.title', 'like', '%'.$name_product.'%')
                ->where('products.status','=',0)
                ->groupBy('products.slug')
                ->orderByRaw('products.order_short DESC')
                ->select('products.*','category_products.categoryName','category_products.categorySlug','category_products.categoryDescription','category_products.categoryID','category_products.categoryContent','category_products.categoryContent_en','category_products.categoryDescription_en')
                ->paginate(10);
                $data_customers->appends(['query_string' => $name_product]);

                return view('product.search')
                ->with('name_product',$name_product)
                    ->with('list_categories',$list_category)
                    ->with('productSearch',$data_customers);
        } else{
            return view('errors.404');
        }
    }
    
}
