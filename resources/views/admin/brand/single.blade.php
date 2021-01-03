@extends('admin.layouts.app')

<?php
    if(isset($post_brand)){
        $title = $post_brand->brandName;
        $post_title = $post_brand->brandName;
        $post_origin = $post_brand->brandOrigin;
        $post_description = $post_brand->brandDescription;
        $status = $post_brand->brandStatus;
        $date_update = $post_brand->updated;

    } else{
        $title = 'Thêm thương hiệu';
        $post_title = '';
        $post_origin = '';
        $post_description = '';
        $status = 0;
        $date_update = date('Y-m-d h:i:s');
    }
?>

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{$title}}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="{{route('admin.postBrandDetail')}}" method="POST" id="frm-create-category" enctype="multipart/form-data">
            @csrf
            {{-- <input type="hidden" name="sid" value="{{$sid}}"> --}}
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3 class="card-title">{{$title}}</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="form-group">
                                <label for="post_title">Tên thương hiệu</label>
                                <input type="text" class="form-control title_slugify" id="post_title" name="post_title" placeholder="Tên thương hiệu" value="{{$post_title}}">
                            </div>
                            <div class="form-group">
                                <label>Xuất xứ thương hiệu</label>
                                <input type="text" class="form-control title_slugify" id="post_origin" name="post_origin" placeholder="Xuất xứ" value="{{$post_origin}}">
                            </div>
                            <div class="form-group">
                                <label for="post_description">Trích dẫn</label>
                                <textarea id="post_description" name="post_description">{!!$post_description!!}</textarea>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Hiển thị</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioDraft" name="status" value="1" @if($status == 1) checked @endif>
                                    <label for="radioDraft">Ẩn</label>
                                </div>
                                <div class="icheck-primary d-inline" style="margin-left: 15px;">
                                    <input type="radio" id="radioPublic" name="status" value="0" @if($status == 0) checked @endif>
                                    <label for="radioPublic">Hiện</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date:</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="created" class="form-control datetimepicker-input" data-target="#reservationdate" value="{{$date_update}}">
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->                   
                </div> <!-- /.col-3 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>

<script type="text/javascript">
    jQuery(document).ready(function ($){

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        $('#post_description').summernote({
            placeholder: 'Nhập trích dẫn',
            tabsize: 2,
            focus: true,
            height: 200,
            codemirror: { // codemirror options
                theme: 'monokai'
            }
        });

        $('#post_description_en').summernote({
            placeholder: 'Enter your description',
            tabsize: 2,
            focus: true,
            height: 200,    
            codemirror: { // codemirror options
                theme: 'monokai'
            }
        });
      
    });
</script>

@endsection