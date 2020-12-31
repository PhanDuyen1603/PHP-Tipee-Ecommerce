@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <?php 
                //$content = Cart::content();
                //print_r($content);
                ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                @foreach(Session::get('cart') as $key => $cart)
                    @php
                        $subtotal = $cart['product_price'] * $cart['product_qty'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td class="cart_product">
                            <a href=""><img width="100" height="100" src="{{URL::to('public/uploads/product/'.$cart['product_image'])}}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$cart['product_name']}}</a></h4>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($cart['product_price'],0,',','.').' đ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href=""> + </a>
                                <input class="cart_quantity_input" min="1" type="number" name="cart_qty" value="{{$cart['product_qty']}}" autocomplete="off" size="2">
                                <a class="cart_quantity_down" href=""> - </a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{number_format($subtotal,0,',','.').' đ'}}</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng tiền <span>{{number_format($total,0,',','.').' đ'}}</span></li>
                        <li>Thuế <span></span></li>
                        <li>Phí vận chuyển <span></span></li>
                        <li>Tiền sau giảm <span></span></li>
                    </ul>
                    <a href="" class="btn btn-default check_out">Thanh toán</a>
                    <a href="" class="btn btn-default check_out">Tính mã giảm giá</a>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection