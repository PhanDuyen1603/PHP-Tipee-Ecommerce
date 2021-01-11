@extends('layout')
@section('content')  <!-- lấy toàn bộ nội dung đặt trong section content -->

<div class="features_items">	
    @foreach($category_names as $key => $cate)
        <h2 class="title text-center">{{($cate->category_name)}}</h2>
    @endforeach

    @foreach($category_by_id as $key => $pro)
    <a href="{{URL::to('/product-detail'.'/'.$pro->product_id)}}">
	<div class="col-sm-4">
	   <div class="product-image-wrapper">
		  <div class="single-products">
			 <div class="productinfo text-center">
				<img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" alt="" />
				<h2>{{number_format($pro->product_price). ' '. 'đ'}}</h2>
				<p>{{($pro->product_name)}}</p>
				<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
			 </div>
		  </div>
		  <div class="choose">
			 <ul class="nav nav-pills nav-justified">
				<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
				<li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
			 </ul>
		  </div>
		</div>
    </div>
    </a>
	@endforeach
 </div>


		{{-- 2 tag div bên trang layout --}}
	{{-- </div>
</div> --}}
 <!-- /recommended_items-->
@endsection