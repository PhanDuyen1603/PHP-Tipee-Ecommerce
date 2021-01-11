@extends('admin.layouts.app')
<?php
if(isset($product_detail)){
    $title = $product_detail->title;
    //khai báo biến có trong product
    
    $post_title = $product_detail->title;
    $post_title_en = $product_detail->title_en;
    $post_slug = $product_detail->slug;
    $post_description = $product_detail->description;
    $post_description_en = $product_detail->description_en;
    $post_content = $product_detail->content;
    $post_content_en = $product_detail->content_en;
    $post_order = $product_detail->order_short;
    $gallery_checked = $product_detail->gallery_checked;
    $product_code = $product_detail->product_code;
    $price_origin = $product_detail->price_origin;
    $price_promotion = $product_detail->price_promotion;
    $start_event = $product_detail->start_event;
    $end_event = $product_detail->end_event;
    $store_status = $product_detail->store_status;
    $id_brand = (isset($product_detail->id_brand) || $product_detail->id_brand !="")?htmlspecialchars_decode($product_detail->id_brand) : 0;
    $countdown = (isset($product_detail->countdown) || $product_detail->countdown != "") ? ($product_detail->countdown) : 0;
    $store_gallery = (isset($product_detail->gallery_images) || $product_detail->gallery_images != "") ? unserialize($product_detail->gallery_images) : '';
    $product_detail_weight = (isset($product_detail->product_detail_weight) || $product_detail->product_detail_weight != "") ? $product_detail->product_detail_weight : '';
    $product_detail_size = (isset($product_detail->product_detail_size) || $product_detail->product_detail_size != "") ? $product_detail->product_detail_size : '';
    $product_detail_ingredients = (isset($product_detail->product_detail_ingredients) || $product_detail->product_detail_ingredients != "") ? $product_detail->product_detail_ingredients : '';
    $product_detail_source = (isset($product_detail->product_detail_source) || $product_detail->product_detail_source != "") ? $product_detail->product_detail_source : '';
    $product_expiry_date = (isset($product_detail->product_expiry_date) || $product_detail->product_expiry_date !="") ? $product_detail->product_expiry_date : '';
    $status = $product_detail->status;
    $thumbnail = $product_detail->thubnail;
    $thumbnail_alt = $product_detail->thubnail_alt;
    $date_update = $product_detail->updated;
    //khai báo biến SEO
    $seo_title = $product_detail->seo_title;
    $seo_keyword = $product_detail->seo_keyword;
    $seo_description = $product_detail->seo_description;
    $sid = $product_detail->id;

    $data_cats = \Illuminate\Support\Facades\DB::table('category_products')
        ->join('join_category_product','category_products.categoryID','=','join_category_product.id_category_product')
        ->where('join_category_product.id_product', $sid)
        ->select('category_products.categoryName','category_products.categorySlug','category_products.categoryID')
        ->first();
    $link_url_check="";
    if($data_cats):
        $slug_cat=$data_cats->categorySlug;
        $link_url_check="";
        $link_url_check=route('product.detail',$product_detail->slug);
    endif;
} else{
    $title = 'Sản phẩm mới';
    $post_title = "";
    $post_title_en = "";
    $post_slug = "";
    $post_description = "";
    $post_description_en = "";
    $post_content = "";
    $post_content_en = "";
    $post_order = 0;
    $gallery_checked = "";
    $color_system = "";
    $countdown = 0;
    $store_gallery = "";
    $product_code = "";
    $price_origin = 0;
    $price_promotion = 0;
    $start_event = "";
    $end_event = "";
    $id_brand = 0;
    $store_status = 1;
    $product_detail_weight = "";
    $product_detail_size = "";
    $product_detail_ingredients = "";
    $product_detail_source = "";
    $product_expiry_date = "";
    $status = 0;
    $thumbnail = "";
    $thumbnail_alt = "";
    $date_update = date('Y-m-d h:i:s');
    //khai báo biến SEO
    $seo_title = "";
    $seo_keyword = "";
    $seo_description = "";
    $sid = 0;
}
?>
@section('seo')
<?php
$data_seo = array(
    'title' => $title.' | '.Helpers::get_option_duyen('seo-title-add'),
    'keywords' => Helpers::get_option_duyen('seo-keywords-add'),
    'description' => Helpers::get_option_duyen('seo-description-add'),
    'og_title' => $title.' | '.Helpers::get_option_duyen('seo-title-add'),
    'og_description' => Helpers::get_option_duyen('seo-description-add'),
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
        <form action="{{route('admin.postProductDetail')}}" method="POST" id="frm-create-product" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="sid" value="{{$sid}}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3 class="card-title">{{$title}}</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <ul class="nav nav-tabs hidden" id="tabLang" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="vi-tab" data-toggle="tab" href="#vi" role="tab" aria-controls="vi" aria-selected="true">Tiếng việt</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                    <div class="form-group">
                                        <label for="post_title">Tên sản phẩm</label>
                                        <input type="text" class="form-control title_slugify" id="post_title" name="post_title" placeholder="Tiêu đề" value="{{$post_title}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="post_slug">Slug sản phẩm</label>
                                        <input type="text" class="form-control slug_slugify" id="post_slug" name="post_slug" placeholder="Slug" value="{{$post_slug}}">
                                        <?php if($sid>0): ?>
                                            <b style="color: #0000cc;">Demo Link:</b> <u><i><a  style="color: #F00;" href="<?php echo  $link_url_check; ?>" target="_blank"><?php echo  $link_url_check; ?></a></i></u>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group hidden">
                                        <label for="post_description">Trích dẫn</label>
                                        <textarea id="post_description" name="post_description">{!!$post_description!!}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="post_content">Mô tả sản phẩm</label>
                                        <textarea id="post_content" name="post_content">{!!$post_content!!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden">
                                <label for="product_code" class="title_txt">Mã số sản phẩm</label>
                                <input type="text" name="product_code" id="product_code" value="{{$product_code}}" class="form-control">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="price_origin" class="title_txt">Giá gốc</label>
                                    <input type="text" name="price_origin" id="price_origin" value="{{$price_origin}}" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="price_promotion" class="title_txt">Giá khuyến mãi</label>
                                    <input type="text" name="price_promotion" id="price_promotion" value="{{$price_promotion}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-row hidden">
                                <div class="form-group col-md-6">
                                    <label for="start_event" class="title_txt">Ngày bắt đầu</label>
                                    <div class="input-group date" id="start_event" data-target-input="nearest">
                                        <input type="text" name="start_event" class="form-control datetimepicker-input" data-target="#start_event" value="{{$start_event}}">
                                        <div class="input-group-append" data-target="#start_event" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6 hidden">
                                    <label for="end_event" class="title_txt">Ngày kết thúc</label>
                                    <div class="input-group date" id="end_event" data-target-input="nearest">
                                        <input type="text" name="end_event" class="form-control datetimepicker-input" data-target="#end_event" value="{{$end_event}}">
                                        <div class="input-group-append" data-target="#end_event" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group hidden hidden">
                                <label for="countdown" class="title_txt">Countdown</label>
                                <input id="countdown" type="checkbox" value="1" name="countdown" <?php if($countdown == 1): ?> checked <?php endif; ?> data-toggle="toggle">
                            </div>
                            
                            <!--End Biến thể create -->
                            <h3 class="hidden">Thông tin chi tiết</h3>
                            <div class="form-group hidden">
                                <label for="product_detail_weight" class="title_txt">Cân nặng</label>
                                <input type="text" name="product_detail_weight" id="product_detail_weight" value="{{$product_detail_weight}}" class="form-control">
                            </div>
                            <div class="form-group hidden">
                                <label for="product_detail_source" class="title_txt">Xuất xứ</label>
                                <input type="text" name="product_detail_source" id="product_detail_source" value="{{$product_detail_source}}" class="form-control">
                            </div>
                            <div class="form-group hidden">
                                <label for="product_detail_size" class="title_txt">Size</label>
                                <input type="text" name="product_detail_size" id="product_detail_size" value="{{$product_detail_size}}" class="form-control">
                            </div>
                            <div class="form-group hidden">
                                <label for="product_expiry_date" class="title_txt">Hạn sử dụng</label>
                                <input type="text" name="product_expiry_date" id="product_expiry_date" value="{{$product_expiry_date}}" class="form-control">
                            </div>
                            <div class="form-group hidden">
                                <label for="post_order" class="title_txt">Thành phần</label>
                                <textarea name="product_detail_ingredients" id="product_detail_ingredients" rows="10" class="mceEditor form-control mce" placeholder="Thành phần sản phẩm">{!!$product_detail_ingredients!!}</textarea>
                            </div>
                            <div class="form-group hidden">
                                <label for="post_order" class="title_txt">Sắp xếp (Số càng lớn thứ tự càng cao)</label>
                                <input type="text" name="post_order" id="post_order" value="{{$post_order}}" class="form-control">
                            </div>
                            <div class="form-group hidden">
                                <label for="store_status" class="title_txt">Tình trạng(Còn hàng/ hết hàng)</label>
                                <input id="store_status" type="checkbox" value="1" name="store_status" <?php if($store_status == 1): ?> checked <?php endif; ?> data-toggle="toggle">
                            </div>
                            <div class="form-group hidden">
                                <label for="gallery_checked" class="title_txt">Gallery Checked</label>
                                <input id="gallery_checked" type="checkbox" value="1" name="gallery_checked" <?php if($gallery_checked == 1): ?> checked <?php endif; ?> data-toggle="toggle">
                            </div>

                            <!--********************************************Gallery**************************************************-->
                            <!--Post Gallery-->
                            <div class="form-group">
                                <label>Post Gallery</label>
                                @if(empty($store_gallery))
                                <div class="content_gallery_list_images">
                                    <input class="gallery_item_txt" type="hidden" value="1" name="gallery_item_count" autocomplete="off"/>
                                    <div class="clear content_add_item_images">
                                        <div class="group_item_images clear">
                                            <div class="inside clear">
                                                <div class="icon_change_postion"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                <div class="icon_change_postion image_view"><img width="20" height="20" src="https://dummyimage.com/20x20/000/fff"></div>
                                                <div class="text_input_file_image">
                                                    <input class="myfile_gallery_store form-control myfile_gallery_default" type="text" value="" size="50" name="upload_gallery0" />
                                                </div>
                                                <div class="mybutton_upload_img">
                                                    <input class="upload_gallery_file" type="file" onchange="set_link_gallery(this);" multiple name="upload_gallery_file0[]">Upload
                                                </div>
                                            </div>
                                        </div><!--group_item_images-->
                                    </div><!--content_add_item_images-->
                                    <!--<div class="clear add_link add_part_images">
                                        <a class="add r">+ Add Image</a>
                                    </div>-->
                                </div>
                                @else
                                <div class="content_gallery_list_images">
                                    <input class="gallery_item_txt" type="hidden" value="<?php echo count($store_gallery); ?>" name="gallery_item_count" autocomplete="off"/>
                                    <div class="clear content_add_item_images">
                                        <?php for($j=0;$j<count($store_gallery);$j++): $n=$j+1; ?>
                                            <div class="group_item_images clear">
                                                <div class="inside clear">
                                                    <div class="icon_change_postion"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>
                                                    <div class="icon_change_postion image_view image_show_demo"><a target="_blank" class="html5lightbox" href="<?php echo '/images/product/'.$store_gallery[$j]; ?>"><img width="50" height="auto" src="<?php echo '/images/product/'.$store_gallery[$j]; ?>"></a></div>
                                                    <div class="space_input_demo text_input_file_image">
                                                        <input class="myfile_gallery_store form-control" type="text" value="<?php echo $store_gallery[$j]; ?>" size="50" name="upload_gallery<?php echo $n; ?>" />
                                                    </div>
                                                    <div class="mybutton_upload_img hidden">
                                                        <input class="upload_gallery_file" type="file" onchange="set_link_gallery(this);" multiple name="upload_gallery_file<?php echo $n; ?>">Upload
                                                    </div>
                                                </div>
                                            </div><!--group_item_images-->
                                        <?php endfor; ?>
                                        <div class="group_item_images clear">
                                            <div class="inside clear">
                                                <div class="icon_change_postion image_view"><img width="20" height="auto" src="https://dummyimage.com/20x20/000/fff"></div>
                                                <div class="text_input_file_image">
                                                    <input class="myfile_gallery_store form-control myfile_gallery_default" type="text" value="" size="50" name="upload_gallery0" />
                                                </div>
                                                <div class="mybutton_upload_img">
                                                    <input class="upload_gallery_file" type="file" onchange="set_link_gallery(this);" multiple name="upload_gallery_file0[]">Upload
                                                </div>
                                            </div>
                                        </div><!--group_item_images-->
                                    </div><!--content_add_item_images-->
                                    <!--<div class="clear add_link add_part_images">
                                        <a class="add r">+ Add Image</a>
                                    </div>-->
                                </div>
                                @endif
                                <script type="text/javascript">
                                    jQuery(document).ready(function($){
                                        $(".content_add_item_images").sortable({
                                            stop: function(event, ui){
                                                var cnt = 1;
                                                $(this).children('.group_item_images').each(function(){
                                                    $(this).find('input.myfile_gallery_store').attr('name','upload_gallery'+cnt);
                                                    //.val(cnt);
                                                    cnt++;
                                                });
                                            }
                                        });
                                    });

                                    var fileCollection = new Array();
                                    var count_images_gallery=$('.upload_gallery_file').length;

                                    window.set_link_gallery = function (input) {
                                        if (input.files && input.files[0]) {
                                            var add_item_gallery_select_muti="";
                                            $(input.files).each(function (i, file) {
                                               $('.create_news_item_img').remove();
                                               fileCollection.push(file);
                                                var reader = new FileReader();
                                                reader.readAsDataURL(this);
                                                reader.onload = function (e) {
                                                    add_item_gallery_select_muti='<div class="group_item_images clear create_news_item_img">'+
                                                         '<div class="inside clear">'+
                                                         '<div class="icon_change_postion"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></div>'+
                                                         '<div class="icon_change_postion image_view image_show_demo"><a class="html5lightbox"><img width="50" height="auto" src="'+e.target.result+'"></a></div>'+
                                                         '<div class="space_input_demo text_input_file_image">'+
                                                            '<input class="myfile_gallery_store form-control" type="text" value="'+file.name+'" size="50" name="upload_gallery'+parseInt(count_images_gallery+i)+'" />'+
                                                         '</div>'+
                                                         '<div class="mybutton_upload_img hidden">'+
                                                             '<input class="upload_gallery_file" type="file" onchange="set_link_gallery(this);"  attb="'+i+'" multiple name="upload_gallery_file'+parseInt(count_images_gallery+i)+'">Upload'+
                                                         '</div>'+
                                                          '</div>'+
                                                        '</div><!--group_item_images-->';
                                                        $('.content_gallery_list_images .content_add_item_images').prepend(add_item_gallery_select_muti);
                                                    var cnt = 1;
                                                    $('.content_add_item_images').children('.group_item_images').each(function(){
                                                          $(this).find('input.myfile_gallery_store').not('.myfile_gallery_default').attr('name','upload_gallery'+cnt);
                                                          cnt++;
                                                    });
                                                    $(".gallery_item_txt").val($('.upload_gallery_file').length-1);
                                                }
                                            });
                                        }
                                    }

                                    function set_link_gallery(elm){
                                        var fileCollection = new Array();
                                        var fn = $(elm).val();
                                        $(elm).parent().parent().find('.myfile_gallery_store').val(fn);
                                        $(elm).parent().parent().find('.myfile_gallery_store').attr("value",fn);
                                    }

                                    function set_link_icon(elm){
                                        var fileCollection = new Array();
                                        var fn = $(elm).val();

                                        $(elm).parent().parent().find('.myfile_icon_store').val(fn);
                                        $(elm).parent().parent().find('.myfile_icon_store').attr("value",fn);
                                    }

                                    function prepareUpload(event){
                                        var files = event.target.files;
                                        var fileName = files[0].name;
                                        alert(fileName);
                                    }
                                </script>
                            </div>
                            <!--End Post Gallery-->
                            
                            <!--SEO-->
                            {{-- @include('admin.form-seo.seo') --}}
    		        	</div> <!-- /.card-body -->



    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                   

                    <div class="card widget-category">
                        <div class="card-header">
                            <h3 class="card-title">Thể loại sản phẩm</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="inside clear">
                                <div class="clear">
                                    <?php
                                    $data_checks=App\Model\JoinCategoryProduct::where('id_product', $sid)->get();
                                    $array_checked=array();
                                    if($data_checks):
                                        foreach($data_checks as $data_check):
                                            array_push($array_checked,$data_check->id_category_product);
                                        endforeach;
                                    endif;
                                    $categories=App\Model\CategoryProduct::where('category_products.categorySlug', '<>', 'combo')->orderBy('categoryShort','DESC')->get();
                                    echo \App\WebService\WebService::showMutiCategory($categories,$array_checked,0);
                                    ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

                     <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Publish</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group clearfix hidden ">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioDraft" name="status" value="1" @if($status == 1) checked @endif>
                                    <label for="radioDraft">Draft</label>
                                </div>
                                <div class="icheck-primary d-inline" style="margin-left: 15px;">
                                    <input type="radio" id="radioPublic" name="status" value="0" @if($status == 0) checked @endif >
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

                    <div class="card widget-category ">
                        <div class="card-header">
                            <h3 class="card-title">Thương hiệu</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="inside clear">
                                <div class="clear">
                                    <?php
                                    $brand = App\Model\Brand::orderBy('brandName', 'ASC')->get();
                                    $seq = 0;
                                    foreach($brand as $brands):
                                    $seq++;
                                ?>
                                   <p>
                                        <label for="radio_cmc_<?php echo $seq; ?>">
                                            <input type="radio" class="category_item_input" name="brand_item" value="<?php echo $brands->brandID; ?>" id="radio_cmc_<?php echo $seq; ?>"  <?php
                                                if($id_brand > 0):
                                                    $data_checks = App\Model\Product::where('id_brand', $id_brand)->get();
                                                    foreach($data_checks as $data_check):
                                                        $seq_check = $data_check->id_brand;
                                                        if($seq_check == $brands->brandID):
                                                           echo "checked='checked'";
                                                        endif;
                                                    endforeach;
                                                endif;
                                               ?> />
                                            <?php echo $brands->brandName; ?>
                                        </label>
                                        <br />
                                    </p>
                                    <?php endforeach; ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Image Thumbnail</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group hidden">
                                <label for="post_title">Thumbnail Alt</label>
                                <input type="text" class="form-control" id="post_thumb_alt" value="{{$thumbnail_alt}}" name="post_thumb_alt" placeholder="Thumbnail Alt">
                            </div>
                            <div class="form-group">
                                <label for="thumbnail_file">File input</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="thumbnail_file" class="custom-file-input" id="thumbnail_file" style="display: none;">
                                        <input type="text" name="thumbnail_file_link" class="custom-file-link form-control" id="thumbnail_file_link" value="{{$thumbnail}}">
                                        <label class="custom-file-label custom-file-label-thumb" for="thumbnail_file"></label>
                                    </div>
                                </div>
                                @if($thumbnail != "")
                                <div class="demo-img" style="padding-top: 15px;">
                                    <img src="{{asset('images/product/'.$thumbnail)}}">
                                </div>
                                @endif
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
        $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        //End event
        $('#start_event').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        //End event
        $('#end_event').datetimepicker({
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

        $('#post_description_en,#post_content   ').summernote({
            placeholder: 'Enter your description',
            tabsize: 2,
            focus: true,
            height: 200,
            codemirror: { // codemirror options
                theme: 'monokai'
            }
        });
        

        $('#thumbnail_file').change(function(evt) {
            $("#thumbnail_file_link").val($(this).val());
            $("#thumbnail_file_link").attr("value",$(this).val());
        });

        $(document).on("change", ".upload_gallery_variable_select", function() {
            var fn = $(this).val();
            $(this).parent().parent().find('.myfile_gallery_store_select').val(fn);
            $(this).parent().parent().find('.myfile_gallery_store_select').attr("value",fn);
        });
        
        //xử lý validate
        $("#frm-create-product").validate({
            rules: {
                post_title: "required",
                'category_item[]': { required: true, minlength: 1 },
                price_origin: "required",
            },
            messages: {
                post_title: "Nhập tiêu đề tin",
                'category_item[]': "Chọn thể loại sản phẩm",
                price_origin: "Nhập giá gốc sản phẩm",
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
<script type="text/javascript">
	
</script>
@endsection