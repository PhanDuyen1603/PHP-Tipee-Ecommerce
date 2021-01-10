@extends('layouts.app')
@section('content') 

<!DOCTYPE html>
<html>
<head>
  @foreach($data_product as $key => $dataPro)

  <div class="fb-share-button" data-href="http://127.0.0.1:8000/" data-layout="button_count" data-size="large"><a target="_blank" 
    href="https://www.facebook.com/sharer/sharer.php?u={{('http://127.0.0.1:8000/product-detail/7527'.'/'.$data_product[0]->id)}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
  {{-- <meta name="description" content="{{$meta_desc}}"> --}}
  {{-- <meta name="keywords" content="{{$meta_keywords}}"/> --}}
  <meta name="description" content="{{($dataPro->content)}}">
  <meta name="keywords" content="xyz">
  <meta name="robots" content="INDEX,FOLLOW"/>
  {{-- <link  rel="canonical" href="{{$url_canonical}}" /> --}}
  <link  rel="canonical" href="{{('http://127.0.0.1:8000/product-detail/7527'.'/'.$dataPro->id)}}"/>
  <meta name="author" content="{{($dataPro->content)}}">
  <link  rel="icon" type="image/x-icon" href="" />


  {{-- <meta property="og:image" content="{{$image_og}}" /> --}}
  <meta property="og:image" content="{{asset('images/product/'.$dataPro->thubnail)}}" />
  <meta property="og:site_name" content="http://127.0.0.1:8000/" />
  {{-- <meta property="og:description" content="{{$meta_desc}}" /> --}}
  <meta property="og:description" content="{{($dataPro->content)}}" />
  {{-- <meta property="og:title" content="{{$meta_title}}" /> --}}
  <meta property="og:title" content="{{($dataPro->content)}}" />
  {{-- <meta property="og:url" content="{{$url_canonical}}" /> --}}
  <meta property="og:url" content="{{($dataPro->content)}}" />
  <meta property="og:type" content="{{($dataPro->content)}}" />

  
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    {{-- / --}}
    <link rel="stylesheet" href="{{asset('css/show_detail.css')}}" />


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

    <?php 
    $store_gallery = (isset($dataPro->gallery_images) || $dataPro->gallery_images != "") ? unserialize($dataPro->gallery_images) : '';
     ?>
    <section id="detail_product">
        <div class="row" style="margin: auto">
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
                              <h5>{{$dataPro->title}}</h5>
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
                      Giao đến địa chỉ: 36, Bờ Bao Tân Thằng, quận Tân Phúc, Hồ Chí Minh
                  </div>
                  <div class="add_to_cart">
                    <form action="http://127.0.0.1:8000/save-cart" method="POST">
                      {{-- <form> --}}
                      @csrf
                        <input name="qty" class="qty" type="number" min="1" value="1" />
                        <input name="cart_product" class="cart_product" type="hidden" value="{{$dataPro->id}}" />
                        <input id="productQuantity" type="hidden" value="{{$count_product}}">
                        <br> <br> 

                        <button type="submit"   class="btn btn-primary add-to-cart" data-id="{{$dataPro->id}}" name="add-to-cart">Thêm giỏ hàng</button>


                      
                      </form>
                  </div>
              </div>
              <div style="display:flex; flex-direction:column" class="col-md-4">
                <div style="max-height:215px;" class="card">
                  <div class="card-body" >
                        <div style="flex:1"  class="extra_logo">
                          <span >Cam kết chính hiệu bởi</span>
                          <img style="width:70px; border-radius:50%; text-align:center" src="../images/tipee-logo.png" alt="">
                      </div>
                       
                      <div style="flex:1" class="row" id="extra_commit">  
                        <div class="col-sm"><i class="far fa-check-circle commit_icon"></i><span>Hoàn tiền 110% nếu giả</span></div>
                        <div class="col-sm"><i class="far fa-smile-beam commit_icon"></i><span>Mở hộp kiểm tra nhận hàng</span></div>
                        <div class="col-sm"><i class="fas fa-undo-alt commit_icon"></i><span>Đổi trả sản phẩm lỗi</span></div>
                      </div>

                  </div>
                </div>
                
                
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
            <?php for($j = 4 ; $j < 5; $j++): ?>
						<div class="col-sm-3">
							<div class="thumb-wrapper">
                <span class="wish-icon"><i class="fa fa-heart-o"></i></span>            
								<div class="img-box">
                  
									<img src="{{asset('images/product/'.$related_product[4]->thubnail)}}" class="img-fluid" alt="{{($related_product[$j]->title)}} ">
                </div>
                <?php echo $related_product[$j]->thubnail;?>
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
        <?php } ?>  

        <?php if(count($related_product) > 8){?>
        <div class="item carousel-item">
					<div class="row">
            <?php for($j = 8 ; $j < count($related_product); $j++): ?>
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

{{--ĐÁNH GIÁ SẢN PHẨM BEGIN --}}
<section class="rating">

  {{-- SHOW RATING --}}
  <h2 style="margin:50px;">ĐÁNH GIÁ SẢN PHẨM</h2>

  @foreach($ratings as $key => $rating)
  <div style="height:300px" class="card">
    <div class="card-body"> 

      <div class="card-title">
        <div style="display: flex" class="customer_comment_avatar">
          <img style="width: 50px; display:block;border-radius:50%" src="{{asset('images/product/'.$dataPro->thubnail)}}" alt="">
          <div style="justify-content: center;
          align-items: center;
          display: flex;">
               <p>Phan Thị Mỹ Duyên</p>
          </div>
         
        </div>             
      </div>

      <div class="card-text">
        <div class="customer_rating">
          @for($count=1; $count<=5 ;$count++)
              @php
                  if($count <= $rating->rating_star){
                    $color = "#ffcc00";
                  }else{
                    $color="#ccc";
                  }
              @endphp
              <li
                class="ratingClass"
                style="cursor: pointer; color:{{$color}}; font-size:30px; display: inline-block;"
                > &#9733;

              </li> 
        
          @endfor
        </div>
      <h5 class="card-text">{{$rating->rating_title}}</h5>
      <p class="card-text">{{$rating->rating_content}}</p>
      <p class="card-text"><small class="text-muted">{{$rating->created_at}}</small></p>
      </div>  
    </div>
  </div>

  @endforeach

  <div class="card">
    <div class="card-body">
      <h5 class="card-title">GỬI NHẬN XÉT CỦA BẠN</h5>
    <?php 
            // $msg = "Option has been registered";
            // $url= route('admin.themeOption');
            // Helpers::msg_move_page($msg,$url);
    ?>
      <form action="http://127.0.0.1:8000/add-rating"  method="POST">
        @csrf
          <div class="mb-3">
            <label class="form-label">1. Đánh giá của bạn về sản phẩm này:</label>
              <ul class="list-inline">
                @for($count=1; $count<=5 ;$count++)
                  @php
                      if($count <= $rating_star){
                        $color = "#ffcc00";
                      }else{
                        $color="#ccc";
                      }
                  @endphp
                  <li
                    title="Đánh giá"
                    id="{{$dataPro->id}}-{{$count}}"
                    data-index="{{$count}}"
                    data-product_id="{{$dataPro->id}}"
                    data-rating="{{$rating_star}}"
                    class="ratingClass"
                    style="cursor: pointer; color:{{$color}}; font-size:30px; display: inline-block;"
                    > &#9733;

                  </li> 
                
                @endfor
                  
              </ul>  
              <input type="hidden" name="star" class="star">
              <input type="hidden" name="proId" class="proId" value="{{$dataPro->id}}">
              <input type="hidden" name="oldStar" class="oldStar" value="{{$rating_star}}">
          </div>
          <div class="mb-3">
            <label class="form-label">2. Tiêu đề của nhận xét</label>
            <input type="text" name="rating_title" id="rating_title"  class="form-control" placeholder="Nhập tiêu đề để nhận xét">
          </div>
          <div class="mb-3">
            <label class="form-label">3. Viết nhận xét của bạn vào bên dưới:</label>
            <textarea name="rating_content" id="rating_content" class="form-control" style="resize:none"  placeholder="Nhận xét của bạn về sản phẩm này" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <button  type="submit" class="btn btn-warning btnRate">Gửi nhận xét</button>        
          </div>
      </form>

    </div>
 
  </div>
 
</section>

{{--ĐÁNH GIÁ SẢN PHẨM END --}}
  @endforeach
  </div> <!-- /big container -->

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="{{asset('js/foundation_details.min.js')}}"></script>
    <script src="{{asset('js/setup_details.js')}}"></script>
    <script src="{{asset('js/rating.js')}}"></script>

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

    <script>
      function remove_background(product_id){
        for(var count = 1; count <= 5; count++){
          $('#' + product_id + '-' + count).css('color','#ccc');
        }
      }
      //hover
      $(document).on('mouseenter','.ratingClass',function(){
          var index = $(this).data("index");
          var product_id = $(this).data('product_id');

          remove_background(product_id);

          for(var count = 1; count <= index; count++){
            $('#' + product_id + '-' + count).css('color','#ffcc00');
          }
      });
      // 
     
      // click
      $(document).on('click','.ratingClass',function(){
          var index = $(this).data("index");
          var product_id = $(this).data('product_id');
          // remove_background(product_id);
          $('.star').val(index);
         
          for(var count = 1; count <= index; count++){
            $('#' + product_id + '-' + count).css('color','#ffcc00');
          }       
      });

     

    </script>

    <script script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
      $(document).ready(function(){
        var msg = $('#productQuantity').val();
        swal("Mua sắm thoả thích", "Bạn đã có " + msg +  " sản phẩm trong giỏ hàng", "success");
      });

    </script>

      <div id="fb-root"></div>

      <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v9.0" nonce="M21nxJGG"></script>
</body>
</html>


@endsection