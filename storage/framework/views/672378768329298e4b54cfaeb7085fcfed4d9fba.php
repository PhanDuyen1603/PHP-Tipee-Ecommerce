
<?php $__env->startSection('seo'); ?>
<title>404 Trang bạn truy cập không tồn tại - Thông tin doanh nghiệp</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div id="wrapper_container_fix" class="clear">
    	<div class="container clear">
    	    <div class="body-container border-group clear">
               <section id="section" class="section clear">
                      <div class="group-section-wrap clear row">
                            <div class="col-xs-12 col-sm-7 col-lg-7">
                               <!-- Info -->
                                <div class="info">
                                   <h1 class="opps">Oppps!</h1>
                                   <h2>Trang bạn truy cập không tồn tại!</h2>
                                   <p>Vui lòng nhập đường dẫn chính xác hoặc trở về Trang chủ</p>
                                   <div class="tbl_back clear">
                                    <a href="<?php echo e(url('/')); ?>" class="btn btn-info">Trang chủ</a>
                                   </div>
                               </div>
                               <!-- end Info -->
                            </div>
                            
                      </div><!--group-section-wrap-->
               </section><!--#section-->
            </div><!--body-container-->
    	</div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/errors/404.blade.php ENDPATH**/ ?>