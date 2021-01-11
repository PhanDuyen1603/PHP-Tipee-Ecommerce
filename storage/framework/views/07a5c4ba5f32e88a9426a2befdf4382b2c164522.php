
<?php $__env->startSection('content'); ?>
    <div id="__next">
        <div class="home-page">
            <main>
                <div class="Container-itwfbd-0 jFkAwY">
                    <div data-view-id="home_deal" class="TikiDeal__Wrapper-sc-1p33ah9-0 bjCkCy">
                        <div class="body">
                            <div id="home_sale">
                                <div class="header-title">
                                    <h3 class="title">Danh mục : "<?php echo e($category->categoryName); ?>"</h3>
                                </div>
                                <div class="home_flashdeal_container">
                                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make('partials.product_item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>
                            <div class="pagination-search">
                            <?php echo e($products->links()); ?>

                            </div>

                        </div>

                    </div>
                </div>
            </main>
            <span></span>
        </div>
        <div id="portal"></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/product/category.blade.php ENDPATH**/ ?>