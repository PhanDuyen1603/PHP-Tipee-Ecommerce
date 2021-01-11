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
// Route::get('/admin', ['as'  => 'admin', 'uses' =>'Admin\AdminController@dashboard']);

Route::get('forget-password', 'Frontend\HomeController@forgetPassword')->name('forgetPassword');
Route::post('forget-password', 'Frontend\HomeController@actionForgetPassword')->name('actionForgetPassword');

Route::get('forget-password-step2/{token}', 'Frontend\HomeController@actionForgetPasswordStep2')->name('actionForgetPasswordStep2');
Route::post('forget-password-step-2', 'Frontend\HomeController@actionForgetPasswordStep3')->name('actionForgetPasswordStep3');

Route::get('login/token/{token}', ['as'  => 'loginMail', 'uses' =>'Frontend\HomeController@loginMail']);
Route::get('success-mail', ['as'  => 'users.mail.proceed', 'uses' =>'Frontend\HomeController@successMail']);

Route::get('customer/logout', ['as'  => 'CustomerLogout', 'uses' =>'Customer\CustomerLoginController@logout']);
 Route::post('/customers/login', array('as' => 'loginCustomerAction', 'uses' => 'Customer\CustomerLoginController@postLoginCustomer'));
Route::post('/customer/login','HomeController@postLoginCustomer')->name('loginCustomerAction');
//frontend
Route::get('category/{slug1}.html', array(
    'as' => 'category.list',
    'uses' => 'Frontend\CategoryController@category')
)->where('any', '(.*)\/$');
Route::get('admin/login', 'Admin\LoginController@showLoginForm')->name('login');

Route::get('/','HomeController@index')->name('index'); // DẤU / LÀ THƯ MỤC GỐC
Route::post('/register-account','Frontend\HomeController@registerAccount')->name('register-account');

//CATEGORY HIỂN THỊ CHO KHÁCH HÀNG
Route::get('/search', 'Frontend\SearchController@search')->name('admin.searchPost');

Route::get('/san-pham/{slug}','Frontend\ProductController@productDetail')->name('product.detail');

//RATING
Route::post('/add-rating','Frontend\ProductController@add_rating')->name('product.rating');


//CART
Route::post('/save-cart','Frontend\CartController@save_cart')->name('cart.save');
// Route::post('/add-cart','CartController@add_cart'); //add-cart-ajax
Route::get('/show-cart','Frontend\CartController@show_cart');



// //CATEGORY ADMIN QUẢN LÝ
// Route::get('/add-category','Category@add_category');
// Route::get('/edit-category/{category_id}','Category@edit_category');
// Route::get('/delete-category/{category_id}','Category@delete_category');
// Route::get('/all-category','Category@all_category');
 
// Route::get('/unactive-category/{category_id}','Category@unactive_category');
// Route::get('/active-category/{category_id}','Category@active_category');

// Route::post('/save-category','Category@save_category');
// Route::post('/update-category/{category_id}','Category@update_category');

// //BRAND
// Route::get('/add-brand','Brand@add_brand');
// Route::get('/edit-brand/{brand_id}','Brand@edit_brand');
// Route::get('/delete-brand/{brand_id}','Brand@delete_brand');
// Route::get('/all-brand','Brand@all_brand');
// Route::get('/unactive-brand/{brand_id}','Brand@unactive_brand');
// Route::get('/active-brand/{brand_id}','Brand@active_brand');

// Route::post('/save-brand','Brand@save_brand');
// Route::post('/update-brand/{brand_id}','Brand@update_brand');

// //PRODUCT
// Route::get('/add-product','Product@add_product');
// Route::get('/edit-product/{product_id}','Product@edit_product');
// Route::get('/delete-product/{product_id}','Product@delete_product');
// Route::get('/all-product','Product@all_product');
 
// Route::get('/unactive-product/{product_id}','Product@unactive_product');
// Route::get('/active-product/{product_id}','Product@active_product');

// Route::post('/save-product','Product@save_product');
// Route::post('/update-product/{product_id}','Product@update_product');





