@extends('layouts.app')
@section('seo')
<?php
	$title='Hot Deal | '.Helpers::get_option_minhnn('seo-title-add');;
	$description=$title.Helpers::get_option_minhnn('seo-description-add');
	$keyword=Helpers::get_option_minhnn('seo-keywords-add');
	$thumb_img_seo=url('/images/').'/logo_1397577072.png';
$data_seo = array(
    'title' => $title,
    'keywords' => $keyword,
    'description' =>$description,
    'og_title' => $title,
    'og_description' => $description,
    'og_url' => Request::url(),
    'og_img' => $thumb_img_seo,
    'current_url' =>Request::url(),
);
$seo = WebService::getSEO($data_seo);
?>
@include('partials.seo')
@endsection
@section('content')
    <div class="main_content hotdeal_category_page clear">
        <div class="container clear">
            <section class="body-container none_padding border-group clear">
                <section id="banner_hotdeal" class="section_art clear">
                    <div class="container_category_top_page clear">
                      {!! WebService::get_template_page('banner-hot-deal') !!}
                    </div>
                </section>
                <h1 class="title">
                    <span>Hot Deal</span>
                </h1>
                <section id="section" class="section clear">
                    <div class="group-section-wrap clear data_customer">
                        <div class="group-section-wrap clear row">
                            <div class="leftContent col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="row-content-category clear">
                                    <div class="listProduct box clear">
                                        <div class="list_theme_category product_category_container clear">
                                            @if(count($data_customers)>0)
                                                <div class="data_customer data_customer-listpro flex wrap">
                                                    <?php
                                                    $k=0; $thumbnail_thumb=""; $url_img=""; $ahref="";$price_origin="";$price_promotion="";$galleries="";$val_td=0;
                                                    $percent=0; ?>
                                                    @foreach($data_customers as $data_customer)
                                                    <?php
                                                      $k++;
                                                      $url_img='images/product';
                                                      $note_percent = '';
                                                      $note_new_item="";
                                                      $circle_sale='';
                                                      $note_best_seller = '';
                                                      $new_item = $data_customer->item_new;
                                                      //id category bán chạy = 69
                                                      $check_bestseller = DB::table('join_category_theme')
                                                          ->where('id_theme', '=', $data_customer->id)
                                                          ->where('id_category_theme', '=', 69)
                                                          ->get();
                                                      if(count($check_bestseller)>0){
                                                          $note_best_seller = '<span class="label bestseller">BEST</span>';
                                                      } else{
                                                          $note_best_seller = '';
                                                      }
                                                      if($new_item == 1){
                                                          $note_new_item = '<span class="label new">NEW</span>';
                                                      } else{
                                                          $note_new_item = '';
                                                      }
                                                      if(!empty($data_customer->thubnail) && $data_customer->thubnail !=""):
                                                        $thumbnail_thumb= Helpers::getThumbnail($url_img,$data_customer->thubnail,440, 440, "resize");
                                                        if(strpos($thumbnail_thumb, 'placehold') !== false):
                                                          $thumbnail_thumb=$url_img.$thumbnail_thumb;
                                                        endif;
                                                      else:
                                                        $thumbnail_thumb="https://dummyimage.com/450x450/000/fff";
                                                      endif;

                                                      //check event discount
                                                      $date_now = date("Y-m-d H:i:s");
                                                      $discount_for_brand = App\Model\Discount_for_brand::where('brand_id', '=', $data_customer->id_brand)
                                                          ->where('start_event', '<', $date_now)
                                                          ->where('end_event', '>', $date_now)
                                                          ->first();
                                                      if($discount_for_brand){
                                                          $price_origin=number_format($data_customer->price_origin)." đ ";
                                                          $price_promotion= $data_customer->price_origin - $data_customer->price_origin*$discount_for_brand->percent/100;
                                                          $price_promotion=number_format($price_promotion)." đ ";
                                                          $note_percent = '<span class="label sale">SALE</span>';
                                                          $circle_sale='<span class="circle-sale">
                                                              <span>-'.intval($discount_for_brand->percent).'%</span>
                                                          </span>';
                                                      } else{
                                                          if(!empty($data_customer->start_event) && !empty($data_customer->end_event)){
                                                              $date_start_event = $data_customer->start_event;
                                                              $date_end_event = $data_customer->end_event;
                                                              if(strtotime($date_now) < strtotime($date_end_event) && strtotime($date_now) > strtotime($date_start_event)){
                                                                  if(!empty($data_customer->price_origin) &&  $data_customer->price_origin >0):
                                                                      $price_origin=number_format($data_customer->price_origin)." đ ";
                                                                  else:
                                                                      $price_origin="";
                                                                  endif;
                                                                  if(!empty($data_customer->price_promotion) &&  $data_customer->price_promotion >0):
                                                                      $price_promotion=number_format($data_customer->price_promotion)." đ ";
                                                                  else:
                                                                      $price_promotion="Liên hệ";
                                                                  endif;

                                                                  if(intval($data_customer->price_promotion)<=intval($data_customer->price_origin) && $data_customer->price_promotion != 0 && $data_customer->price_origin != 0):
                                                                      $val_td=intval($data_customer->price_origin)-intval($data_customer->price_promotion);
                                                                      $percent=($val_td/intval($data_customer->price_origin))*100;
                                                                      // $note_percent="<span class='note_percent'>".intval($percent). "%</span>";
                                                                      $note_percent = '<span class="label sale">SALE</span>';
                                                                      $circle_sale='<span class="circle-sale">
                                                                          <span>-'.intval($percent).'%</span>
                                                                      </span>';
                                                                  else:
                                                                      $val_td=0;
                                                                      $percent=0;
                                                                      $note_percent="";
                                                                      $circle_sale='';
                                                                  endif;
                                                              } else{
                                                                  if(!empty($data_customer->price_origin) &&  $data_customer->price_origin >0){
                                                                      $price_origin="";
                                                                      $price_promotion= number_format($data_customer->price_origin)." đ ";
                                                                  }
                                                              }
                                                          }
                                                      }

                                                      $galleries=WebService::variableGalleryImageRender($data_customer->id);
                                                      if($galleries ==''):
                                                        $galleries=$thumbnail_thumb;
                                                      endif;
                                                    ?>
                                                  <div id="theme_cate_{{$k}}" class="item_product_list col col-lg-5ths item-page-category-product" data-open="0" data-id="{{$data_customer->id}}" >
                                                      <div class="product-item">
                                                          <div class="item-thumb">
                                                              <a class="effect zoom images-rotation" href="{{route('tintuc.details',array($data_customer->categorySlug,$data_customer->slug))}}" data-default="{{$thumbnail_thumb}}" data-images="{{$galleries}}">
                                                                <img src="{{$thumbnail_thumb}}" alt="{{$data_customer->thubnail_alt}}"/>
                                                                                              <span class="productlabels_icons clear">{!!$note_new_item!!}{!!$note_percent!!}{!!$note_best_seller!!}</span>
                                                              </a>
                                                              {!!$circle_sale!!}
                                                          </div>
                                                          <div class="pro_info">

                                                              <h3 class="titleProduct">
                                                                  <a href="{{route('tintuc.details',array($data_customer->categorySlug,$data_customer->slug))}}">{{$data_customer->title}}</a>
                                                              </h3>
                                                              <div class="product_price flex">
                                                                  <span class="price_sale">{{$price_promotion}}</span>
                                                                  <span class="current_price">{{$price_origin}}</span>

                                                              </div>

                                                          </div>
                                                      </div>
                                                  </div>
                                                  @endforeach
                                                </div><!--data_customer-listpro-->

                                                <div class="page_navi clear">
                                                  {!! $data_customers->links('vendor.pagination.custom-pagination') !!}
                                                </div><!--page_navi-->
                                            @else
                                               <div class="alert alert-danger">
                                                   <strong>Trống!</strong> Hiện tại chưa có bài viết nào cho mục này.
                                               </div>
                                            @endif
                                        </div><!--list_theme_category-->
                                    </div><!--listProduct-->
                                </div><!--data_customer-content-->
                            </div><!--leftContent-->
                            <div class="rightContent col-xs-12 col-sm-12 col-md-12">
                                @include('layouts.footer_public')
                            </div><!--rightContent-->
                        </div><!--group-section-wrap-->
                    </div>
                </section><!--section-->
            </div><!--body-container-->
        </div><!--container-->
    </div><!--main_content-->
@endsection
