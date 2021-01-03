@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'List Brand | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'List Brand | '.Helpers::get_option_minhnn('seo-title-add'),
    'og_description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_url' => Request::url(),
    'og_img' => asset('images/logo_seo.png'),
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
?>
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">List Brand</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Danh sách các thương hiệu</li>
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
		            	<h3 class="card-title">List Brand</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="btn btn-danger" onclick="delete_id('brand')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{route('admin.createBrand')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                            </li>
                        </ul>
                        <br/>
                        <table class="table table-bordered" id="table_index"></table>

                        <script>
                            $(function() {
                                let data2 ={!! $data_brand !!};
                                $('#table_index').DataTable({
                                    data: data2,
                                    columns: [
                                      {title: '<input type="checkbox" id="selectall" onclick="select_all()">', data: 'brandID'},
                                      {title: 'Thương hiệu', data: 'brandName'},
                                      {title: 'Nguồn gốc', data: 'brandOrigin'},
                                      {title: 'Ngày được thêm', data: 'created'},
                                    ],
                                    order: [[ 3, "desc" ]],
                                    columnDefs: [
                                        {//ID
                                            visible: true,
                                            targets: 0,
                                            className: 'text-center',
                                            orderable: false,
                                            render: function (data, type, full, meta) {
                                                return '<input type="checkbox" id="'+data+'" name="seq_list[]" value="'+data+'">';
                                            }
                                        },
                                        {//Title
                                            visible: true,
                                            targets: 1,
                                            className: 'text-center',
                                            render: function (data, type, full, meta) {
                                                return '<a href="{{route("admin.dashboard")}}/brand/' + full.brandID + '"><b>'+data+'</b></a>';
                                            }
                                        },
                                        {//Origin
                                            visible: true,
                                            targets: 2,
                                            className: 'text-center',
                                            render: function (data, type, full, meta) {                                            
                                                return data;
                                            }
                                        },
                                        {//Created
                                            visible: true,
                                            targets: 3,
                                            className: 'text-center',
                                            render: function (data, type, full, meta) {
                                                if(full.brandStatus == 0){
                                                    var st = 'Hiện';
                                                }else{
                                                    var st = 'Ẩn';
                                                }
                                                return data+'<br/>'+st;
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
@endsection