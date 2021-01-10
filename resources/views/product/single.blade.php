@extends('layouts.app')
@section('content')
<!--home-index-->
<div class="main_content details_product_bg clear">
   <div class="container clear">
      <div class="body-container border-group clear">
         <section id="section" class="section clear">
            <div class="group-section-wrap clear">
               <div class="leftContent clear">
                  <div class="clear single_theme_content clear">
                     <div class="listProduct clear" itemscope itemtype="http://schema.org/Article">
                        <meta itemprop="mainEntityOfPage" content="{!!URL::current()!!}">
                        <meta itemprop="dateModified" content="<?php echo date('d-m-Y',strtotime($data_customers->updated)); ?>">
                        <time class="l hidden" itemprop="datePublished" datetime="<?php echo date('d-m-Y',strtotime($data_customers->updated)); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d-m-Y',strtotime($data_customers->updated)); ?></time>
                        <span class="hidden" itemprop="author">Diệu Huyền</span>
                        <div class=" hidden thumbnail_post_article clear">
                           <div itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                              <?php list($widths_t, $heights_t) = @getimagesize($data_customers->thubnail); ?>
                              <img class="img_aso_thumb" itemprop="contentUrl url" src="<?php echo url('/').'/images/product/'.$data_customers->thubnail; ?>" alt="{{$data_customers->thubnail_alt}}">
                              <meta itemprop="width" content="<?php echo (!empty($widths_t))?$widths_t:'500'; ?>">
                              <meta itemprop="height" content="<?php echo (!empty($heights_t))?$heights_t:'375'; ?>">
                           </div>
                           <div class="author_post_asolute" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                              <figure class="img_aso_thumb_logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                                 <img itemprop="url" alt="aaaa" src="{{ asset('img/logo.png') }}">
                                 <meta itemprop="width" content="120">
                                 <meta itemprop="height" content="60">
                              </figure>
                              <meta itemprop="name" content="{{route('index')}}">
                           </div>
                        </div>
                        <!--thumbnail_post_article--> 
                        <!--****************************************************-->
                        <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
                        <script type="text/javascript" src="{{asset('js/modernizr.js')}}"></script>
                        <script type="text/javascript" src="{{asset('js/xzoom.min.js')}}"></script>
                        <link rel="stylesheet" href="{{ asset('css/xzoom.css') }}">
                        <script type="text/javascript" src="{{asset('js/jquery.hammer.min.js')}}"></script>
                        {{--
                        <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.css') }}">
                        --}}
                        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
                        <script type="text/javascript" src="{{asset('js/jquery.fancybox.js')}}"></script>
                        <script type="text/javascript" src="{{asset('js/magnific-popup.js')}}"></script>
                        <style type="text/css">
                           .xzoom-source, .xzoom-preview {
                           z-index: 3;
                           /* top: 300px !important; */
                           }
                           .xzoom-hidden {
                           display: none !important;
                           }
                           /*.xzoom-lens{
                           width:150px !important;
                           height:150px !important;
                           }*/
                           #xzoom-default {
                           user-select: auto !important;
                           -webkit-user-drag: auto !important;
                           touch-action: auto !important;
                           }
                           #xzoom-thumbs{
                           max-width: 100% !important;
                           }
                        </style>
                        <div class="product_detail box clear entry-single-content">
                           <div class="clear product_detail_header">
                              <div class="row">
                                 <div id="singleProductImg" class="col-lg-5 col-md-7 col-sm-12 no-padding-xs">
                                    <div class="img_singleProduct clear">
                                       <div class="large-5 column clear">
                                          <?php
                                             $url_img='images/product';
                                             $store_gallery=(isset($data_customers->gallery_images) || $data_customers->gallery_images !="")?unserialize($data_customers->gallery_images) :'';
                                             if(count($store_gallery)>0): ?>
                                          @include('layouts.gallery_theme_single')
                                          <?php else:
                                             if(!empty($data_customers->thubnail) && $data_customers->thubnail !=""):
                                             		   $thumbnail_single= Helpers::getThumbnail($url_img,$data_customers->thubnail, 450, 450, "resize");
                                             	 if(strpos($thumbnail_single, 'placehold') !== false):
                                             		   $thumbnail_single=$url_img.$thumbnail_single;
                                             	  endif;
                                             else:
                                             	   $thumbnail_single="https://dummyimage.com/450x450/FFF/000";
                                             endif;
                                             ?>
                                          <div class="boxImg">
                                             <img width="450" height="450" alt="{{$data_customers->title}}" src="{{$thumbnail_single}}"/>
                                          </div>
                                          <?php endif; ?>
                                       </div>
                                       <!--large-5-->
                                       <div class="large-7 column"></div>
                                    </div>
                                    <div class="line-straight">
                                    </div>
                                    <!--img_singleProduct-->
                                    <div class="social_single_news clear">
                                       <!--this socail single new-->
                                       <ul class="social_like_single hidden">
                                          <li class="fb_btn fb-like-tbn">
                                             <div class="fb-like" data-href="{!!URL::current()!!}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                                          </li>
                                          <li class="fb_btn fb-like-tbn">
                                             <div class="fb-share-button" data-href="{!! URL::current() !!}" data-layout="button_count" data-size="small" data-mobile-iframe="true"></div>
                                          </li>
                                       </ul>
                                       <!--social_tbl_like_group-->
                                       <div class="pro_view_name3 wishlist_detais_note">
                                          <ul class="add-to-links-wishlist">
                                             <?php
                                                $is_login = 0;
                                                if(Auth::check()){
                                                	$check_wishlist = App\Model\Wishlist::where('id_product' , '=' , $data_customers->id)
                                                		->where('user_id' , '=', Auth::user()->id)
                                                		->get();
                                                	$is_login = 1;
                                                }
                                                ?>
                                             {{-- <li>
                                                <a href="javascript:void(0)" onclick="<?php
                                                   echo "addToWishList('".$data_customers->id."'); return false;";
                                                   ?>" class="link-wishlist" title="Add to Wishlist">
                                                @if(isset($check_wishlist) && count($check_wishlist) > 0)
                                                <i class="fa fa-heart" aria-hidden="true"></i> <span class="txt">Đã thích</span> ( <span class="ft"></span> ) 
                                                @else
                                                <i class="dslc-icon-ext-heart"></i> <span class="txt">Yêu thích</span> ( <span class="ft"></span> )
                                                @endif
                                                </a>
                                             </li> --}}
                                          </ul>
                                       </div>
                                    </div>
                                    <!--social_single_news-->
                                    <script type="text/javascript" src="{{asset('js/foundation.min.js')}}"></script>
                                    <script type="text/javascript" src="{{asset('js/setup.js')}}"></script>
                                 </div>
                                 <div id="fixed_content_detail_parent" class="col-lg-5 col-md-5 col-sm-12">
                                    <!--#fixed_content_detail_parent-->
                                    <?php
                                       $date_now = date("Y-m-d H:i:s");
                                       $val_td=0;
                                       $percent=0;
                                       
                                       
                                       
                                       ?>
                                    <div id="fixed_content_detail" class="content_detail-show clear">
                                       <h1 class="title_product_detail"><?php
                                          echo ($data_customers->title)?($data_customers->title):($data_customers->seo_title); ?></h1>
                                       <div class="style__StyledProductAction-sc-1b8sgmz-0 dafovQ">
                                          <div class="icon-wrap" data-view-id="pdp_details_like"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-like.svg"></div>
                                          <div class="icon-wrap shareFB" data-view-id="pdp_details_share"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-account-social.svg"></div>
                                       </div>
                                       <div class="brand-block-row clear">
                                          @if($data_customers->id_brand > 0 )
                                          <div itemprop="brand" itemscope="" itemtype="http://schema.org/Brand">
                                             <meta itemprop="name" content="<?php
                                                echo ($brands_singles->brandName)?($brands_singles->brandName):''; ?>">
                                             <meta itemprop="url" content="{{route('category.list',$brands_singles->brandSlug)}}">
                                          </div>
                                          <div class="item-brand">
                                             <h6>Thương hiệu: </h6>
                                             <p><?php echo ($brands_singles->brandName)?($brands_singles->brandName):''; ?>
                                             </p>
                                          </div>
                                          @endif
                                       </div>
                                       <?php if($data_customers->countdown == 1): ?>
                                       <?php if(strtotime($date2) < strtotime($date1) && strtotime($date2) > strtotime($date_start_event)): ?>
                                       <div class="daily-deal-item">
                                          <div class="daily-deal-info">
                                             <div class="count-down-pro">
                                                <div class="daily-timetxt">Hurry Up!</div>
                                                <div id="dailydeal-count-{{$data_customers->id}}">
                                                </div>
                                                <div id="expired" style="display:none;">
                                                   The deadline has passed.
                                                </div>
                                                <script type="text/javascript">
                                                   $(".xzoom").xzoom({tint: '#333', Xoffset: 15});
                                                   
                                                      jQuery("#dailydeal-count-{{$data_customers->id}}").timeTo({
                                                      	seconds: <?php echo $time_end_event; ?>,
                                                      	countdown: true,
                                                      	displayDays: 2,
                                                      	theme: "white",
                                                      	displayCaptions: true,
                                                      	fontSize: 32,
                                                      	captionSize: 14,
                                                      	languages: {
                                                      		en: { days: "Days",   hours: "Hours",  min: "Mins",  sec: "Secs" }
                                                      	},
                                                      	lang: "en"
                                                      });
                                                </script>
                                                <div class="cd_dld">
                                                   <div class="cd_dld_detail">
                                                      <ul>
                                                         <li>
                                                            <span><i class="fa fa-check"></i>Discount</span>
                                                            <span class="cd_dld_detail_num"> - {{intval($percent)}}%</span>
                                                         </li>
                                                         <li>
                                                            <span><i class="fa fa-check"></i>Tiết kiệm</span>
                                                            <span class="cd_dld_detail_num"><span class="price">{{$save}}</span></span>
                                                         </li>
                                                      </ul>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <?php endif; ?>
                                       <?php endif; ?>
                                       <?php
                                          ?>
                                       <div class="ratings hidden">
                                          <div class="rating-box">
                                             <div class="rating" style="width:89%"></div>
                                          </div>
                                          <p class="rating-links">
                                             <a href="javascript:void(0)" class="r-lnk" data-toggle="modal" data-target="#myReview" data-backdrop="false">Viết đánh giá</a>
                                          </p>
                                       </div>
                                       <?php 
                                          if(!empty($data_customers->price_origin) && !empty($data_customers->price_promotion) && $data_customers->price_promotion < $data_customers->price_origin):
                                             				$val_td=$data_customers->price_origin-$data_customers->price_promotion;
                                             				$percent=($val_td/$data_customers->price_origin)*100;
                                             				$price_origin= number_format($data_customers->price_origin);
                                             				 $price_promotion=number_format($data_customers->price_promotion);
                                             				$html_percent = '<span class="money_bottom">Tiết kiệm: <span class="percent">'.intval($percent).'%</span></span>';
                                             			else:
                                             				$val_td=0;
                                             				$percent=0;
                                             				$html_percent = '';
                                             			endif;
                                           ?>
                                       <ul class="price_single clear">
                                          <span class="newPrice_content">
                                          <input type="hidden" id="price_current_view" value="{{$price_promotion}}"/>
                                          <span id="price_12" class="price2 price_primary_container product-price">
                                          <span id="price_11 " class="price1 product-price__current-price">
                                          {{$price_origin}}
                                          @if($price_origin !='')
                                          <span>{!!Helpers::get_option_minhnn('currency')!!}</span>
                                          @endif 
                                          </span>
                                          {{$price_promotion}}
                                          <span>{!!Helpers::get_option_minhnn('currency')!!}</span>
                                          </span>
                                          <span>@if($html_percent != '')
                                          {!!$html_percent!!}
                                          @endif</span>
                                          </span>
                                       </ul>

                                       <div class="DeliveryZone__StyledDeliveryZoneEmpty-sc-1maxvle-0 lijGxt">
                                          <div class="inner">Bạn hãy <span>NHẬP ĐỊA CHỈ</span> nhận hàng để được dự báo thời gian &amp; chi phí giao hàng một cách chính xác nhất.</div>
                                       </div>
                                       
                                       <div class="indexstyle__AddToCart-qd1z2k-7 fZaWsF add-to-cart">
                                          <div class="qty-and-message">
                                             <div class="QualityInput__Wrapper-sc-15mlmyf-0 iyaBQp">
                                                <p class="label">Số Lượng</p>
                                                <div class="group-input"><button class="disable"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-remove.svg"></button><input type="text" value="1" class="input"><button><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-add.svg"></button></div>
                                             </div>
                                          </div>
                                          <div class="group-button"><button class="btn btn-add-to-cart" data-view-id="pdp_add_to_cart_button">Chọn mua</button></div>
                                       </div>

                                       <div class="container_bienthe_group @if($data_customers->group_combo != '') container_bienthe_group_combo @endif clear">
                                          @if($data_customers->group_combo == '')
                                          <div class="classlist">
                                             <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                             <input type="hidden" name="group_combo" id="group_combo" value="">
                                          </div>
                                          <!--classlist-->
                                          @else
                                          <input type="hidden" name="group_combo" id="group_combo" value="{{ $data_customers->group_combo }}">
                                          <?php
                                             $group_combo = unserialize($data_customers->group_combo);
                                             for ($i=0; $i < count($group_combo) ; $i++):
                                             $k=$i+1;
                                             ?>
                                          <div class="classlist">
                                             <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                          </div>
                                          <!--classlist-->
                                          <?php endfor; ?>
                                          @endif
                                       </div>
                                       <!--excerpt_detail_product-->
                                       {{-- <div class="box-tocart">
                                          <div class="hp-uu-dai row">
                                             <div class="title">
                                                <i class="fas fa-gift"></i>Ưu đãi
                                             </div>
                                          </div>
                                       </div>
                                       <div class="custom_item_detail clear">
                                          <div class="quantityProduct">
                                             <form class="form_quantity">
                                                <ul class="ul_quantity clear">
                                                   <li>Số Lượng</li>
                                                   <li>
                                                      <span class="btn btn-sm btn-quantity" onclick="addQuantityDetail(-1)">
                                                      <i class="fa fa-minus" aria-hidden="true"></i>
                                                      </span>
                                                   </li>
                                                   <li><input type="text" id="quantity" class="number_quantity" name="number_quantity" value="1"></li>
                                                   <li>
                                                      <span class="btn btn-sm btn-quantity" onclick="addQuantityDetail(1)">
                                                      <i class="fa fa-plus" aria-hidden="true"></i>
                                                      </span>
                                                   </li>
                                                   <li>
                                                      @if($data_customers->store_status==1)
                                                      Còn hàng
                                                      @endif
                                                   </li>
                                                </ul>
                                             </form>
                                          </div>
                                       </div>
                                       @if($data_customers->store_status==1)
                                       <div class="container_tbl_add_cart_view clear">
                                          <div class="addmorecart_content">
                                             <a id="btn_cart_primary" class="green_addtocart_btn btn-cart-list" data-id="{{$data_customers->id}}" data-name="{{$data_customers->title}}" data-summary="{{$data_customers->theme_code}}" data-price="{{@$price_pastion}}" data-quantity="1" data-image="{{url('/images/product/')."/".$data_customers->thubnail}}" data-option="">
                                             <i class="dslc-icon-ext-ecommerce_cart"></i> Thêm vào giỏ hàng
                                             </a>
                                          </div>
                                          <div class="cartbtn_bottom">
                                             <a id="buy_now_single_button" class="addToCart_btn_bottom btn-buy-now btn-cart-list"  data-id="{{$data_customers->id}}" data-name="{{$data_customers->title}}" data-summary="{{$data_customers->theme_code}}" data-price="{{@$price_pastion}}" data-quantity="1" data-image="{{url('/images/product/')."/".$data_customers->thubnail}}" data-option="">Mua ngay</a>
                                          </div>
                                       </div>
                                       <!--container_tbl_add_cart_view-->
                                       @endif --}}
                                       <div class="order_product clear">
                                          @if($data_customers->store_status==1)
                                          @else
                                          <a rel="nofollow" href="{!! \App\Libraries\Helpers::get_option_minhnn('fanpage') !!}" target="_blank" class="btn_contact_use">
                                          <i class="fa fa-weixin" aria-hidden="true"></i> THÔNG BÁO KHI CÓ HÀNG
                                          </a>
                                          @endif
                                       </div>
                                       <!--order_product-->
                                       {{--
                                       @include('layouts.help_support')
                                       --}}
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div> 
                        <!--product_detail-->
                        <!--***************************************************-->
                     </div>
                     <!--listNews-->
                     @if( ($data_customers->id_brand > 0) || $data_customers->product_detail_weight != ''|| $data_customers->product_detail_source != '' || $data_customers->product_detail_size != '' || $data_customers->product_detail_ingredients != '' || $data_customers->product_expiry_date != '')
                     <div class="detail_product_tab_view clear">
                        <h5 class="ingredients_title">Chi tiết sản phẩm</h5>
                        <div class="table_view_details_pr clear">
                           <table class="data-table" id="product-attribute-specs-table">
                              <tbody>
                                 @if($data_customers->id_brand > 0 )
                                 <tr>
                                    <th class="strong">Thương hiệu</th>
                                    <td class="data"><?php echo ($brands_singles->brandName)?($brands_singles->brandName):''; ?></td>
                                 </tr>
                                 @endif
                                 @if($data_customers->product_detail_weight !='')
                                 <tr>
                                    <th class="strong">Khối lượng</th>
                                    <td class="data">{{$data_customers->product_detail_weight}}</td>
                                 </tr>
                                 @endif
                                 @if($data_customers->product_detail_source !='')
                                 <tr>
                                    <th class="strong">Xuất xứ</th>
                                    <td class="data">{{$data_customers->product_detail_source}}</td>
                                 </tr>
                                 @endif
                                 @if($data_customers->product_detail_size !='')
                                 <tr>
                                    <th class="strong">Kích thước</th>
                                    <td class="data">{{$data_customers->product_detail_size}}</td>
                                 </tr>
                                 @endif
                                 @if($data_customers->product_detail_ingredients !='')
                                 <tr>
                                    <th class="strong">Thành phần</th>
                                    <td class="data data_detail_ingredients">
                                       <?php echo htmlspecialchars_decode($data_customers->product_detail_ingredients); ?>
                                    </td>
                                 </tr>
                                 @endif
                                 @if($data_customers->product_expiry_date !='')
                                 <tr>
                                    <th class="strong">Hạn sử dụng</th>
                                    <td class="data">{{$data_customers->product_expiry_date}}</td>
                                 </tr>
                                 @endif
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!--detail_product_tab_view-->
                     @endif
                     <div class="body">
                        <div class="summary">
                           <div class="left" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                              <link itemprop="availability" href="http://schema.org/InStock">
                              <meta itemprop="priceCurrency" content="VND">
                              <meta itemprop="price" content="189000">
                              <meta itemprop="url" content="https://tiki.vn/bo-san-pham-serum-khoang-phuc-hoi-chuyen-sau-vichy-mineral-89-p59569238.html">
                              <div class="price-and-icon ">
                                 {{-- <div class="style__StyledProductPrice-sc-15mbtqi-0 hJdJUx">
                                    <div class="product-price">
                                       <span class="product-price__current-price">189.000 ₫</span><span class="product-price__list-price">275.000 ₫</span><span class="product-price__discount-rate">-31%</span>
                                       <div class="box-beecost-btn-history-price" id="box-beecost-btn-history-price" style="all: initial;"></div>
                                    </div>
                                 </div>
                                 <div class="style-sc-11ucdwk-0 jbwqZc">
                                    <div class="item"><img class="icon" src="https://salt.tikicdn.com/ts/upload/2e/da/c9/4b9c0150392c753ccb65b2595500e9d6.png" width="130" height="24"><a data-view-index="0" data-view-id="pdp_minor_badge" class="view-more-link" href="https://hotro.tiki.vn/hc/vi/sections/900000370543-Ch%C6%B0%C6%A1ng-tr%C3%ACnh-R%E1%BA%BB-h%C6%A1n-ho%C3%A0n-ti%E1%BB%81n-" target="_blank"></a></div>
                                    <div class="item"></div>
                                 </div> --}}
                              </div>
                              
                              <div class="lazyload-placeholder"></div>
                           </div>
                           <div class="right">
                              <div class="style__StyledCurrentSeller-i5oomf-0 eDEtVI">
                                 <div class="seller-info">
                                    <div class="seller-description">Cam kết chính hiệu bởi</div>
                                    <div class="seller-icon-and-name">
                                       <img class="icon-store" src="https://salt.tikicdn.com/cache/w220/ts/seller/ee/fa/a0/98f3f134f85cff2c6972c31777629aa0.png">
                                       <div><a data-view-id="pdp_view_seller_info_button" class="seller-name"><span>Tipee Trading</span></a></div>
                                    </div>
                                 </div>
                                 <div class="style__StyledCustomerBenefits-sc-4w35vj-0 jbngMy">
                                    <div class="benefit-item compensation"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/icons/compensation.svg"><span>Hoàn tiền<br><b>
                                       111%
                                       </b><br></span>
                                    </div>
                                    <div class="benefit-item guarantee">
                                       <img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/guarantee.svg">
                                       <span>
                                          <!-- -->Mở hộp<br>kiểm tra<br>nhận hàng<!-- --> 
                                       </span>
                                    </div>
                                    <div class="benefit-item refund"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/icons/refund.svg"><span>Đổi trả trong<br><b>30 ngày</b><br>nếu sp lỗi</span></div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        
                     </div>
                     
                     </div>

                     
                     <!--listNews-->
                  </div>
                  
                  <!--single_theme_content-->
               </div>

               
               <!--leftContent-->
               <!--rightContent-->
            </div>
         </section>
         <!--section-->
      </div>
      <!--body-container-->
   </div>

   <div id="details-tab-container-single" class="clear">
      <div class="product_collateral clear">
         <ul class="nav txtUpper clear js-productInfoTab">
            <li class="contentDetailsTab nav-item">
               <a class="nav-link active jHTCJn" data-toggle="tab">Mô tả <span>Sản Phẩm</span></a>
            </li>
            {{-- <li class="sizeDetailTab nav-item">
               <a href="#sizeDetails" class="nav-link" data-toggle="tab">Bình luận</a>
            </li>
            <li class="usingDetailTab nav-item">
               <a href="#usingDetails" class="nav-link" data-toggle="tab">Đổi hàng - Vận chuyển</a>
            </li> --}}
         </ul>
         <div class="tab-content box clear content group">
            <div id="contentDetails"  class="details-sumary single-product-box-content tab-pane in active">
               <?php //echo htmlspecialchars_decode($data_customers->content); ?>
               {!!Helpers::TableOfContents(htmlspecialchars_decode($data_customers->content))!!}
            </div>
            <div id="sizeDetails" class="details-sumary single-product-box-content tab-pane">
               <div id="details-tab-container-single group">
                  <div class="comment-fb clear">
                     <div class="clear comment-facebook">
                        <div class="fb-comments" data-href="{!!URL::current()!!}" data-width="100%" data-numposts="3"></div>
                     </div>
                     <!--CommentFacebook-->
                  </div>
                  <!--comment-fb-->
               </div>
               <!--details-tab-container-single-->
            </div>
            <div id="usingDetails" class="details-sumary single-product-box-content tab-pane">
               <div id="usingPolicy" class="clear">
               </div>
            </div>
         </div>
      </div>
      <!--product_collateral-->
   </div>
   <!--container-->
</div>
<!--main_content-->
@endsection