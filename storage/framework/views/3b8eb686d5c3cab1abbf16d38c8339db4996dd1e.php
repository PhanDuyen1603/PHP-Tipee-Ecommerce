
<?php $__env->startSection('content'); ?>
<!--home-index-->
<div class="main_content details_product_bg clear">
   <div class="container clear">
      <div class="body-container border-group clear">
         <section id="section" class="section clear">
            <div class="group-section-wrap clear">
               <div class="leftContent clear">
                  <div class="clear single_theme_content clear">
                     <div class="listProduct clear" itemscope itemtype="http://schema.org/Article">
                        <meta itemprop="mainEntityOfPage" content="<?php echo URL::current(); ?>">
                        <meta itemprop="dateModified" content="<?php echo date('d-m-Y',strtotime($data_customers->updated)); ?>">
                        <time class="l hidden" itemprop="datePublished" datetime="<?php echo date('d-m-Y',strtotime($data_customers->updated)); ?>"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('d-m-Y',strtotime($data_customers->updated)); ?></time>
                        <span class="hidden" itemprop="author">Diệu Huyền</span>
                        <div class=" hidden thumbnail_post_article clear">
                           <div itemprop="image" itemscope itemtype="http://schema.org/ImageObject">
                              <?php list($widths_t, $heights_t) = @getimagesize($data_customers->thubnail); ?>
                              <img class="img_aso_thumb" itemprop="contentUrl url" src="<?php echo url('/').'/images/product/'.$data_customers->thubnail; ?>" alt="<?php echo e($data_customers->thubnail_alt); ?>">
                              <meta itemprop="width" content="<?php echo (!empty($widths_t))?$widths_t:'500'; ?>">
                              <meta itemprop="height" content="<?php echo (!empty($heights_t))?$heights_t:'375'; ?>">
                           </div>
                           <div class="author_post_asolute" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                              <figure class="img_aso_thumb_logo" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                                 <img itemprop="url" alt="aaaa" src="<?php echo e(asset('img/logo.png')); ?>">
                                 <meta itemprop="width" content="120">
                                 <meta itemprop="height" content="60">
                              </figure>
                              <meta itemprop="name" content="<?php echo e(route('index')); ?>">
                           </div>
                        </div>
                        <!--thumbnail_post_article--> 
                        <!--****************************************************-->
                        <link rel="stylesheet" href="<?php echo e(asset('css/foundation.css')); ?>">
                        <script type="text/javascript" src="<?php echo e(asset('js/modernizr.js')); ?>"></script>
                        <script type="text/javascript" src="<?php echo e(asset('js/xzoom.min.js')); ?>"></script>
                        <link rel="stylesheet" href="<?php echo e(asset('css/xzoom.css')); ?>">
                        <script type="text/javascript" src="<?php echo e(asset('js/jquery.hammer.min.js')); ?>"></script>
                        
                        <link rel="stylesheet" href="<?php echo e(asset('css/magnific-popup.css')); ?>">
                        <script type="text/javascript" src="<?php echo e(asset('js/jquery.fancybox.js')); ?>"></script>
                        <script type="text/javascript" src="<?php echo e(asset('js/magnific-popup.js')); ?>"></script>
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
                                          <?php echo $__env->make('layouts.gallery_theme_single', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                                             <img width="450" height="450" alt="<?php echo e($data_customers->title); ?>" src="<?php echo e($thumbnail_single); ?>"/>
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
                                             <div class="fb-like" data-href="<?php echo URL::current(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
                                          </li>
                                          <li class="fb_btn fb-like-tbn">
                                             <div class="fb-share-button" data-href="<?php echo URL::current(); ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"></div>
                                          </li>
                                       </ul>
                                       <!--social_tbl_like_group-->
                                       <div class="pro_view_name3 wishlist_detais_note">
                                          <ul class="add-to-links-wishlist">
                                             <?php
                                                // $is_login = 0;
                                                // if(Auth::check()){
                                                // 	$check_wishlist = App\Model\Wishlist::where('id_product' , '=' , $data_customers->id)
                                                // 		->where('user_id' , '=', Auth::user()->id)
                                                // 		->get();
                                                // 	$is_login = 1;
                                                // }
                                                ?>
                                             
                                          </ul>
                                       </div>
                                    </div>
                                    <!--social_single_news-->
                                    <script type="text/javascript" src="<?php echo e(asset('js/foundation.min.js')); ?>"></script>
                                    <script type="text/javascript" src="<?php echo e(asset('js/setup.js')); ?>"></script>
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

                                          <form action="<?php echo e(route('wishList.save')); ?>" method="POST">
                                             <?php echo csrf_field(); ?>
                                             <input type="hidden" name="wish_product" class="wish_product" value="<?php echo e($data_customers->id); ?>">
                                             <?php if(Auth::user()){?>
                                                <button type="submit" style="background-color:white; outline:none">
                                             <?php }else{ ?>
                                                <button type="button" style="background-color:white">
                                                <?php }?>
                                                <?php if($wishListOfUser != null){?>
                                                   <div class="icon-wrap" data-view-id="pdp_details_like"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-liked.svg"></div>

                                                <?php }else{?>
                                                   <div class="icon-wrap" data-view-id="pdp_details_like"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-like.svg"></div>

                                                   <?php }?>
                                             </button>
                                          </form>

                                          <div class="icon-wrap shareFB" data-view-id="pdp_details_share"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-account-social.svg"></div>
                                       </div>
                                       <div class="brand-block-row clear">
                                          <?php if($data_customers->id_brand > 0 ): ?>
                                          <div itemprop="brand" itemscope="" itemtype="http://schema.org/Brand">
                                             <meta itemprop="name" content="<?php
                                                echo ($brands_singles->brandName)?($brands_singles->brandName):''; ?>">
                                             <meta itemprop="url" content="<?php echo e(route('category.list',$brands_singles->brandSlug)); ?>">
                                          </div>
                                          <div class="item-brand">
                                             <h6>Thương hiệu: </h6>
                                             <p><?php echo ($brands_singles->brandName)?($brands_singles->brandName):''; ?>
                                             </p>
                                          </div>
                                          <?php endif; ?>
                                       </div>
                                       <?php if($data_customers->countdown == 1): ?>
                                       <?php if(strtotime($date2) < strtotime($date1) && strtotime($date2) > strtotime($date_start_event)): ?>
                                       <div class="daily-deal-item">
                                          <div class="daily-deal-info">
                                             <div class="count-down-pro">
                                                <div class="daily-timetxt">Hurry Up!</div>
                                                <div id="dailydeal-count-<?php echo e($data_customers->id); ?>">
                                                </div>
                                                <div id="expired" style="display:none;">
                                                   The deadline has passed.
                                                </div>
                                                <script type="text/javascript">
                                                   $(".xzoom").xzoom({tint: '#333', Xoffset: 15});
                                                   
                                                      jQuery("#dailydeal-count-<?php echo e($data_customers->id); ?>").timeTo({
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
                                                            <span class="cd_dld_detail_num"> - <?php echo e(intval($percent)); ?>%</span>
                                                         </li>
                                                         <li>
                                                            <span><i class="fa fa-check"></i>Tiết kiệm</span>
                                                            <span class="cd_dld_detail_num"><span class="price"><?php echo e($save); ?></span></span>
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
                                          <input type="hidden" id="price_current_view" value="<?php echo e($price_origin); ?>"/>
                                          <span id="price_12" class="price2 price_primary_container product-price">
                                          <span id="price_11 " class="price1 product-price__current-price">
                                          <?php echo e($price_promotion); ?>

                                          <?php if($price_promotion !=''): ?>
                                          <span><?php echo Helpers::get_option_minhnn('currency'); ?></span>
                                          <?php endif; ?> 
                                          </span>
                                          <?php echo e($price_origin); ?>

                                          <span><?php echo Helpers::get_option_minhnn('currency'); ?></span>
                                          </span>
                                          <span><?php if($html_percent != ''): ?>
                                          <?php echo $html_percent; ?>

                                          <?php endif; ?></span>
                                          </span>
                                       </ul>

                                       <div class="DeliveryZone__StyledDeliveryZoneEmpty-sc-1maxvle-0 lijGxt">
                                          <div class="inner">Bạn hãy <span>NHẬP ĐỊA CHỈ</span> nhận hàng để được dự báo thời gian &amp; chi phí giao hàng một cách chính xác nhất.</div>
                                       </div>
                                       
                                       <form action="<?php echo e(route('cart.save')); ?>" method="POST">
                                          <?php echo csrf_field(); ?>
                                       <div class="indexstyle__AddToCart-qd1z2k-7 fZaWsF add-to-cart">
                                          <div class="qty-and-message">
                                             <div class="QualityInput__Wrapper-sc-15mlmyf-0 iyaBQp">
                                                <p class="label">Số Lượng</p>
                                                <div class="group-input">
                                                   <button class="disable"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-remove.svg"></button>
                                                   <input name="input" type="text" value="1" class="input">
                                                   <button class="disable"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/pdp_revamp_v2/icons-add.svg"></button>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="group-button">                                            
                                             <input type="hidden" name="cart_product" class="cart_product" value="<?php echo e($data_customers->id); ?>">
                                             <?php if(Auth::user()){?>
                                                <input type="hidden" name="cart_user" class="cart_user" value="<?php echo e(Auth::user()->id); ?>">     
                                             <?php }else{?>
                                                <input type="hidden" name="cart_user" class="cart_user" value="17"> 
                                            <?php  }?>
                                             <?php
                                                if(Auth::user()){ ?>              
                                                <button type="submit" class="btn btn-add-to-cart" data-view-id="pdp_add_to_cart_button">Chọn mua</button>
                                             <?php }else{?>  
                                                <button type="button" id="btnBuy" class="btn btn-add-to-cart" data-view-id="pdp_add_to_cart_button">Chọn mua</button>
                                             <?php }?>  
                                          </div>
                                       </div>
                                       </form>
                                       <div class="container_bienthe_group <?php if($data_customers->group_combo != ''): ?> container_bienthe_group_combo <?php endif; ?> clear">
                                          <?php if($data_customers->group_combo == ''): ?>
                                          <div class="classlist">
                                             <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                                             <input type="hidden" name="group_combo" id="group_combo" value="">
                                          </div>
                                          <!--classlist-->
                                          <?php else: ?>
                                          <input type="hidden" name="group_combo" id="group_combo" value="<?php echo e($data_customers->group_combo); ?>">
                                          <?php
                                             $group_combo = unserialize($data_customers->group_combo);
                                             for ($i=0; $i < count($group_combo) ; $i++):
                                             $k=$i+1;
                                             ?>
                                          <div class="classlist">
                                             <input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">
                                          </div>
                                          <!--classlist-->
                                          <?php endfor; ?>
                                          <?php endif; ?>
                                       </div>
                                       <!--excerpt_detail_product-->
                                       
                                       <div class="order_product clear">
                                          <?php if($data_customers->store_status==1): ?>
                                          <?php else: ?>
                                          <a rel="nofollow" href="<?php echo \App\Libraries\Helpers::get_option_minhnn('fanpage'); ?>" target="_blank" class="btn_contact_use">
                                          <i class="fa fa-weixin" aria-hidden="true"></i> THÔNG BÁO KHI CÓ HÀNG
                                          </a>
                                          <?php endif; ?>
                                       </div>
                                       <!--order_product-->
                                       
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div> 
                        <!--product_detail-->
                        <!--***************************************************-->
                     </div>
                     <!--listNews-->
                     <?php if( ($data_customers->id_brand > 0) || $data_customers->product_detail_weight != ''|| $data_customers->product_detail_source != '' || $data_customers->product_detail_size != '' || $data_customers->product_detail_ingredients != '' || $data_customers->product_expiry_date != ''): ?>
                     <div class="detail_product_tab_view clear">
                        <h5 class="ingredients_title">Chi tiết sản phẩm</h5>
                        <div class="table_view_details_pr clear">
                           <table class="data-table" id="product-attribute-specs-table">
                              <tbody>
                                 <?php if($data_customers->id_brand > 0 ): ?>
                                 <tr>
                                    <th class="strong">Thương hiệu</th>
                                    <td class="data"><?php echo ($brands_singles->brandName)?($brands_singles->brandName):''; ?></td>
                                 </tr>
                                 <?php endif; ?>
                                 <?php if($data_customers->product_detail_weight !=''): ?>
                                 <tr>
                                    <th class="strong">Khối lượng</th>
                                    <td class="data"><?php echo e($data_customers->product_detail_weight); ?></td>
                                 </tr>
                                 <?php endif; ?>
                                 <?php if($data_customers->product_detail_source !=''): ?>
                                 <tr>
                                    <th class="strong">Xuất xứ</th>
                                    <td class="data"><?php echo e($data_customers->product_detail_source); ?></td>
                                 </tr>
                                 <?php endif; ?>
                                 <?php if($data_customers->product_detail_size !=''): ?>
                                 <tr>
                                    <th class="strong">Kích thước</th>
                                    <td class="data"><?php echo e($data_customers->product_detail_size); ?></td>
                                 </tr>
                                 <?php endif; ?>
                                 <?php if($data_customers->product_detail_ingredients !=''): ?>
                                 <tr>
                                    <th class="strong">Thành phần</th>
                                    <td class="data data_detail_ingredients">
                                       <?php echo htmlspecialchars_decode($data_customers->product_detail_ingredients); ?>
                                    </td>
                                 </tr>
                                 <?php endif; ?>
                                 <?php if($data_customers->product_expiry_date !=''): ?>
                                 <tr>
                                    <th class="strong">Hạn sử dụng</th>
                                    <td class="data"><?php echo e($data_customers->product_expiry_date); ?></td>
                                 </tr>
                                 <?php endif; ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <!--detail_product_tab_view-->
                     <?php endif; ?>
                     <div class="body">
                        <div class="summary">
                           <div class="left" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                              <link itemprop="availability" href="http://schema.org/InStock">
                              <meta itemprop="priceCurrency" content="VND">
                              <meta itemprop="price" content="189000">
                              <meta itemprop="url" content="https://tiki.vn/bo-san-pham-serum-khoang-phuc-hoi-chuyen-sau-vichy-mineral-89-p59569238.html">
                              <div class="price-and-icon ">
                                 
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
            
         </ul>
         <div class="tab-content box clear content group">
            <div id="contentDetails"  class="details-sumary single-product-box-content tab-pane in active">
               <?php //echo htmlspecialchars_decode($data_customers->content); ?>
               <?php echo Helpers::TableOfContents(htmlspecialchars_decode($data_customers->content)); ?>

            </div>
            <div id="sizeDetails" class="details-sumary single-product-box-content tab-pane">
               <div id="details-tab-container-single group">
                  <div class="comment-fb clear">
                     <div class="clear comment-facebook">
                        <div class="fb-comments" data-href="<?php echo URL::current(); ?>" data-width="100%" data-numposts="3"></div>
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



<section class="ratings">
   <div class="container">
      
      <h2 style="margin:50px;">ĐÁNH GIÁ SẢN PHẨM</h2>
   
      <?php $__currentLoopData = $ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div style="height:300px" class="card">
      <div class="card-body"> 
   
         <div class="card-title">
            <div style="display: flex" class="customer_comment_avatar">
            <img style="width: 50px; display:block;border-radius:50%" src="<?php echo e(asset('images/product/user.png')); ?>" alt="">
            <div  style="justify-content: center;
            align-items: center;
            display: flex;margin-left:30px;">
                  <h5><?php echo e($rating->name); ?></h5>
            </div>
            
            </div>             
         </div>
   
         <div class="card-text">
            <div class="customer_rating">
            <?php for($count=1; $count<=5 ;$count++): ?>
                  <?php
                     if($count <= $rating->rating_star){
                        $color = "#ffcc00";
                     }else{
                        $color="#ccc";
                     }
                  ?>
                  <li
                  class="ratingClass"
                  style="cursor: pointer; color:<?php echo e($color); ?>; font-size:30px; display: inline-block;"
                  > &#9733;
   
                  </li> 
            
            <?php endfor; ?>
            </div>
         <h5 class="card-text"><?php echo e($rating->rating_title); ?></h5>
         <p class="card-text"><?php echo e($rating->rating_content); ?></p>
         <p class="card-text"><small class="text-muted"><?php echo e($rating->created_at); ?></small></p>
         </div>  
      </div>
      </div>
   
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   
      <div class="card">
      <div class="card-body">
         <h5 class="card-title">GỬI NHẬN XÉT CỦA BẠN</h5>
      <?php 
               // $msg = "Option has been registered";
               // $url= route('admin.themeOption');
               // Helpers::msg_move_page($msg,$url);
      ?>
         <form action="<?php echo e(route('product.rating')); ?>"  method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
               <label class="form-label">1. Đánh giá của bạn về sản phẩm này:</label>
                  <ul class="list-inline">
                  <?php for($count=1; $count<=5 ;$count++): ?>
                     <?php
                        if($count <= $rating_star){
                           $color = "#ffcc00";
                        }else{
                           $color="#ccc";
                        }
                     ?>
                     <li
                        title="Đánh giá"
                        id="<?php echo e($data_customers->id); ?>-<?php echo e($count); ?>"
                        data-index="<?php echo e($count); ?>"
                        data-product_id="<?php echo e($data_customers->id); ?>"
                        data-rating="<?php echo e($rating_star); ?>"
                        class="ratingClass"
                        style="cursor: pointer; color:<?php echo e($color); ?>; font-size:30px; display: inline-block;"
                        > &#9733;
   
                     </li> 
                  
                  <?php endfor; ?>
                     
                  </ul>  
                  <input type="hidden" name="star" class="star">
                  <input type="hidden" name="proId" class="proId" value="<?php echo e($data_customers->id); ?>">
                  <input type="hidden" name="oldStar" class="oldStar" value="<?php echo e($rating_star); ?>">
                  

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
               <?php
                  if(Auth::user()){ ?>              
                  <button  type="submit" class="btn btn-warning btnRate">Gửi nhận xét</button>                
               <?php }else{?>  
                  <button  type="button" id="btnRate" class="btn btn-warning btnRate">Gửi nhận xét</button>     
               <?php }?>  
            </div>
         </form>
   
      </div>
   
      </div>
   </div>
 </section>
  

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
   <script>
      $(document).on('click','#btnRate',function(){
           alert('Vui lòng đăng nhập để dánh giá sản phẩm');
        
      });

      $(document).on('click','#btnBuy',function(){
           alert('Vui lòng đăng nhập chọn mua sản phẩm thoả thích');
        
      });
   </script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Lap-Trinh-Web-Team-Official\resources\views/product/single.blade.php ENDPATH**/ ?>