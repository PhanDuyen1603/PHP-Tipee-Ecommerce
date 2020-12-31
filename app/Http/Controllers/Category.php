<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // GỌI SỬ DỤNG DB
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class Category extends Controller
{
    //BEGIN XỬ LÝ CATEGORY CHO ADMIN
    public function AdminAuthCheck(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
          return Redirect::to('/dashboard');       
        }else{
          return Redirect::to('/admin')->send();
        }
    }

    public function add_category(){
        // $this->AdminAuthCheck();
        return view('admin.add_category');
    }
    public function all_category(){
        // $this->AdminAuthCheck();
        $all_category = DB::table('tbl_category')->orderby('category_id','desc')->get();
        //GỬI DỮ LIỆU QUA VIEW TỪ BIẾN $all_category -> all_category
        $manager_category = view('admin.all_category')->with('allCategories',$all_category);
        return view('admin_layout')->with('admin.all_category', $manager_category);
    }
    //Request lấy dữ liệu từ form tại views/add_category.blade.php
    public function save_category(Request $request){
        // $this->AdminAuthCheck();
        $data = array();

        $data['category_name'] = $request->categoryName; //'category_name' : table's column
        $data['category_desc'] = $request->categoryDesc;
        $data['category_status'] = $request->categoryStatus;

        DB::table('tbl_category')->insert($data);
        Session::put('message','Thêm danh mục sản phẩm thành công rực rỡ');
        return Redirect::to('add-category');
    }

    public function unactive_category($category_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_category')->where('category_id',$category_id)->update(['category_status'=> 0]);
        Session::put('message','Đã ẩn danh mục sản phẩm');
        return Redirect::to('all-category');
        
    }   
    public function active_category($category_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_category')->where('category_id',$category_id)->update(['category_status'=> 1]);
        Session::put('message','Đã hiển thị danh mục sản phẩm');
        return Redirect::to('all-category');
    }

    public function edit_category($category_id){
        // $this->AdminAuthCheck();
        $category_edit = DB::table('tbl_category')->where('category_id',$category_id)->get();
        $manager_edit_category = view('admin.edit_category')->with('edit_category',$category_edit);
        return view('admin_layout')->with('admin.edit_category', $manager_edit_category);
    }

    public function update_category(Request $request, $category_id){
        // $this->AdminAuthCheck();
        $data = array();
        $data['category_name'] = $request->categoryName; 
        $data['category_desc'] = $request->categoryDesc;

        DB::table('tbl_category')->where('category_id',$category_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công mỹ mãn');
        return Redirect::to('all-category');
    }

    public function delete_category($category_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_category')->where('category_id',$category_id)->delete();
        Session::put('message','Xoá danh mục sản phẩm thành công mỹ mãn');
        return Redirect::to('all-category');
    }

    //END XỬ LÝ CATEGORY CHO ADMIN

    //BEGIN XỬ LÝ CATEGORY CHO KHÁCH HÀNG
    public function show_category_home($category_id){
        $allCategories = DB::table('tbl_category')->orderby('category_id','desc')->get();
        $category_by_id = DB::table('tbl_category')->join('tbl_product','category_id','=','product_category')->where('category_id',$category_id)->get();
        $category_names = DB::table('tbl_category')->where('category_id',$category_id)->limit(1)->get() ;
        return view('pages.category.show_category')->with('allCategories', $allCategories)->with('category_by_id',$category_by_id)->with('category_names',$category_names);
    }
}
