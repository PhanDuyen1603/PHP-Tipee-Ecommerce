@extends('layouts.app')
@section('seo')
<?php
$title='Giỏ hàng |'.Helpers::get_option_minhnn('seo-title-add');
$description=$title.Helpers::get_option_minhnn('seo-description-add');
$keyword='gio hang, add to car,'.Helpers::get_option_minhnn('seo-keywords-add');
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
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);
$request=new Request();
$query_remove=(int)Request::get('remove');
if($query_remove!='' && $query_remove >0):
    $rowId_remove = Cart::search(function ($cart, $key) use($query_remove) {
       return $cart->id == $query_remove;
    })->first();
    Cart::remove($rowId_remove->rowId);
    echo '<div style="display: none;">'. \Illuminate\Support\Facades\Redirect::route('cart').'</div>';
endif;
$agent = new  Jenssegers\Agent\Agent();
?>
@include('partials.seo')
@endsection
@section('content')
    <div class="breadcrumbs-group-container clear">
        <div class="container clear">
            <div class="breadcrumbs_top_page clear">
                <div class="breadcrumbs-item fl">
                    {!! Breadcrumbs::render('cart') !!}
                </div>
            </div>
        </div>
    </div><!--home-index-->
    <div class="main_content clear">
        <div class="body-container none_padding border-group clear">
                <section id="section" class="section clear">
                    <div class="group-section-wrap clear ">
					   <div class="container_cart clear">  
                            <div class="container clear">
                                <div class="row">
                                    <div class="leftContent col-xs-12 col-sm-12 col-md-12">
                                        <div class="row-content-category clear">
                                        <div class="listProduct woocommerce woocommerce-checkout clear">
                                            <div class="hidden container_theme_category">
                                                <h1 class="title_product"><span>Giỏ hàng</span></h1>
                                            </div>
                                            <div id="add_cart_container" class="news_page_gs group-my-cart-page clear">
                                                @if(Cart::content()->count()>0)
                                                    <div class="container_list_products clear">
                                                        @if (session('status'))
                                                            <div class="alert alert-success">
                                                                {{ session('status') }}
                                                            </div>
                                                        @endif
                                                        @if (session('code_discount_error'))
                                                            <div class="alert alert-danger">
                                                                {{ session('code_discount_error') }}
                                                            </div>
                                                        @endif
                                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                        <!--List-->
                                                        <?php $string_json=""; $id_cart=0;$cart_items="";  $url_img_sp='images/product/';?>
                                                        <form class="woocommerce-cart-form" action="{{route('update.cart')}}" method="post">
                                                            <input type="hidden" name="update" value="on"/>
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            @if(!$agent->isMobile())
                                                            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                                                                <thead>
                                                                <tr>
                                                                    <th class="product-remove">Thao tác</th>
                                                                    <th class="product-thumbnail">Ảnh</th>
                                                                    <th class="product-name">Sản phẩm</th>
                                                                    <th class="product-price">Giá</th>
                                                                    <th class="product-quantity">Số lượng</th>
                                                                    <th class="product-subtotal">Tổng cộng</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $Products=""; ?>

                                                                @foreach(Cart::content() as $cart_items)
                                                                <?php $avariable_html = ""; $group_combo = ""; $name_color = "";?>
                                                                    @if($cart_items->qty >0)
                                                                    <?php $id_cart=$cart_items->id; $Products=Helpers::get_product_by_id($id_cart); ?>
                                                                        @if($Products)
                                                                        <?php
                                                                            $id=$id_cart;
                                                                            $name=$Products->title;
                                                                            $code=$Products->theme_code;
                                                                            $date_now = date("Y-m-d h:i:s");
                                                                            $price=$cart_items->price;
                                                                            $quantity=$cart_items->qty;
                                                                            $money= $quantity*$price;
                                                                            $post_thumbnail_news=$url_img_sp.$Products->thubnail;
                                                                            $avariable=$cart_items->options;
                                                                            $string_json_variable="";
                                                                            $avariable_html="";
                                                                            if(isset($avariable) && count($avariable)>0):
                                                                                $count_option_arr = count($avariable);
                                                                                $id_variable_parrent=0;
                                                                                $id_variable_child=0;
                                                                                for ($j=0; $j < $count_option_arr; $j++):
                                                                                    $string_json_variable=\GuzzleHttp\json_decode($avariable[$j]);
                                                                                    if(!WebService::objectEmpty($string_json_variable)):
                                                                                        $id_variable_parrent=$string_json_variable->parent_id;
                                                                                        $id_variable_child=$string_json_variable->id;
                                                                                        if($id_variable_parrent>0 && $id_variable_child>0):
                                                                                        $avariable_html .="<p class='avariable_html'><span class='variable_txt_prent'>".Helpers::get_title_variable_theme_by_id($id_variable_parrent)."</span>: <span class='variable_txt_child'>".Helpers::get_title_variable_theme_by_id($id_variable_child)."</span></p>";
                                                                                        endif;
                                                                                    endif;
                                                                                endfor;
                                                                            endif;
                                                                ?>
                                                                <tr class="woocommerce-cart-form__cart-item cart_item">
                                                                    <td class="product-remove">
                                                                        <a href="{{url('/')}}/cart/?remove={{$id}}" class="remove" aria-label="Xóa sản phẩm này" data-product_id="{{$id}}" data-product_sku="{{$code}}">×</a></td>

                                                                    <td class="product-thumbnail">
                                                                        <a href="{!!Helpers::get_permalink_by_id($cart_items->id)!!}">
                                                                            <img src="{{$post_thumbnail_news}}" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail wp-post-image" alt="{{$name}}"/>
                                                                        </a>
                                                                    </td>
                                                                    <td class="product-name" data-title="Sản phẩm">
                                                                        <a href="{!!Helpers::get_permalink_by_id($cart_items->id)!!}" target="_blank" class="bold uppercase">{{$name}}</a>
                                                                        <?php echo $avariable_html;?>
                                                                    </td>
                                                                    <td class="product-price" data-title="Giá">
                                                                        <span class="woocommerce-Price-amount amount">{!!WebService::formatMoney12($price)!!}<span class="woocommerce-Price-currencySymbol">{!!Helpers::get_option_minhnn('currency')!!}</span></span></td>
                                                                    <td class="product-quantity" data-title="Số lượng">
                                                                        <div class="quantity info-qty">
                                                                            <a class="qty-down" href="#"><i class="fa fa-minus"></i></a>
                                                                            <input type="text" data-step="1" data-min="0" data-id-pro="{{$id}}" name="qty[{{$id}}]" readonly="true" value="{{$quantity}}" class="input-text text qty-val" size="4">
                                                                            <a class="qty-up" href="#"><i class="fa fa-plus"></i></a>
                                                                        </div></td>

                                                                    <td class="product-subtotal" data-title="Tổng cộng">
                                                                        <span data-total-id="{{$id}}" data-price-item="{{$money}}" class="woocommerce-Price-amount amount">{!!WebService::formatMoney12($money)!!}<span class="woocommerce-Price-currencySymbol">{!!Helpers::get_option_minhnn('currency')!!}</span></span></td>
                                                                </tr>
                                                                        @endif
                                                                   @endif
                                                                @endforeach
                                                                <tr>
                                                                   <td colspan="6" class="actions">
                                                                       <span class="span_td_cart_total">Tổng tiền: <span id="td-cart_total">{!!WebService::formatMoney12(Cart::total())!!} <span class="woocommerce-Price-currencySymbol"> ₫</span></span></span>
                                                                   </td>
                                                                </tr>
                                                                {{--<tr>
                                                                    <td colspan="6" class="actions">
                                                                        <button type="submit" class="button" name="update_cart" value="Cập nhật giỏ hàng">Cập nhật giỏ hàng</button>
                                                                    </td>
                                                                </tr>--}}

                                                                </tbody>
                                                            </table>
                                                            @else
                                                            <table id="shopping-cart-table" class="cart items data table">
                                                               <thead>
                                                                  <tr class="cart-cols-mobile">
                                                                     <th class="col cart-item-count-and-messages" scope="col" colspan="4">
                                                                        <div class="cart-item-count">
                                                                           <span class="cart-item-count-text">Giỏ hàng</span>
                                                                           <span class="cart-item-count-label">({!!Cart::content()->count()!!})</span>
                                                                        </div>
                                                                        <div id="mobile-page-messages" class="mobile-page-messages">
                                                                           <div class="page messages content-wrapper">
                                                                           </div>
                                                                        </div>
                                                                     </th>
                                                                  </tr>
                                                               </thead>
                                                               @foreach(Cart::content() as $cart_items)
                                                               <?php $avariable_html = ""; $group_combo = ""; $name_color = "";?>
                                                                    @if($cart_items->qty >0)
                                                                    <?php $id_cart=$cart_items->id; $Products=Helpers::get_product_by_id($id_cart); ?>
                                                                        @if($Products)
                                                                        <?php
                                                                            $id=$id_cart;
                                                                            $name=$Products->title;
                                                                            $code=$Products->theme_code;
                                                                            $date_now = date("Y-m-d h:i:s");
                                                                            $product_link = Helpers::get_permalink_by_id($cart_items->id);
                                                                            $price=$cart_items->price;
                                                                            $quantity=$cart_items->qty;
                                                                            $money= $quantity*$price;
                                                                            $post_thumbnail_news=$url_img_sp.$Products->thubnail;
                                                                            $avariable=$cart_items->options;
                                                                            $string_json_variable="";
                                                                            $avariable_html="";
                                                                            if(isset($avariable) && count($avariable)>0):
                                                                                $count_option_arr = count($avariable);
                                                                                $id_variable_parrent=0;
                                                                                $id_variable_child=0;
                                                                                for ($j=0; $j < $count_option_arr; $j++):
                                                                                    $string_json_variable=\GuzzleHttp\json_decode($avariable[$j]);
                                                                                    if(!WebService::objectEmpty($string_json_variable)):
                                                                                        $id_variable_parrent=$string_json_variable->parent_id;
                                                                                        $id_variable_child=$string_json_variable->id;
                                                                                        if($id_variable_parrent>0 && $id_variable_child>0):
                                                                                        $avariable_html .="<p class='avariable_html'><span class='variable_txt_prent'>".Helpers::get_title_variable_theme_by_id($id_variable_parrent)."</span>: <span class='variable_txt_child'>".Helpers::get_title_variable_theme_by_id($id_variable_child)."</span></p>";
                                                                                        endif;
                                                                                    endif;
                                                                                endfor;
                                                                            endif;
                                                                ?>
                                                               <tbody class="cart item">
                                                                  <tr class="item-info">
                                                                     <td data-th="Item" class="col item" colspan="4">
                                                                        <div class="item-inner-wrapper">
                                                                           <a href="{{$product_link}}" title="{{$name}}" tabindex="-1" class="product-item-photo">
                                                                           <span class="product-image-container" style="width:120px;">
                                                                           <span class="product-image-wrapper">
                                                                           <img class="product-image-photo" src="{{$post_thumbnail_news}}" max-width="120" max-height="160" alt="{{$name}}">
                                                                           </span>
                                                                           </span>
                                                                           </a>
                                                                           <div class="product-item-details">
                                                                              <div class="product-item-name">
                                                                                 <a href="{{$product_link}}">{{$name}}</a>
                                                                                 {!! $avariable_html !!}
                                                                              </div>
                                                                              <div class="product-subtotal" data-title="Tổng cộng">
                                                                        <span data-total-id="{{$id}}" data-price-item="{{$money}}" class="woocommerce-Price-amount amount">{!!WebService::formatMoney12($money)!!}<span class="woocommerce-Price-currencySymbol">{!!Helpers::get_option_minhnn('currency')!!}</span></span></div>
                                                                              <div data-title="Số lượng" class="product-quantity"><div class="quantity info-qty"><a href="#" class="qty-down"><i class="fa fa-minus"></i></a> <input type="text" data-step="1" data-min="0" data-id-pro="{{$id}}" name="qty[{{$id}}]" readonly="true" value="{{$quantity}}" class="input-text text qty-val" size="4"> <a href="#" class="qty-up"><i class="fa fa-plus"></i></a></div></div>
                                                                              <div class="actions-toolbar">
                                                                                 <a href="{{url('/')}}/cart/?remove={{$id}}" title="Remove" class="remove action action-delete" aria-label="Delete this product" data-product_id="{{$id}}" data-product_sku="{{$code}}"></a>
                                                                              </div>
                                                                           </div>
                                                                        </div>
                                                                     </td>
                                                                  </tr>
                                                               </tbody>
                                                                        @endif
                                                                    @endif
                                                               @endforeach
                                                               <tbody>
                                                                    <tr>
                                                                        <td colspan="6" class="actions">
                                                                           <span class="span_td_cart_total">Tổng tiền: <span id="td-cart_total">{!!WebService::formatMoney12(Cart::total())!!} <span class="woocommerce-Price-currencySymbol"> ₫</span></span></span>
                                                                       </td>
                                                                    </tr>
                                                               </tbody>
                                                            </table>
                                                            @endif
                                                        </form>
                                                        <!--List-->
                                                    </div><!--container_list_products-->

                                                    <!--Form ***************************************************************************************-->
                                                    <div class="form-customer-order">
                                                        <?php
                                                            $user_check = 0;
                                                            if(Auth::check()){
                                                                $user_check = 1;
                                                                $full_name = Auth::user()->name;
                                                                $phone = Auth::user()->phone;
                                                                $email = Auth::user()->email;
                                                                $address = Auth::user()->address;
                                                                $province = Auth::user()->province;
                                                                $district = Auth::user()->district;
                                                                $ward = Auth::user()->ward;
                                                            } else{
                                                                $full_name = "";
                                                                $phone = "";
                                                                $email = "";
                                                                $address = "";
                                                                $province = "";
                                                                $district = "";
                                                                $ward = "";
                                                            }
                                                        ?>
                                                        <form id="check_out_frm" name="frm-checkout" method="post" action="{{route('cart-post')}}">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="checkout" value="true"/>
                                                            <div class="container_checkout clear">
                                                                <div class="row justify-content-center">
                                                                    @if ($errors->any())
                                                                       <div class="col-md-6 col-md-offset-3 mgt-10 alert alert-danger alert-dismissible fade in">
                                                                       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                          <ul>
                                                                            @foreach ($errors->all() as $error)
                                                                              <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
                                                                            @endforeach
                                                                          </ul>
                                                                       </div>
                                                                    @endif
                                                                    @if(Session::has('success_msg'))
                                                                        <div class="col-md-6 col-md-offset-3 mgt-10  alert alert-success alert-dismissible fade in" role="alert">
                                                                             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                                             {{ Session::get('success_msg') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-7 col-md-6 col-xs-12 form_user_cart">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body form-horizontal payment-form">
                                                                                <div class="form-group">
                                                                                    <label for="full-name" class="col-sm-2 control-label">Họ tên(<span class="hitsu">*</span>)</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" id="full-name" name="full_name" value="<?php if($user_check == 1) echo $full_name; ?>" placeholder="Nhập họ và tên">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="phone" class="col-sm-2 control-label">Điện thoại(<span class="hitsu">*</span>)</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" id="phone" name="phone" value="<?php if($user_check == 1) echo $phone; ?>" placeholder="Nhập số điện thoại">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="your-email" class="col-sm-2 control-label">Email</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="email" class="form-control" id="your-email" name="email" value="<?php if($user_check == 1) echo $email; ?>" placeholder="Email của bạn">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="slt_province" class="col-sm-2 control-label">Tỉnh thành(<span class="hitsu">*</span>)</label>
                                                                                    <div class="col-sm-4">
                                                                                        <select name="slt_province" id="slt_province" class="form-control" >
                                                                                          @if($province != "")
                                                                                            {!! WebService::getOptionProvinceUserDataRender($province) !!}
                                                                                          @else
                                                                                            <option value="">Chọn tỉnh</option>
                                                                                            <?php
                                                                                                $data_province = App\Model\Province::orderBy('province.name', 'ASC')->get();
                                                                                                foreach($data_province as $item):
                                                                                            ?>
                                                                                            <option value="{{$item->name}}">{{$item->name}}</option>
                                                                                            <?php endforeach; ?>
                                                                                          @endif
                                                                                        </select>
                                                                                    </div>
                                                                                    <label for="slt_district" class="col-sm-2 control-label">Quận/Huyện(<span class="hitsu">*</span>)</label>
                                                                                    <div class="col-sm-4">
                                                                                        <select name="slt_district" id="slt_district" class="form-control" >
                                                                                          @if($province != "" && $district != "")
                                                                                            {!! WebService::getOptionDistrictUserDataRender($province, $district) !!}
                                                                                          @else
                                                                                            <option value="">Chọn Quận/Huyện</option>
                                                                                          @endif
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="slt_ward" class="col-sm-2 control-label">Phường/Xã(<span class="hitsu">*</span>)</label>
                                                                                    <div class="col-sm-4">
                                                                                        <select name="slt_ward" id="slt_ward" class="form-control" >
                                                                                          @if($province != "" && $district != "" && $ward != "")
                                                                                            {!! WebService::getOptionWardUserDataRender($district, $ward) !!}
                                                                                          @else
                                                                                            <option value="">Chọn Phường/Xã</option>
                                                                                          @endif
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="address" class="col-sm-2 control-label">Địa chỉ giao(<span class="hitsu">*</span>)</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input type="text" class="form-control" id="address" name="address" value="<?php if($user_check == 1) echo $address; ?>" placeholder="Địa chỉ giao hàng">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-sm-12">
                                                                                        <textarea class="form-control" id="message" name="message" placeholder="Thông tin xuất hóa đơn" rows="3"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><!--form_user_cart-->
                                                                    <div class="col-lg-5 col-md-6 col-xs-12 total_cart_container cart-collaterals">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body form-horizontal payment-form">
                                                                                <div class="cart_totals clear">
                                                                                    <h2>Mã giảm giá (Không áp dụng cho gói Combo)</h2>
                                                                                    <div class="discount-input clear">
                                                                                        <input type="text" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX" name="discount_code" value="">
                                                                                        <input type="button" name="apply_discount" onclick="check_code_discount();" value="Áp dụng">
                                                                                        <span class="discount-success"></span>
                                                                                        <span class="discount-error"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body form-horizontal payment-form">
                                                                                <div class="cart_totals clear">
                                                                            <h2>Tổng số lượng</h2>
                                                                            <table cellspacing="0" class="shop_table shop_table_responsive">
                                                                                <tbody>
                                                                                <tr class="shipping">
                                                                                    <th>Giao hàng</th>
                                                                                    <td data-title="Giao hàng 1">
                                                                                        <ul id="shipping_method">
                                                                                            <li>
                                                                                                <input type="radio" name="shipping_method" data-index="0" id="shipping_method_0_free_shipping1" value="cod" class="shipping_method" checked="checked">
                                                                                                <label for="shipping_method_0_free_shipping1">Thanh toán khi nhận hàng(COD)</label>
                                                                                            </li>
                                                                                            <?php /*<li>
                                                                                                <input type="radio" name="shipping_method" data-index="1" id="shipping_method_0_local_pickup2" value="bank" class="shipping_method">
                                                                                                <label for="shipping_method_0_local_pickup2">Chuyển khoản qua ngân hàng</label>
                                                                                            </li> */?>

                                                                                        </ul>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr class="order-total">
                                                                                    <th>Tổng cộng</th>
                                                                                    <td data-title="Tổng cộng" class="total_cart_order">
                                                                                        <span class="price_discount"></span>
                                                                                        <strong><span id="total_price_cart" class="woocommerce-Price-amount amount">{!!WebService::formatMoney12(Cart::total())!!} <span class="woocommerce-Price-currencySymbol">{!!Helpers::get_option_minhnn('currency')!!} (Chưa bao gồm phí giao hàng)</span></span></strong>
                                                                                        <p>
                                                                                            Phí giao hàng: <br/>
                                                                                            - Nội thành Thành phố Vinh: 20.000 VNĐ <br/>
                                                                                            - Các tỉnh khác: 30.000 VNĐ
                                                                                        </p>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div><!--cart_totals-->
                                                                            </div>
                                                                        </div>
                                                                    </div><!--total-cart_container-->
                                                                </div>
                                                                <div class="checkout_submit_form_order clear">
                                                                    <div class="wc-proceed-to-checkout">
                                                                        <button type="submit" id="submit" name="tbl_submit" class="btn btn-danger"><span class="dslc-icon-ext-paperplane"></span> Đặt hàng</button>
                                                                        <div class="loading"></div>
                                                                    </div>
                                                                </div><!--checkout_submit_form_order-->
                                                            </div><!--container_checkout-->
                                                        </form>
                                                    </div><!--form-customer-order-->
                                                    <!--End Form **********************************************************************************-->

                                                @else
                                                    @if(Session::has('success_msg'))
                                                        <script language="javascript">
                                                            alertView("Đơn hàng","Bạn đã đặt hàng thành công. Chúng tôi xử lý và sẽ liên lạc lại bạn với sớm nhất!");
                                                        </script>
                                                        <div class="col-md-6 col-md-offset-3">
                                                            <div class="alert alert-dismissable alert-success">
                                                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                                                {{Session::get('success_msg')}}
                                                            </div>
                                                        </div>
                                                        <p></p>
                                                    @endif
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                              <strong>Giỏ hàng!</strong> Hiện tại giỏ hàng bạn còn trống.
                                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div><!--add_cart_container-->
                                        </div><!--listProduct-->
                                    </div><!--row-content-->
                                    </div>
                                </div>
                            </div>
                        </div><!--leftContent-->
                        <div class="container clear">
                            @include('layouts.footer_public')
                        </div><!--rightContent-->
                     </div>
                </section><!--section-->
            </div><!--body-container-->
    </div><!--main_content-->
@endsection