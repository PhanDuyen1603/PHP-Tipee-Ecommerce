@extends('admin.layouts.app')
@section('seo')
<?php
$data_seo = array(
    'title' => 'Order Detail: '.$order_detail->cart_code.' | E-Bike Dashboard',
    'keywords' => Helpers::get_option_minhnn('seo-keywords-add'),
    'description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_title' => 'Order Detail: '.$order_detail->cart_code.' | E-Bike Dashboard',
    'og_description' => Helpers::get_option_minhnn('seo-description-add'),
    'og_url' => Request::url(),
    'og_img' => asset('images/logo_seo.png'),
    'current_url' =>Request::url(),
    'current_url_amp' => ''
);
$seo = WebService::getSEO($data_seo);

$total_price = isset($order_detail->cart_total) ? $order_detail->cart_total : '';
$cart_content_cart = unserialize($order_detail->cart_content);
?>
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Order Detail: {{$order_detail->cart_code}}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Order Detail: {{$order_detail->cart_code}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <form action="{{ route('admin.postOrderDetail', array($order_detail->cart_id)) }}" method="POST" id="frm-order-detail">
        @csrf
        <div class="row">
          <input type="hidden" name="sid" value="{{$order_detail->cart_id}}">
          <input type="hidden" name="order_id" value="{{$order_detail->cart_code}}">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin khách hàng</h3>
                </div> <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td style="width: 200px;">Mã đơn hàng:</td>
                      <td>{{$order_detail->cart_code}}</td>
                    </tr>
                    <tr>
                      <td>Họ tên:</td>
                      <td>{{$order_detail->cart_hoten}}</td>
                    </tr>
                    <tr>
                      <td>Điện thoại:</td>
                      <td>{{$order_detail->cart_phone}}</td>
                    </tr>
                    <tr>
                      <td>Email:</td>
                      <td>{{$order_detail->cart_email}}</td>
                    </tr>
                    <tr>
                      <td>Tỉnh/Thành Phố:</td>
                      <td>{{$order_detail->cart_province}}</td>
                    </tr>
                    <tr>
                      <td>Quận/Huyện:</td>
                      <td>{{$order_detail->cart_district}}</td>
                    </tr>
                    <tr>
                      <td>Phường/Xã:</td>
                      <td>{{$order_detail->cart_ward}}</td>
                    </tr>
                    <tr>
                      <td>Địa chỉ:</td>
                      <td>{{$order_detail->cart_address}}</td>
                    </tr>
                    <tr>
                        <td>Phương thức thanh toán:</td>
                        <td>
                            <?php 
                                $pay_method = $order_detail->cart_pay_method; 
                                switch ($pay_method) {
                                    case 'cod':
                                        echo "Thanh toán khi nhận hàng";
                                        break;
                                    case 'bank':
                                        echo "Chuyển khoản ngân hàng";
                                        break;
                                    default:
                                        echo "Không xác định";
                                        break;
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                      <td>Ghi chú của khách hàng:</td>
                      <td>{{$order_detail->cart_note}}</td>
                    </tr>
                    <?php if($order_detail->id_discount_code != 0): 
                        $code_discount = App\Model\Discount_code::where('id' , '=', $order_detail->id_discount_code)->first();
                    ?>
                    <tr>
                        <td>Sử dụng mã giảm giá:</td>
                        <td>
                            <?php echo $code_discount->code; ?> <br>
                            <?php if($code_discount->percent == 0){
                                echo 'Giảm '.WebService::formatMoney12($code_discount->discount_money);
                            } else{
                                echo 'Giảm '.$code_discount->percent.'%';
                            } ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div> <!-- /.card-body -->
                </div><!-- /.card -->
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Chi tiết đơn hàng</h3>
              </div> <!-- /.card-header -->
              <div class="card-body p-0">
                <?php
                    if($cart_content_cart): 
                        $url_img_sp='/images/product/';
                        $j=0;
                        $count=0;
                        $cart_id=0;
                        $Products=array();
                        $List_cart="";
                        $bg_child_tb="";
                ?>
                <table class="table table-striped" id="tbl-order-detail">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Tên sản phẩm</th>
                      <th>Hình ảnh</th>
                      <th>Giá</th>
                      <th>Số lượng</th>
                      <th>Thành tiền</th>
                    </tr>
                  </thead>
                    <tfoot>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                            <td colspan="2"><strong>Tổng tiền</strong></td>
                            <td colspan="1">
                                <div class="fee_ship">Phí ship: <?php echo $order_detail->shipping_fee; ?></div>
                                <span class="sum_price"> 
                                    <?php echo WebService::formatMoney12($total_price);?>
                                </span> <?php echo Helpers::get_option_minhnn('currency');?>
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php 
                            foreach($cart_content_cart as $List_cart):
                                $j++;
                                $count++;
                                $cart_id = $List_cart->id;
                                $avariable = $List_cart->options;
                                $Products = Helpers::get_product_by_id($cart_id);
                                $post_thumbnail_news = $url_img_sp.$Products->thubnail;
                                $avariable_html = "";
                                $group_combo = "";
                                $name_color = '';
                                if(isset($avariable) && count($avariable)>0):
                                    $count_option_arr = count($avariable);
                                    $id_variable_parrent = 0;
                                    $id_variable_child = 0;
                                    for ($j=0; $j < $count_option_arr; $j++):
                                        $string_json_variable = \GuzzleHttp\json_decode($avariable[$j]);
                                        if(!WebService::objectEmpty($string_json_variable)):
                                            $id_variable_parrent = $string_json_variable->parent_id;
                                            $id_variable_child = $string_json_variable->id;
                                            if($id_variable_parrent > 0 && $id_variable_child > 0):
                                            $avariable_html .= "<p class='avariable_html'><span class='variable_txt_prent'>".Helpers::get_title_variable_theme_by_id($id_variable_parrent)."</span>: <span class='variable_txt_child'>".Helpers::get_title_variable_theme_by_id($id_variable_child)."</span></p>";
                                            endif;
                                        endif;
                                    endfor;
                                endif;
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td style="border-left-color: rgb(203, 203, 203);">
                                <a href="<?php echo Helpers::get_permalink_by_id($cart_id); ?>" target="_blank"><?php echo $List_cart->name;?></a><br/>
                                <?php echo $avariable_html;?>
                            </td>
                            <td><img src="<?php echo $post_thumbnail_news;?>" height="50"/></td>
                            <td align="center"><span style="color:#F00;"><?php  echo WebService::formatMoney12($List_cart->price); ?></span> <?php echo Helpers::get_option_minhnn('currency');?></td>
                            <td align="center">
                                <b><?php echo $List_cart->qty; ?></b>
                            </td>
                            <td align="center"><span class="red"><?php  echo WebService::formatMoney12($List_cart->subtotal);?></span> <?php echo Helpers::get_option_minhnn('currency');?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
              </div> <!-- /.card-body -->
            </div><!-- /.card -->
          </div>
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Dành cho quản trị viên</h3>
              </div> <!-- /.card-header -->
              <div class="card-body p-0">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td>Ghi chú:</td>
                      <td>
                        <textarea id="admin_note" name="admin_note">{!!htmlspecialchars_decode($order_detail->cart_excerpt)!!}</textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>Tình trạng</td>
                      <td>
                        <select name="order_status" class="form-control">
                          <option value="1" <?php if($order_detail->cart_status == 1): echo "selected"; endif; ?>>Mới đặt</option>
                          <option value="2" <?php if($order_detail->cart_status == 2): echo "selected"; endif; ?>>Giao J&T</option>
                          <option value="3" <?php if($order_detail->cart_status == 3): echo "selected"; endif; ?>>Đã hủy</option>
                          <option value="4" <?php if($order_detail->cart_status == 4): echo "selected"; endif; ?>>Đợi xử lý</option>
                          <option value="5" <?php if($order_detail->cart_status == 5): echo "selected"; endif; ?>>Liên hệ sau</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align: right;">
                        <input type="submit" name="btn_submit_order" class="btn btn-success" value="Save">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div> <!-- /.card-body -->
            </div><!-- /.card -->
              </div> <!-- /.col -->
          </div> <!-- /.row -->
      </form>
    </div> <!-- /.container-fluid -->
</section>
<script>
  $(function () {
    // Summernote
    $('#admin_note').summernote({
        placeholder: 'Enter your note',
        tabsize: 2,
        focus: true,
        height: 200,
        codemirror: { // codemirror options
            theme: 'monokai'
        }
    });
  })
</script>
@endsection