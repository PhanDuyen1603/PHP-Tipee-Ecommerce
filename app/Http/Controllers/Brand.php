<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

session_start();

class Brand extends Controller
{
    // Kiểm tra đăNg nhập admin
    public function AdminAuthCheck(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
          return Redirect::to('/dashboard');       
        }else{
          return Redirect::to('/admin')->send();
        }
    }

    public function add_brand(){
        // $this->AdminAuthCheck();
        return view('admin.add_brand');
    }
    public function all_brand(){
        // $this->AdminAuthCheck();
        $all_brand = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        //GỬI DỮ LIỆU QUA VIEW TỪ BIẾN $all_brand -> all_brand
        $manager_brand = view('admin.all_brand')->with('allBrands',$all_brand);
        return view('admin_layout')->with('admin.all_brand', $manager_brand);
    }
    //Request lấy dữ liệu từ form tại views/add_brand.blade.php
    public function save_brand(Request $request){
        // $this->AdminAuthCheck();
        $data = array();

        $data['brand_name'] = $request->brandName; //'brand_name' : table's column
        $data['brand_desc'] = $request->brandDesc;
        $data['brand_status'] = $request->brandStatus;

        DB::table('tbl_brand')->insert($data);
        Session::put('message','Thêm thương hiệu sản phẩm thành công rực rỡ');
        return Redirect::to('add-brand');
    }

    public function unactive_brand($brand_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status'=> 0]);
        Session::put('message','Đã ẩn thương hiệu sản phẩm');
        return Redirect::to('all-brand');
        
    }   
    public function active_brand($brand_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_brand')->where('brand_id',$brand_id)->update(['brand_status'=> 1]);
        Session::put('message','Đã hiển thị thương hiệu sản phẩm');
        return Redirect::to('all-brand');
    }

    public function edit_brand($brand_id){
        // $this->AdminAuthCheck();
        $brand_edit = DB::table('tbl_brand')->where('brand_id',$brand_id)->get();
        $manager_edit_brand = view('admin.edit_brand')->with('edit_brand',$brand_edit);
        return view('admin_layout')->with('admin.edit_brand', $manager_edit_brand);
    }

    public function update_brand(Request $request, $brand_id){
        // $this->AdminAuthCheck();
        $data = array();
        $data['brand_name'] = $request->brandName; 
        $data['brand_desc'] = $request->brandDesc;

        DB::table('tbl_brand')->where('brand_id',$brand_id)->update($data);
        Session::put('message','Cập nhật thương hiệu sản phẩm thành công mỹ mãn');
        return Redirect::to('all-brand');
    }

    public function delete_brand($brand_id){
        // $this->AdminAuthCheck();
        DB::table('tbl_brand')->where('brand_id',$brand_id)->delete();
        Session::put('message','Xoá thương hiệu sản phẩm thành công mỹ mãn');
        return Redirect::to('all-brand');
    }
}
