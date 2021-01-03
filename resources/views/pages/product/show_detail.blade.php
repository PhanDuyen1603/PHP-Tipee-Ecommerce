@extends('layouts.app')
@section('content') 

<!DOCTYPE html>
<html>
<head>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset('css/normalize.css')}}" />
    <link rel="stylesheet" href="{{asset('css/carousel.css')}}" />
    <link rel="stylesheet" href="{{asset('css/foundation_details.css')}}" />
    <link rel="stylesheet" href="{{asset('css/demo.css')}}" />
    <script src="{{asset('js/vendor/modernizr.js')}}"></script>
    <script src="{{asset('js/vendor/jquery.js')}}"></script>
    <!-- xzoom plugin here -->
    <script type="text/javascript" src="{{asset('dist/xzoom.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('css/xzoom_details.css')}}" media="all" /> 
    <!-- hammer plugin here -->
    <script type="text/javascript" src="{{asset('hammer.js/1.0.5/jquery.hammer.min.js')}}"></script>  
    <link type="text/css" rel="stylesheet" media="all" href="{{asset('magnific-popup/css/magnific-popup.css')}}" />
    <script type="text/javascript" src="{{asset('magnific-popup/js/magnific-popup.js')}}"></script>      
     {{--BOOTSTRAP  --}}
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>

