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
            $list_category=DB::table('category_theme')
                ->whereNotIn('categoryID', [69])
                ->where('status_category','=',0)
                ->orderBy('categoryName', 'ASC')
                ->get();
            $data_customers=DB::table('category_theme')
                ->join('join_category_theme','category_theme.categoryID','=','join_category_theme.id_category_theme')
                ->join('theme','join_category_theme.id_theme','=','theme.id')
                ->where('theme.title', 'like', '%'.$name_product.'%')
                ->where('theme.status','=',0)
                ->groupBy('theme.slug')
                ->orderByRaw('theme.order_short DESC')
                ->select('theme.*','category_theme.categoryName','category_theme.categorySlug','category_theme.categoryDescription','category_theme.categoryID','category_theme.categoryContent','category_theme.categoryContent_en','category_theme.categoryDescription_en')
                ->paginate(10);
                return view('theme.search')
                ->with('name_product',$name_product)
                    ->with('list_categories',$list_category)
                    ->with('productSearch',$data_customers);
        } else{
            return view('errors.404');
        }
    }
    
}
