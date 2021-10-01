
<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => 'Sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Sản phẩm | '.Helpers::get_option_minhnn('seo-title-add'),
    'og_description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_url' => Request::url(),
    'og_img' => asset('images/logo_seo.png'),
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Sản phẩm</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Sản phẩm</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
	    <div class="row">
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h3 class="card-title">Sản phẩm</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="<?php echo e(route('admin.createProduct')); ?>" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="<?php echo e(route('admin.searchProduct')); ?>" id="frm-filter-post" class="form-inline">
                                    <?php 
                                        $list_cate = App\Model\CategoryProduct::orderBy('category_products.categoryName', 'ASC')->select('category_products.categoryID', 'category_products.categoryName')->get();
                                    ?>
                                    <select class="custom-select mr-2" name="category_products">
                                        <option value="">Thể loại sản phẩm</option>
                                        <?php $__currentLoopData = $list_cate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cate->categoryID); ?>"><?php echo e($cate->categoryName); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fl" style="font-size: 17px;">
                                <b>Tổng</b>: <span class="bold" style="color: red; font-weight: bold;"><?php echo e($total_item); ?></span> sản phẩm
                            </div>
                            <div class="fr">
                                <?php echo $data_product->links(); ?>

                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Title</th>
                                        <th scope="col" class="text-center">Thumbnail</th>
                                        <th scope="col" class="text-center">Price</th>
                                        <th scope="col" class="text-center">Update</th>
                                        <th scope="col" class="text-center">Store Status</th>
                                        <th scope="col" class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $data_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="<?php echo e($data->id); ?>" name="seq_list[]" value="<?php echo e($data->id); ?>"></td>
                                        <td class="text-center" style="width: 250px;">
                                            <a class="row-title" href="<?php echo e(route('admin.productDetail', array($data->id))); ?>">
                                                <b><?php echo e($data->title); ?></b>
                                                <br>
                                                <b style="color:#c76805;"><?php echo e($data->slug); ?></b>  
                                                <?php
                                                $categories = \App\Model\Product::where('products.id', '=', $data->id)
                                                    ->join('join_category_product','products.id','=','join_category_product.id_product')
                                                    ->join('category_products','join_category_product.id_category_product','=','category_products.categoryID')
                                                    ->select('category_products.categoryID','category_products.categoryName','category_products.categorySlug')
                                                    ->orderBy('category_products.categoryParent','ASC')
                                                    ->get(); 
                                                if($categories): ?>
                                                <div class="list_cat_post_content_link">  
                                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a class="tag" target="_blank" href="#"><?php echo e($category->categoryName); ?></a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div> 
                                                <?php endif; ?>                          
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <?php if($data->thubnail != ''): ?>
                                                <img src="<?php echo e(asset('images/product/'.$data->thubnail)); ?>" style="height: 70px;">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('img/default-150x150.png')); ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center" style="width: 130px;">
                                            <div class="clear price_colum_item form-group">
                                                <label for="origin-price-<?php echo e($data->id); ?>">Giá gốc</label>
                                                <input id="origin-price-<?php echo e($data->id); ?>" class="colunm_price form-control" placeholder="Giá gốc" type="text" value="<?php echo e($data->price_origin); ?>" name="price_origin">
                                            </div>
                                            <div class="clear price_colum_item form-group">
                                                <label for="promotion-price-<?php echo e($data->id); ?>">Giá KM</label>
                                                <input id="promotion-price-<?php echo e($data->id); ?>" class="colunm_price form-control" placeholder="Giá khuyến mãi" type="text" value="<?php echo e($data->price_promotion); ?>" name="price_promotion">
                                            </div>
                                        </td>
                                       
                                      
                                        <td class="text-center">
                                            <button type="submit" class="btn btn-warning update_theme_fast" onclick="update_theme_fast(<?php echo e($data->id); ?>)" theme-id="<?php echo e($data->id); ?>" name="update_colunm">Update</button>
                                            <p id="alert_<?php echo e($data->id); ?>" class="text-center color_show_alert" style="display: none;"></p>
                                        </td>
                                        <td class="text-center">
                                            <input id="toggle-store-status-<?php echo e($data->id); ?>" class="toggle_store_status" onchange="store_status_click(<?php echo e($data->id); ?>)" postID="<?php echo e($data->id); ?>" type="checkbox" value="1" name="store_status" <?php if($data->store_status == 1): ?> checked <?php endif; ?> data-toggle="toggle">
                                        <div id="console_event_<?php echo e($data->id); ?>"></div>
                                        </td>
                                        <td class="text-center">
                                            <?php echo e($data->created); ?>

                                            <br>
                                            <?php if($data->status == 0): ?>
                                                Public
                                            <?php else: ?>
                                                Draft
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            <?php echo $data_product->links(); ?>

                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/admin/product/index.blade.php ENDPATH**/ ?>