<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class Product extends Controller
{
    //BEGIN XỬ LÝ PRODUCT CỦA ADMIN

    public function AdminAuthCheck(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
          return Redirect::to('/dashboard');       
        }else{
          return Redirect::to('/admin')->send();
        }
    }
    
    public function add_product(){
        // $this->AdminAuthCheck();
        //LẤY TẤT CẢ CATEGORY VÀ BRAND GỬI QUA TRANG THÊM SẢN PHẨM
        $allCategories = DB::table('tbl_category')->orderby('category_id','desc')->get();
        $allBrands = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        return view('admin.add_product')->with('allCategories', $allCategories)->with('allBrands',$allBrands);
        
    }
    public function all_product(){
        // $this->AdminAuthCheck();
        $all_product = DB::table('tbl_product')->join('tbl_category','product_category','=','category_id')
        ->join('tbl_brand','product_brand','=','brand_id')->orderby('product_id','desc')->get();
        $manager_product = view('admin.all_product')->with('allProducts',$all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }
    //Request lấy dữ liệu từ form tại views/add_product.blade.php
    public function save_product(Request $request){
        // $this->AdminAuthCheck();
        $data = array();

        $data['product_name'] = $request->productName;
        $data['product_category'] = $request->productCategory;
        $data['product_brand'] = $request->productBrand;
        $data['product_desc'] = $request->productDesc;
        $data['product_content'] = $request->productContent;
        $data['product_price'] = $request->productPrice;
        $data['product_status'] = $request->productStatus;

        $get_image = $request->file('productImage');
        if($get_image){
            //NOTE: NHỚ KIỂM TRA LÀ FILE ẢNH
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); //current lấy phần tử đầu tiên, explode phân tách chuỗi dựa trên ký tự
            $new_image = $name_image.time().'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công rực rỡ');
            return Redirect::to('add-product');
        }
        $data['product_image'] = '';
        DB::table('tbl_product')->insert($data);
        Session::put('message','Thêm sản phẩm thành công rực rỡ');
        return Redirect::to('add-product');
       
    }

    public function unactive_product($product_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=> 0]);
        Session::put('message','Đã ẩn sản phẩm');
        return Redirect::to('all-product');
        
    }   
    public function active_product($product_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=> 1]);
        Session::put('message','Đã hiển thị sản phẩm');
        return Redirect::to('all-product');
    }

    public function edit_product($product_id){
        // $this->AdminAuthCheck();
        $allCategories = DB::table('tbl_category')->orderby('category_id','desc')->get();
        $allBrands = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        $product_edit = DB::table('tbl_product')->where('product_id',$product_id)->get();
        
        $manager_edit_product = view('admin.edit_product')->with('edit_product',$product_edit)
        ->with('allCategories',$allCategories)->with('allBrands',$allBrands);

        return view('admin_layout')->with('admin.edit_product', $manager_edit_product);
    }

    public function update_product(Request $request, $product_id){
        // $this->AdminAuthCheck();
        $data = array();
        $data['product_name'] = $request->productName;
        $data['product_category'] = $request->productCategory;
        $data['product_brand'] = $request->productBrand;
        $data['product_desc'] = $request->productDesc;
        $data['product_content'] = $request->productContent;
        $data['product_price'] = $request->productPrice;
        $data['product_status'] = $request->productStatus;

        // XỬ LÝ ẢNH
        $get_image = $request->file('productImage');
        if($get_image){
            //NOTE: NHỚ KIỂM TRA LÀ FILE ẢNH
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image)); //current lấy phần tử đầu tiên, explode phân tách chuỗi dựa trên ký tự
            $new_image = $name_image.time().'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công rực rỡ');
            return Redirect::to('all-product');
        }
        //NẾU KHÔNG CÓ ẢNH
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công mỹ mãn');
        return Redirect::to('all-product');
    }

    public function delete_product($product_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Xoá sản phẩm thành công mỹ mãn');
        return Redirect::to('all-product');
    }

    //END XỬ LÝ PRODUCT CỦA ADMIN

    //BEGIN XỬ LÝ PRODUCT CHO KHÁCH HÀNG

    public function product_detail($product_id){
        $allCategories = DB::table('tbl_category')->orderby('category_id','desc')->get();
        $allBrands = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        
        $productDetails = DB::table('tbl_product')
        ->join('tbl_category','product_category','=','category_id')
        ->join('tbl_brand','product_brand','=','brand_id')->where('product_id',$product_id)->get();


        //LẤY CATEGORY_ID ĐỂ LẤY CÁC SẢN PHẨM LIÊN QUAN
        foreach($productDetails as $key => $value)
        {
            $id_category = $value->category_id;
        } 

        $related_product =  DB::table('tbl_product')
        ->join('tbl_category','product_category','=','category_id')
        ->join('tbl_brand','product_brand','=','brand_id')->where('category_id',$id_category)
        ->whereNotIn('product_id',[$product_id])->get();

        return view('pages.product.show_detail')->with('allCategories',$allCategories)
        ->with('allBrands',$allBrands)->with('productDetails',$productDetails)->with('relatedProducts',$related_product);
    }


    //END XỬ LÝ PRODUCT CHO KHÁCH HÀNG
}
