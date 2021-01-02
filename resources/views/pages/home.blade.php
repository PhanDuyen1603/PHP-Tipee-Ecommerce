@extends('layout')
@section('content')  <!-- lấy toàn bộ nội dung đặt trong section content -->

<!--features_items-->
<div class="features_items">	
	<h2 class="title text-center">Sản phẩm mới nhất</h2>
	@foreach($allProducts as $key => $pro)
	<div class="col-sm-4">
	   <div class="product-image-wrapper">
		  <div class="single-products">
			 <div class="productinfo text-center">
				<form>
					@csrf
					<input type="hidden" class="cart_product_id_{{$pro->product_id}}" value="{{$pro->product_id}}">
					<input type="hidden" class="cart_product_name_{{$pro->product_id}}" value="{{$pro->product_name}}">
					<input type="hidden" class="cart_product_image_{{$pro->product_id}}" value="{{$pro->product_image}}">
					<input type="hidden" class="cart_product_price_{{$pro->product_id}}" value="{{$pro->product_price}}">
					<input type="hidden" class="cart_product_qty_{{$pro->product_id}}" value="1 ">

					<a href="{{URL::to('product-detail/'.$pro->product_id)}}">
					<img src="{{URL::to('public/uploads/product/'.$pro->product_image)}}" alt="" />				
					<h2>{{number_format($pro->product_price). ' '. 'đ'}}</h2>
					<p>{{($pro->product_name)}}</p>
					</a>
					<button type="submit" name="add_to_cart" data-id_product="{{$pro->product_id}}" class="btn btn-default add-to-cart">Thêm giỏ hàng</button>
				</form>
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
	@endforeach
 </div>
 <!-- /features_items-->

<!--category-tab-->
 <div class="category-tab">
	<div class="col-sm-12">
	   <ul class="nav nav-tabs">
		  <li class="active"><a href="#tshirt" data-toggle="tab">T-Shirt</a></li>
	   </ul>
	</div>
	<div class="tab-content">
	   <div class="tab-pane fade active in" id="tshirt" >
		  <div class="col-sm-3">
			 <div class="product-image-wrapper">
				<div class="single-products">
				   <div class="productinfo text-center">
					  <img src="{{('public/frontend/images/gallery1.jpg')}}" alt="" />
					  <h2>$56</h2>
					  <p>Easy Polo Black Edition</p>
					  <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
 </div>
 <!--/category-tab-->

  <!--recommended_items-->
 <div class="recommended_items">
 	<h2 class="title text-center">recommended items</h2>
 	<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="item active">
				<div class="col-sm-4">
					<div class="product-image-wrapper">
						<div class="single-products">
							<div class="productinfo text-center">
								<img src="{{('public/frontend/images/recommend1.jpg')}}" alt="" />
								<h2>$56</h2>
								<p>Easy Polo Black Edition</p>
								<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- 2 tag div bên trang layout --}}
	{{-- </div>
</div> --}}
 <!-- /recommended_items-->
@endsection