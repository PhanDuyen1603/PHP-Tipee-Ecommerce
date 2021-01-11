
<?php $__env->startSection('seo'); ?>
<?php
$data_seo = array(
    'title' => 'List User | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'List User | '.Helpers::get_option_minhnn('seo-title-add'),
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
        <h1 class="m-0 text-dark">List Users</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">List Users</li>
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
		            	<h3 class="card-title">List Users</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                  <table class="table table-bordered" id="users-table">
                    
                  </table>

                <script>
                $(function() {
                    let data2 =<?php echo $data_user; ?>;
                    $('#users-table').DataTable({
                        data: data2,
                        columns: [
                          {title: 'ID', data: 'id'},
                          {title: 'Name', data: 'name'},
                          {title: 'Email', data: 'email'},
                          {title: 'Created', data: 'created_at'},
                          {title: 'Updated', data: 'updated_at'},
                        ],
                        order: [[ 3, "desc" ]],
                        columnDefs: [
                        {//ID
                            visible: true,
                            targets: 0,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        },
                        {//date
                            visible: true,
                            targets: 1,
                            className: 'text-center a',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        },
                        {//name
                            visible: true,
                            targets: 2,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        },
                        {//name
                            visible: true,
                            targets: 3,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        },
                        {//name
                            visible: true,
                            targets: 4,
                            className: 'text-center',
                            render: function (data, type, full, meta) {
                                return data;
                            }
                        },
                        {//action
                            visible: true,
                            targets: 5,
                            title:"Action",
                            className: "text-center",
                            render: function (data, type, full, meta) {
                                return '<div class="group-action"><a id="showBtn" class="btn btn-info show" href="<?php echo e(url()->current()); ?>/' + full.id + '">Show</a><a id="deleteBtn" href="<?php echo e(url()->current()); ?>/delete/' + full.id + '" class="btn btn-danger delete" name="deleteBtn" type="button" >Delete</a></div>';
                            }
                        }
                    ],
                    });
                });
                </script>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/admin/users/index.blade.php ENDPATH**/ ?>