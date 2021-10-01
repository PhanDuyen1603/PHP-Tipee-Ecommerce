
<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => 'List Orders | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'List Orders | '.Helpers::get_option_minhnn('seo-title-add'),
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
        <h1 class="m-0 text-dark">List Orders</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">List Orders</li>
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
		            	<h3 class="card-title">List Orders</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('order')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="<?php echo e(route('admin.searchOrder')); ?>" id="frm-filter-post" class="form-inline">
                                    <select class="custom-select mr-2" name="order_status">
                                        <option value="">Tình trạng đơn hàng</option>
                                        <option value="1">Mới đặt</option>
                                        <option value="2">Giao J&T</option>
                                        <option value="3">Đã hủy</option>
                                        <option value="4">Đợi xử lý</option>
                                        <option value="5">Liên hệ sau</option>
                                    </select>
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Mã đơn hàng">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                <?php echo $data_order->links(); ?>

                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Mã đơn hàng</th>
                                        <th scope="col" class="text-center">Họ tên</th>
                                        <th scope="col" class="text-center">Thời gian đặt</th>
                                        <th scope="col" class="text-center">Tổng giá trị</th>
                                        <th scope="col" class="text-center">Tình trạng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $data_order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="<?php echo e($data->cart_id); ?>" name="seq_list[]" value="<?php echo e($data->cart_id); ?>"></td>
                                        <td class="text-center">
                                            <a class="row-title" href="<?php echo e(route('admin.orderDetail', array($data->cart_id))); ?>">
                                                <b><?php echo e($data->cart_code); ?></b>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a class="row-title" href="<?php echo e(route('admin.orderDetail', array($data->cart_id))); ?>">
                                                <?php echo e($data->cart_hoten); ?>

                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <?php echo e($data->created); ?>

                                        </td>
                                        <td class="text-center">
                                            <span class='b' style='color: red;'><?php echo e(WebService::formatMoney12($data->cart_total)); ?> VNĐ</span>
                                        </td>
                                        <td class="text-center">
                                            <?php 
                                                switch ($data->cart_status) {
                                                    case 1:
                                                        echo "<span class='b' style='color: green;'>Mới đặt</span>";
                                                        break;
                                                    case 2:
                                                        echo "<span class='b' style='color: #ffa500;'>Giao J&T</span>";
                                                        break;
                                                    case 3:
                                                        echo "<span class='b' style='color: red;'>Đã hủy</span>";
                                                        break;
                                                    case 4:
                                                        echo "<span class='b' style='color: #ffb100;'>Đợi xử lý</span>";
                                                        break;
                                                    case 5:
                                                        echo "<span class='b' style='color: #0025db;'>Liên hệ sau</span>";
                                                        break;
                                                    default:
                                                        break;
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            <?php echo $data_order->links(); ?>

                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>