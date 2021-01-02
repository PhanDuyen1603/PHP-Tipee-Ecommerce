<?php 

// Route xử lý cho admin


       Route::get('/login', 'App\Http\Controllers\Admin\LoginController@showLoginForm');
   	Route::post('/login', 'App\Http\Controllers\Admin\LoginController@login')->name('admin.login');
   	Route::get('/logout', 'App\Http\Controllers\Admin\LoginController@logout')->name('admin.logout');
   	Route::group(['middleware' => ['auth:admin']], function () {
   		Route::get('/', 'App\Http\Controllers\Admin\HomeController@index')->name('admin.dashboard');

         //export excel
         Route::get('/export_customer', array('as' => 'admin.exportCustomer', 'App\Http\Controllers\Admin\uses' => 'AdminController@exportCustomer'));
         Route::get('/export_orders', array('as' => 'admin.exportOrders', 'App\Http\Controllers\Admin\uses' => 'AdminController@exportOrder'));
         Route::get('/export_products', array('as' => 'admin.exportProducts', 'App\Http\Controllers\Admin\uses' => 'AdminController@exportProduct'));

         //change password
         Route::get('/change-password', 'App\Http\Controllers\Admin\AdminController@changePassword')->name('admin.changePassword');
         Route::post('/change-password', 'App\Http\Controllers\Admin\AdminController@postChangePassword')->name('admin.postChangePassword');

         //ajax delete
         Route::post('/delete-id', 'App\Http\Controllers\Admin\AjaxController@ajax_delete')->name('admin.ajax_delete');

         //ajax process
         Route::post('/ajax/process_theme_fast', 'App\Http\Controllers\Admin\AjaxController@processThemeFast')->name('admin.ajax.processThemeFast');
         Route::post('/ajax/process_new_item', 'App\Http\Controllers\Admin\AjaxController@update_new_item_status')->name('admin.ajax.process_new_item');
         Route::post('/ajax/process_flash_sale', 'App\Http\Controllers\Admin\AjaxController@update_process_flash_sale')->name('admin.ajax.process_flash_sale');
         Route::post('/ajax/process_sale_top_week', 'App\Http\Controllers\Admin\AjaxController@update_process_sale_top_week')->name('admin.ajax.process_sale_top_week');
         Route::post('/ajax/process_propose', 'App\Http\Controllers\Admin\AjaxController@update_process_propose')->name('admin.ajax.process_propose');
         Route::post('/ajax/process_store_status', 'App\Http\Controllers\Admin\AjaxController@updateStoreStatus')->name('admin.ajax.process_store_status');
         Route::post('/ajax/load_variable', 'App\Http\Controllers\Admin\AjaxController@loadVariable')->name('admin.ajax.load_variable');

         //Orders
         Route::get('/list-order', 'App\Http\Controllers\Admin\OrderController@listOrder')->name('admin.listOrder');
         Route::get('/search-order', 'App\Http\Controllers\Admin\OrderController@searchOrder')->name('admin.searchOrder');
         Route::get('/order/{id}', 'App\Http\Controllers\Admin\OrderController@orderDetail')->name('admin.orderDetail');
         Route::post('/order/post', 'App\Http\Controllers\Admin\OrderController@postOrderDetail')->name('admin.postOrderDetail');

   		//xử lý users
   		Route::get('/list-users', 'App\Http\Controllers\Admin\AdminController@listUsers')->name('admin.listUsers');
   		Route::get('/users/{id}', 'App\Http\Controllers\Admin\AdminController@userDetail')->name('admin.userDetail');
   		Route::post('/users/{id}', 'App\Http\Controllers\Admin\AdminController@postUserDetail')->name('admin.postUserDetail');
   		Route::get('/add-users', 'App\Http\Controllers\Admin\AdminController@addUsers')->name('admin.addUsers');
   		Route::post('/add-users', 'App\Http\Controllers\Admin\AdminController@postAddUsers')->name('admin.postAddUsers');

   		//Setting
   		Route::get('/theme-option', 'App\Http\Controllers\Admin\AdminController@getThemeOption')->name('admin.themeOption');
   		Route::post('/theme-option', 'App\Http\Controllers\Admin\AdminController@postThemeOption')->name('admin.postThemeOption');
   		Route::get('/menu', 'App\Http\Controllers\Admin\AdminController@getMenu')->name('admin.menu');

         //Page
         Route::get('/list-pages', 'App\Http\Controllers\Admin\PageController@listPage')->name('admin.pages');
         Route::get('/page/create', 'App\Http\Controllers\Admin\PageController@createPage')->name('admin.createPage');
         Route::get('/edit-page/{id}', 'App\Http\Controllers\Admin\PageController@pageDetail')->name('admin.pageDetail');
         Route::post('/page/post', 'App\Http\Controllers\Admin\PageController@postPageDetail')->name('admin.postPageDetail');

         //Post
         Route::get('/list-post', 'App\Http\Controllers\Admin\PostController@listPost')->name('admin.posts');
         Route::get('/search-post', 'App\Http\Controllers\Admin\PostController@searchPost')->name('admin.searchPost');
         Route::get('/post/create', 'App\Http\Controllers\Admin\PostController@createPost')->name('admin.createPost');
         Route::get('/edit-post/{id}', 'App\Http\Controllers\Admin\PostController@postDetail')->name('admin.postDetail');
         Route::post('/post/post', 'App\Http\Controllers\Admin\PostController@postPostDetail')->name('admin.postPostDetail');

         //Category Post
         Route::get('/list-category-post', 'App\Http\Controllers\Admin\CategoryController@listCategoryPost')->name('admin.listCategoryPost');
         Route::get('/category-post/create', 'App\Http\Controllers\Admin\CategoryController@createCategoryPost')->name('admin.createCategoryPost');
         Route::get('/category-post/{id}', 'App\Http\Controllers\Admin\CategoryController@categoryPostDetail')->name('admin.categoryPostDetail');
         Route::post('/category-post/post', 'App\Http\Controllers\Admin\CategoryController@postCategoryPostDetail')->name('admin.postCategoryPostDetail');

         //Product
         Route::get('/list-products', 'App\Http\Controllers\Admin\ProductController@listProduct')->name('admin.listProduct');
         Route::get('/search-products', 'App\Http\Controllers\Admin\ProductController@searchProduct')->name('admin.searchProduct');
         Route::get('/product/create', 'App\Http\Controllers\Admin\ProductController@createProduct')->name('admin.createProduct');
         Route::get('/product/{id}', 'App\Http\Controllers\Admin\ProductController@productDetail')->name('admin.productDetail');
         Route::post('/product/post', 'App\Http\Controllers\Admin\ProductController@postProductDetail')->name('admin.postProductDetail');

         //Combo
         Route::get('/list-combo', 'App\Http\Controllers\Admin\ComboController@listCombo')->name('admin.listCombo');
         Route::get('/search-combo', 'App\Http\Controllers\Admin\ComboController@searchCombo')->name('admin.searchCombo');
         Route::get('/combo/create', 'App\Http\Controllers\Admin\ComboController@createCombo')->name('admin.createCombo');
         Route::get('/combo/{id}', 'App\Http\Controllers\Admin\ComboController@comboDetail')->name('admin.comboDetail');
         Route::post('/combo/post', 'App\Http\Controllers\Admin\ComboController@postComboDetail')->name('admin.postComboDetail');

         //Category Product
         Route::get('/list-category-product', 'App\Http\Controllers\Admin\CategoryProductController@listCategoryProduct')->name('admin.listCategoryProduct');
         Route::get('/search-category-product', 'App\Http\Controllers\Admin\CategoryProductController@searchCategoryProduct')->name('admin.searchCategoryProduct');
         Route::get('/category-product/create', 'App\Http\Controllers\Admin\CategoryProductController@createCategoryProduct')->name('admin.createCategoryProduct');
         Route::get('/category-product/{id}', 'App\Http\Controllers\Admin\CategoryProductController@categoryProductDetail')->name('admin.categoryProductDetail');
         Route::post('/category-product/post', 'App\Http\Controllers\Admin\CategoryProductController@postCategoryProductDetail')->name('admin.postCategoryProductDetail');

         //Variable Product
         Route::get('/list-variable-product', 'App\Http\Controllers\Admin\VariableProductController@listVariableProduct')->name('admin.listVariableProduct');
         Route::get('/search-variable-product', 'App\Http\Controllers\Admin\VariableProductController@searchVariableProduct')->name('admin.searchVariableProduct');
         Route::get('/variable-product/create', 'App\Http\Controllers\Admin\VariableProductController@createVariableProduct')->name('admin.createVariableProduct');
         Route::get('/variable-product/{id}', 'App\Http\Controllers\Admin\VariableProductController@variableProductDetail')->name('admin.variableProductDetail');
         Route::post('/variable-product/post', 'App\Http\Controllers\Admin\VariableProductController@postVariableProductDetail')->name('admin.postVariableProductDetail');

         //Brand
         Route::get('/list-brand', 'App\Http\Controllers\Admin\BrandController@listBrand')->name('admin.listBrand');
         Route::get('/brand/create', 'App\Http\Controllers\Admin\BrandController@createBrand')->name('admin.createBrand');
         Route::get('/brand/{id}', 'App\Http\Controllers\Admin\BrandController@brandDetail')->name('admin.brandDetail');
         Route::post('/brand/post', 'App\Http\Controllers\Admin\BrandController@postBrandDetail')->name('admin.postBrandDetail');

         //Slider Home
         Route::get('/list-slider', 'App\Http\Controllers\Admin\SliderController@listSlider')->name('admin.slider');
         Route::get('/slider/create', 'App\Http\Controllers\Admin\SliderController@createSlider')->name('admin.createSlider');
         Route::get('/slider/{id}', 'App\Http\Controllers\Admin\SliderController@sliderDetail')->name('admin.sliderDetail');
         Route::post('/slider/post', 'App\Http\Controllers\Admin\SliderController@postSliderDetail')->name('admin.postSliderDetail');

         //Discount Code
         Route::get('/list-discount-code', 'App\Http\Controllers\Admin\DiscountCodeController@listDiscountCode')->name('admin.discountCode');
         Route::get('/discount-code/create', 'App\Http\Controllers\Admin\DiscountCodeController@createDiscountCode')->name('admin.createDiscountCode');
         Route::get('/discount-code/{id}', 'App\Http\Controllers\Admin\DiscountCodeController@discountCodeDetail')->name('admin.discountCodeDetail');
         Route::post('/discount-code/post', 'App\Http\Controllers\Admin\DiscountCodeController@postDiscountCodeDetail')->name('admin.postDiscountCodeDetail');

         //Video Page
         Route::get('/list-video', 'App\Http\Controllers\Admin\VideoController@listVideo')->name('admin.listVideo');
         Route::get('/video/create', 'App\Http\Controllers\Admin\VideoController@createVideo')->name('admin.createVideo');
         Route::get('/video/{id}', 'App\Http\Controllers\Admin\VideoController@videoDetail')->name('admin.videoDetail');
         Route::post('/video/post', 'App\Http\Controllers\Admin\VideoController@postVideoDetail')->name('admin.postVideoDetail');
   	});