<body>
  <div class="container">
    {{-- CHI TIẾT SẢN PHẨM BEGIN--}}
    @foreach($data_product as $key => $dataPro)
    <?php 
    $store_gallery = (isset($dataPro->gallery_images) || $dataPro->gallery_images != "") ? unserialize($dataPro->gallery_images) : '';
     ?>
    <section id="detail_product">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href=""></a>{{$dataPro->categoryName}}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{$dataPro->title}}</li>
                    </ol>
                </nav>
            </div>
           
            <div class="col-md-5">
              <div class="xzoom-container">
                <img class="xzoom5" id="xzoom-magnific" src="{{asset('images/product/'.$dataPro->thubnail)}}" xoriginal="{{asset('images/product/'.$dataPro->thubnail)}}" />
                <div class="xzoom-thumbs">         
                    <a href="{{asset('images/product/'.$dataPro->thubnail)}}"><img class="xzoom-gallery5" width="80" src="{{asset('images/product/'.$dataPro->thubnail)}}"  xpreview="{{asset('images/product/'.$dataPro->thubnail)}}" title="The description goes here"></a>
                    <?php for($j=1;$j<count($store_gallery);$j++): ?>
                        <a href="<?php echo '/images/product/'.$store_gallery[$j]; ?>"><img class="xzoom-gallery5" width="80" height="80" src="<?php echo '/images/product/'.$store_gallery[$j]; ?>" title="The description goes here"></a>
                    <?php endfor; ?>                
                </div>             
              </div>        
            </div>
          <div class="col-md-7">
              <div class="row">     
                {{-- HEADER --}}
                  <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-9">
                          <div class="details_header_brand">
                              <p style="font-size:12px">Thương hiệu: <a href="#">{{$dataPro->brandName}}</a>  |  Nhãn hiệu uy tín hàng đầu. Lọt top bán lẻ toàn cầu</p>
                          </div>
                          <div class="details_header_title">
                              <h4>{{$dataPro->title}}</h4>
                          </div>
                          <div class="details_header_rating">
                              <div class="star-rating">
                                <ul style="text-algin:left" class="list-inline">
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                  <li class="list-inline-item"><i class="fa fa-star-half-o"></i></li>
                                </ul>
                              </div>
                          </div>        
                      </div>
                        {{-- Yeu thich va chia se --}}
                        <div id="wish_share_icon" class="col-md-3">
                            <i  class="fa fa-heart"></i>
                            <i class="fa fa-code-branch"></i>
                        </div>
                  </div>                         
            </div>   
            {{-- /HEADER --}}
            {{-- BODY --}}
              <div class="col-md-8">
                  <div class="details_body_price">
                    <div style="background: linear-gradient(100deg, rgb(255, 66, 78), rgb(253, 130, 10));">
                      <span id="price_promotion">{{number_format($dataPro->price_promotion). ' đ'}}</span>
                      <br>
                      <?php $saleOff = round(100 - $dataPro->price_promotion / $dataPro->price_origin * 100) ?>
                      <span id="price_origin"><span>- <?php echo $saleOff . "%";?></span> <strike>{{number_format($dataPro->price_origin). ' đ'}}</strike></span>
                    </div>
                      
                  </div>
                  <div class="details_body_saleOff">

                  </div>
                  <div class="details_body_address">

                  </div>
              </div>
              <div class="col-md-4">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap in
              </div>
          </div>
      </div>
    </div>
    </section>   
    {{-- CHI TIẾT SẢN PHẨM END --}}
   

    {{-- SẢN PHẨM LIÊN QUAN BEGIN --}}
    <section id="related_product">
      <div class="container-xl">
        <div class="row">
          <div class="col-md-12">
            <h2>Sản phẩm tương tự</h2>
            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
            <!-- Carousel indicators -->
            <ol class="carousel-indicators">
              <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#myCarousel" data-slide-to="1"></li>
              <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>   
			<!-- Wrapper for carousel items -->
			<div class="carousel-inner">
				<div class="item carousel-item active">
					<div class="row">
            <?php for($j = 0 ; $j < 4; $j++): ?>
						<div class="col-sm-3">
							<div class="thumb-wrapper">
                <span class="wish-icon"><i class="fa fa-heart-o"></i></span>              
                  <div class="img-box">
                    <img src="{{asset('images/product/'.$related_product[$j]->thubnail)}}" class="img-fluid" alt="{{($related_product[$j]->title)}} ">
                  </div>
                  <div class="thumb-content">
                      <div class="related_product_title">
                        {{($related_product[$j]->title)}}  
                      </div>                  
                      <p class="item-price"><strike>{{number_format($related_product[$j]->price_origin). ' đ'}}</strike> <span>{{number_format($related_product[$j]->price_promotion). ' đ'}}</span></p>

                      <div class="star-rating">
                          <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                            <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                          </ul>
                      </div>                 
                    {{-- <a href="#" class="btn btn-primary">Add to Cart</a> --}}
                  </div>
              </div>  
            </div>	   
            <?php endfor; ?>         					
          </div>             
				</div>

        <?php if(count($related_product) > 4){?>

        <div class="item carousel-item">
  				<div class="row">
            <?php for($j = 4 ; $j < 8; $j++): ?>
						<div class="col-sm-3">
							<div class="thumb-wrapper">
                <span class="wish-icon"><i class="fa fa-heart-o"></i></span>            
								<div class="img-box">
									<img src="{{asset('images/product/'.$related_product[$j]->thubnail)}}" class="img-fluid" alt="{{($related_product[$j]->title)}} ">
								</div>
								<div class="thumb-content">
                    <div class="related_product_title">
                      {{($related_product[$j]->title)}}  
                    </div>                 
                    <p class="item-price"><strike>{{number_format($related_product[$j]->price_origin). ' đ'}}</strike> <span>{{number_format($related_product[$j]->price_promotion). ' đ'}}</span></p>                   
                    <div class="star-rating">
                        <ul class="list-inline">
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                        </ul>
                    </div>                    
                    {{-- <a href="#" class="btn btn-primary">Add to Cart</a> --}}
                </div>
              </div>  
             </div>	 
             <?php endfor; ?>                 					
          </div>            
        </div>

        <?php }elseif(count($related_product) > 8){?>
        <div class="item carousel-item">
					<div class="row">
            <?php for($j = 8 ; $j < 12; $j++): ?>
						<div class="col-sm-3">
							<div class="thumb-wrapper">
                <span class="wish-icon"><i class="fa fa-heart-o"></i></span>               
								<div class="img-box">
									<img src="{{asset('images/product/'.$related_product[$j]->thubnail)}}" class="img-fluid" alt="{{($related_product[$j]->title)}} ">
								</div>
								<div class="thumb-content">
                    <div class="related_product_title">
                      {{($related_product[$j]->title)}}  
                    </div>                 
                    <p class="item-price"><strike>{{number_format($related_product[$j]->price_origin). ' đ'}}</strike> <span>{{number_format($related_product[$j]->price_promotion). ' đ'}}</span></p>                   
                    <div class="star-rating">
                        <ul class="list-inline">
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star"></i></li>
                          <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                        </ul>
                    </div>                    
                    {{-- <a href="#" class="btn btn-primary">Add to Cart</a> --}}
                </div>
              </div>  
            </div>	 
            <?php endfor; ?>           					
          </div>             
        </div>
        <?php }?>

			</div>
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>

      </div>
      </div>
      </div>
                                  
    </section>     
    {{-- SẢN PHẨM LIÊN QUAN END --}}


  {{-- THÔNG TIN CHI TIẾT BEGIN --}}
  
    <section id="specifications">
        <div class="container">
          <h2>Thông tin chi tiết</h2>
            <table  style="margin-top:50px;"  class="table table-striped">
                <tbody>
                  <tr>
                    <td>Thương hiệu</td>
                    <td>{{$dataPro->brandName}}</td>
                  </tr>
                  <tr>
                      <td>Xuất xứ thương hiệu</td>
                      <td>{{$dataPro->brandOrigin}}</td>
                  </tr> 
                  <tr>
                    <td>Xuất xứ</td>
                    <td>{{$dataPro->brandOrigin}}</td>
                  </tr> 
                  <tr>
                    <td>SKU</td>
                    <td>4186406642092</td>
                  </tr> 
                </tbody>
                  
            </table>
        </div>
    </section>

  {{-- THÔNG TIN CHI TIẾT END --}}

  {{-- MÔ TẢ SẢN PHẨM BEGIN--}}
  <section id="descriptions">
    <div class="container">
      <h2>Mô tả sản phẩm</h2>
      <div  style="margin-top:50px;" class="description_text">

        <div id="card" class="card">
          <div  class="card-body">
            <h5 class="card-title">{{$dataPro->title}}</h5>
              <p id="post_content" class="card-text">
                {!!$dataPro->content!!}            
                <small class="text-muted">Last updated 3 mins ago</small>
              </p>
              
              <img style="width:300px" src="{{asset('images/product/'.$dataPro->thubnail)}}" class="card-img-bottom" alt="...">

          </div>
        </div>
        <div class="btnReadMore">
            <button onclick="showMoreText()" id="btnReadMore">Đọc thêm</button>
        </div>
       
      </div>
      
    </div> 
  </section>

  {{-- MÔ TẢ SẢN PHẨM END--}}

  @endforeach
  </div> <!-- /big container -->

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{asset('js/foundation_details.min.js')}}"></script>
    <script src="{{asset('js/setup_details.js')}}"></script>
    <script>
      $(document).ready(function(){
        $(".wish-icon i").click(function(){
          $(this).toggleClass("fa-heart fa-heart-o");
        });

       
      });	
    </script>
    <script>
          function showMoreText(){
            if( document.getElementById('btnReadMore').style.fontWeight == "500"){
              document.getElementById('btnReadMore').textContent = "Ẩn bớt";
              document.getElementById('card').style.height = "100%";
              document.getElementById('btnReadMore').style.fontWeight = "400"
            }
            else{
              document.getElementById('btnReadMore').textContent = "Đọc thêm";
              document.getElementById('card').style.height = "500px";
              document.getElementById('btnReadMore').style.fontWeight = "500";
            }
            
      }
    </script>
</body>
</html>


@endsection