<?php 


// Route xử lý cho admin

      Route::get('/login', 'Admin\LoginController@showLoginForm');
   	Route::post('/login', 'Admin\LoginController@login')->name('admin.login');
   	Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');
   	Route::group(['middleware' => ['auth:admin']], function () {
        

         Route::get('/', 'Admin\HomeController@index')->name('admin.dashboard');
         //change password
         Route::get('/change-password', 'Admin\AdminController@changePassword')->name('admin.changePassword');
         Route::post('/change-password', 'Admin\AdminController@postChangePassword')->name('admin.postChangePassword');

         //ajax delete
         Route::post('/delete-id', 'Admin\AjaxController@ajax_delete')->name('admin.ajax_delete');

         //ajax process
         Route::post('/ajax/process_theme_fast', 'Admin\AjaxController@processThemeFast')->name('admin.ajax.processThemeFast');
         Route::post('/ajax/process_new_item', 'Admin\AjaxController@update_new_item_status')->name('admin.ajax.process_new_item');
         Route::post('/ajax/process_flash_sale', 'Admin\AjaxController@update_process_flash_sale')->name('admin.ajax.process_flash_sale');
         Route::post('/ajax/process_sale_top_week', 'Admin\AjaxController@update_process_sale_top_week')->name('admin.ajax.process_sale_top_week');
         Route::post('/ajax/process_propose', 'Admin\AjaxController@update_process_propose')->name('admin.ajax.process_propose');
         Route::post('/ajax/process_store_status', 'Admin\AjaxController@updateStoreStatus')->name('admin.ajax.process_store_status');
         Route::post('/ajax/load_variable', 'Admin\AjaxController@loadVariable')->name('admin.ajax.load_variable');

         //Orders
         Route::get('/list-order', 'Admin\OrderController@listOrder')->name('admin.listOrder');
         Route::get('/search-order', 'Admin\OrderController@searchOrder')->name('admin.searchOrder');
         Route::get('/order/{id}', 'Admin\OrderController@orderDetail')->name('admin.orderDetail');
         Route::post('/order/post', 'Admin\OrderController@postOrderDetail')->name('admin.postOrderDetail');

   		//xử lý users
   		Route::get('/list-users', 'Admin\AdminController@listUsers')->name('admin.listUsers');
   		Route::get('/users/{id}', 'Admin\AdminController@userDetail')->name('admin.userDetail');
   		Route::post('/users/{id}', 'Admin\AdminController@postUserDetail')->name('admin.postUserDetail');
   		Route::get('/add-users', 'Admin\AdminController@addUsers')->name('admin.addUsers');
   		Route::post('/add-users', 'Admin\AdminController@postAddUsers')->name('admin.postAddUsers');

   		//Setting
   		Route::get('/theme-option', 'Admin\AdminController@getThemeOption')->name('admin.themeOption');
   		Route::post('/theme-option', 'Admin\AdminController@postThemeOption')->name('admin.postThemeOption');
   		Route::get('/menu', 'Admin\AdminController@getMenu')->name('admin.menu');

         //Page
         Route::get('/list-pages', 'Admin\PageController@listPage')->name('admin.pages');
         Route::get('/page/create', 'Admin\PageController@createPage')->name('admin.createPage');
         Route::get('/edit-page/{id}', 'Admin\PageController@pageDetail')->name('admin.pageDetail');
         Route::post('/page/post', 'Admin\PageController@postPageDetail')->name('admin.postPageDetail');

         //Post
         Route::get('/list-post', 'Admin\PostController@listPost')->name('admin.posts');
         // Route::get('/search-post', 'Admin\PostController@searchPost')->name('admin.searchPost');
         Route::get('/post/create', 'Admin\PostController@createPost')->name('admin.createPost');
         Route::get('/edit-post/{id}', 'Admin\PostController@postDetail')->name('admin.postDetail');
         Route::post('/post/post', 'Admin\PostController@postPostDetail')->name('admin.postPostDetail');

         //Category Post
         Route::get('/list-category-post', 'Admin\CategoryController@listCategoryPost')->name('admin.listCategoryPost');
         Route::get('/category-post/create', 'Admin\CategoryController@createCategoryPost')->name('admin.createCategoryPost');
         Route::get('/category-post/{id}', 'Admin\CategoryController@categoryPostDetail')->name('admin.categoryPostDetail');
         Route::post('/category-post/post', 'Admin\CategoryController@postCategoryPostDetail')->name('admin.postCategoryPostDetail');

         //Product
         Route::get('/list-products', 'Admin\ProductController@listProduct')->name('admin.listProduct');
         Route::get('/search-products', 'Admin\ProductController@searchProduct')->name('admin.searchProduct');
         Route::get('/product/create', 'Admin\ProductController@createProduct')->name('admin.createProduct');
         Route::get('/product/{id}', 'Admin\ProductController@productDetail')->name('admin.productDetail');
         Route::post('/product/post', 'Admin\ProductController@postProductDetail')->name('admin.postProductDetail');

        

         //Category Product
         Route::get('/list-category-product', 'Admin\CategoryProductController@listCategoryProduct')->name('admin.listCategoryProduct');
         Route::get('/search-category-product', 'Admin\CategoryProductController@searchCategoryProduct')->name('admin.searchCategoryProduct');
         Route::get('/category-product/create', 'Admin\CategoryProductController@createCategoryProduct')->name('admin.createCategoryProduct');
         Route::get('/category-product/{id}', 'Admin\CategoryProductController@categoryProductDetail')->name('admin.categoryProductDetail');
         Route::post('/category-product/post', 'Admin\CategoryProductController@postCategoryProductDetail')->name('admin.postCategoryProductDetail');

         

         //Brand
         Route::get('/list-brand', 'Admin\BrandController@listBrand')->name('admin.listBrand');
         Route::get('/brand/create', 'Admin\BrandController@createBrand')->name('admin.createBrand');
         Route::get('/brand/{id}', 'Admin\BrandController@brandDetail')->name('admin.brandDetail');
         Route::post('/brand/post', 'Admin\BrandController@postBrandDetail')->name('admin.postBrandDetail');

         //Slider Home
         Route::get('/list-slider', 'Admin\SliderController@listSlider')->name('admin.slider');
         Route::get('/slider/create', 'Admin\SliderController@createSlider')->name('admin.createSlider');
         Route::get('/slider/{id}', 'Admin\SliderController@sliderDetail')->name('admin.sliderDetail');
         Route::post('/slider/post', 'Admin\SliderController@postSliderDetail')->name('admin.postSliderDetail');

         
      });
      