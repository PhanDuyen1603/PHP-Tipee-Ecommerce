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

use Validator;
use Mail;
use Redirect;
use App\Libraries\Helpers;
use App\Facades\WebService;

class ProductController extends Controller
{
    public function product_detail($product_id){
        // 3 table: theme, category_theme, join_category_theme
        // theme.id = join_category_theme.id_theme,
        //category_theme.categoryID = join_category_theme.id_category_theme

        // LẤY CHI TIẾT SẢN PHẨM, 
        //TÊN DANH MỤC SẢN PHẨM, CÁC SẢN PHẨM LIÊN QUAN


        // $allCategories_theme = Category_Theme::orderBy('categoryID','desc')->get();
        // $allBrands = BrandModel::orderBy('brand_id','desc')->get();
        
        // $productDetails = Theme::find('id',$product_id);
        //$productDetails = Theme::where('id',$product_id)->get();


        //->join('category_theme','product_category','=','category_id')
        //->join('tbl_brand','product_brand','=','brand_id')->where('product_id',$product_id)->get();


        // //LẤY CATEGORY_ID ĐỂ LẤY CÁC SẢN PHẨM LIÊN QUAN
        // foreach($productDetails as $key => $value)
        // {
        //     $id_category = $value->category_id;
        // } 
        $data_product = Theme::join('join_category_theme', 'join_category_theme.id_theme', '=', 'theme.id')
        ->join('category_theme', 'category_theme.categoryID', '=', 'join_category_theme.id_category_theme')
        ->join('brand','brand.brandID','=','theme.id_brand')
        ->where('theme.id',$product_id)->get();

        foreach($data_product as $key => $value)
        {
            $category_theme = $value->categoryID;
        } 


        // LẤY CÁC SẢN PHẨM LIÊN QUAN THÔNG QUA join_category_theme
        $related_product = Theme::join('join_category_theme', 'join_category_theme.id_theme', '=', 'theme.id')
        ->where('id_category_theme',$category_theme)->whereNotIn('theme.id',[$product_id])->get();
        
        //->where('category_theme.categoryID', '=', $category)
        // $related_product =  DB::table('tbl_product')
        // ->join('tbl_category','product_category','=','category_id')
        // ->join('tbl_brand','product_brand','=','brand_id')->where('category_id',$id_category)
        // ->whereNotIn('product_id',[$product_id])->get();

        // return view('pages.product.show_detail')->with('allCategories',$allCategories)
        // ->with('allBrands',$allBrands)->with('productDetails',$productDetails)->with('relatedProducts',$related_product);
        return view('pages.product.show_detail')->with('data_product',$data_product)->with('related_product',$related_product);//->with('productDetails',$productDetails);
    }

}
