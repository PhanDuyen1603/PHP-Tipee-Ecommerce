@extends('admin.layouts.app')
<?php
if(isset($data_code)){
    $title = $data_code->code;
    $post_title = $data_code->code;
    $expired = $data_code->expired;
    $type = $data_code->type;
    $percent = $data_code->percent;
    $discount_money = $data_code->discount_money;
    $apply_for_order = $data_code->apply_for_order;
    $status = $data_code->status;
    $date_update = $data_code->updated_at;
    $sid = $data_code->id;
} else{
    $title = 'Create Discount Code';
    $post_title = Helpers::auto_code_discount();
    $expired = "";
    $type = "";
    $percent = "";
    $discount_money = "";
    $apply_for_order = "";
    $status = 0;
    $date_update = date('Y-m-d h:i:s');
    $sid = 0;
}
?>
@section('seo')
<?php
$data_seo = array(
    'title' => $title.' | '.Helpers::get_option_minhnn('seo-title-add'),
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => $title.' | '.Helpers::get_option_minhnn('seo-title-add'),
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
        <form action="{{route('admin.postDiscountCodeDetail')}}" method="POST" id="frm-create-page" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sid" value="{{$sid}}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3 class="card-title">Create Discount Code</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="form-group">
                                <label for="post_title">Mã giảm giá</label>
                                <input type="text" class="form-control" id="post_title" name="post_title" placeholder="Mã giảm giá" value="{{$post_title}}">
                            </div>
                            <div class="form-group">
                                <label>Ngày hết hạn:</label>
                                <div class="input-group date" id="expired" data-target-input="nearest">
                                    <input type="text" name="expired" class="form-control datetimepicker-input" data-target="#expired" value="{{$expired}}">
                                    <div class="input-group-append" data-target="#expired" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="order">Loại mã giảm giá</label>
                                <select name="type_discount" class="form-control">
                                    <option value="">Chọn loại mã giảm giá </option>
                                    <option value="onetime" @if($type == "onetime") selected @endif>Một lần</option>
                                    <option value="date" @if($type == "date") selected @endif>Theo thời gian</option>
                                </select>
                            </div>
                            <div class="b mb-1 mt-2">Chọn MỘT trong HAI loại giảm giá sau:</div>
                            <div class="form-group">
                                <label for="percent">Giảm theo phần trăm</label>
                                <input id="percent" type="text" name="percent" class="form-control" value="{{$percent}}">
                            </div>
                            <div class="form-group">
                                <label for="discount_money">Giảm theo giá trị cụ thể</label>
                                <input id="discount_money" type="text" name="discount_money" class="form-control" value="{{$discount_money}}">
                            </div>
                            <div class="form-group" style="display: none">
                                <label for="apply_for_order">Áp dụng cho đơn hàng có tổng giá trị:</label>
                                <input id="apply_for_order" type="text" name="apply_for_order" class="form-control" value="{{$apply_for_order}}">
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Publish</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioDraft" name="status" value="1" @if($status == 1) checked @endif>
                                    <label for="radioDraft">Draft</label>
                                </div>
                                <div class="icheck-primary d-inline" style="margin-left: 15px;">
                                    <input type="radio" id="radioPublic" name="status" value="0" @if($status == 0) checked @endif>
                                    <label for="radioPublic">Public</label>
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
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                </div> <!-- /.col-9 -->
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

        $('#expired').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        //xử lý validate
        $("#frm-create-page").validate({
            rules: {
                post_title: "required",
            },
            messages: {
                post_title: "Nhập mã giảm giá",
            },
            errorElement : 'div',
            errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });
    });
</script>
@endsection