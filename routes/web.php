<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();

// GỌI CONTROLLERS
// CONTROLLERS ĐIỀU KHIỂN VIEWS
Route::get('/admin', ['as'  => 'admin', 'uses' =>'App\Http\Controllers\Admin\AdminController@dashboard']);

Route::get('customer/logout', ['as'  => 'CustomerLogout', 'uses' =>'App\Http\Controllers\Customer\CustomerLoginController@logout']);
 Route::post('/customers/login', array('as' => 'loginCustomerAction', 'uses' => 'App\Http\Controllers\Customer\CustomerLoginController@postLoginCustomer'));
Route::post('/customer/login','App\Http\Controllers\HomeController@postLoginCustomer')->name('loginCustomerAction');
//frontend
Route::get('category/{slug1}.html', array(
    'as' => 'category.list',
    'uses' => 'App\Http\Controllers\Frontend\CategoryController@category')
)->where('any', '(.*)\/$');
Route::get('admin/login', 'App\Http\Controllers\Admin\LoginController@showLoginForm')->name('login');

Route::get('/','App\Http\Controllers\HomeController@index')->name('index'); // DẤU / LÀ THƯ MỤC GỐC
Route::get('/trang-chu','App\Http\Controllers\HomeController@index')->name('index'); 
Route::post('/register-account','App\Http\Controllers\Frontend\HomeController@registerAccount')->name('register-account');

//CATEGORY HIỂN THỊ CHO KHÁCH HÀNG
Route::get('/search', 'App\Http\Controllers\Frontend\SearchController@search')->name('admin.searchPost');

Route::get('/san-pham/{slug}','App\Http\Controllers\Frontend\ProductController@productDetail')->name('product.detail');

// //CATEGORY ADMIN QUẢN LÝ
// Route::get('/add-category','App\Http\Controllers\Category@add_category');
// Route::get('/edit-category/{category_id}','App\Http\Controllers\Category@edit_category');
// Route::get('/delete-category/{category_id}','App\Http\Controllers\Category@delete_category');
// Route::get('/all-category','App\Http\Controllers\Category@all_category');
 
// Route::get('/unactive-category/{category_id}','App\Http\Controllers\Category@unactive_category');
// Route::get('/active-category/{category_id}','App\Http\Controllers\Category@active_category');

// Route::post('/save-category','App\Http\Controllers\Category@save_category');
// Route::post('/update-category/{category_id}','App\Http\Controllers\Category@update_category');

// //BRAND
// Route::get('/add-brand','App\Http\Controllers\Brand@add_brand');
// Route::get('/edit-brand/{brand_id}','App\Http\Controllers\Brand@edit_brand');
// Route::get('/delete-brand/{brand_id}','App\Http\Controllers\Brand@delete_brand');
// Route::get('/all-brand','App\Http\Controllers\Brand@all_brand');
// Route::get('/unactive-brand/{brand_id}','App\Http\Controllers\Brand@unactive_brand');
// Route::get('/active-brand/{brand_id}','App\Http\Controllers\Brand@active_brand');

// Route::post('/save-brand','App\Http\Controllers\Brand@save_brand');
// Route::post('/update-brand/{brand_id}','App\Http\Controllers\Brand@update_brand');

// //PRODUCT
// Route::get('/add-product','App\Http\Controllers\Product@add_product');
// Route::get('/edit-product/{product_id}','App\Http\Controllers\Product@edit_product');
// Route::get('/delete-product/{product_id}','App\Http\Controllers\Product@delete_product');
// Route::get('/all-product','App\Http\Controllers\Product@all_product');
 
// Route::get('/unactive-product/{product_id}','App\Http\Controllers\Product@unactive_product');
// Route::get('/active-product/{product_id}','App\Http\Controllers\Product@active_product');

// Route::post('/save-product','App\Http\Controllers\Product@save_product');
// Route::post('/update-product/{product_id}','App\Http\Controllers\Product@update_product');

//CART
Route::post('/save-cart','App\Http\Controllers\CartController@save_cart');
Route::post('/add-cart','App\Http\Controllers\CartController@add_cart'); //add-cart-ajax
Route::get('/show-cart','App\Http\Controllers\CartController@show_cart');




