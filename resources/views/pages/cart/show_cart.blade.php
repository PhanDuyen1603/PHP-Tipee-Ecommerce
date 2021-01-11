@extends('layouts.app')
@section('content') 

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

@php
$total = 0;
@endphp
@foreach($cartOfUser as $key => $cart)
@php
    $total += $cart['cart_totalPrice'];
@endphp
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{route('index')}}">Trang chủ</a></li>
              <li style="margin-left:10px;"> Giỏ hàng của bạn</li>
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
               
                    <tr>
                        <td class="cart_product">
                            <a href=""><img width="100" height="100" src="{{asset('images/product/'.$cart['thubnail'])}}" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="{{route('product.detail',$cart->slug)}}">{{$cart['title']}}</a></h4>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($cart['price_promotion'],0,',','.').' đ'}}</p>
                        </td>
                        <td class="cart_quantity" >
                            <div class="cart_quantity_button" style="display:flex;">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                    
                                <input style="max-width: 50px" type="text" id="quantity" name="cart_quantity" class="form-control input-number cart_quantity" value="{{$cart['cart_quantity']}}" min="1" max="100">
                     
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>    

                                {{-- <a class="cart_quantity_up" href=""> + </a> --}}
                             {{-- <input class="cart_quantity_input" min="1" type="number" name="cart_qty" value="{{$cart['cart_quantity']}}" autocomplete="off" size="2"> --}}
                                {{-- <a class="cart_quantity_down" href=""> - </a> --}}
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">{{number_format($cart['cart_totalPrice'],0,',','.').' đ'}}</p>
                        </td>
                        <td class="cart_delete">                 
                            <form action="{{route('cart.delete')}}" method="POST">
                                @csrf
                                <input type="hidden" name="cart_id" class="cart_id" value="{{$cart->cart_id}}">
                                <button type="submit">
                                    <a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                                </button>
                            </form>
                        </td>
                    </tr>
               {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="pay">
    <div class="container">
        @foreach($user_info as $key => $user)
        <div class="card">
            <div class="card-body">     
                <form action="{{route('cart.order')}}" method="POST">        
                    @csrf 
                <ul style="list-style-type: none">
                   
                    <li>Tổng tiền <span>{{number_format($total,0,',','.').' đ'}}</span> (Đã bao gồm thuế)</li>

                    <li>Phí vận chuyển: <span>Free</span></li>
                    <li>Thành tiền<span>{{number_format($total,0,',','.').' đ'}}</span></li>
                    <li>Phương thức thanh toán: <span></span>tiền mặt</li>
                    <li>Địa chỉ giao hàng:  <br>
                        <input type="text" name="order_address" class="order_address" value=""></li>
                </ul>          
                    <input type="hidden" name="order_customer" class="order_customer" value="{{$cart->cart_user}}">
                    <input type="hidden" name="order_product" class="order_product" value="{{$cart->cart_product}}">
                    <input type="hidden" name="order_price" class="order_price" value="{{$cart->cart_totalPrice}}">
                   
                    <button type="submit" class="btn btn-success">Đặt mua</button>
                </form>
            </div>
        </div>    
        @endforeach     
    </div>
</section>
@endforeach
{{-- NÚT TĂNG GIẢM --}}
<script>
    $(document).ready(function(){

var quantitiy=0;
   $('.quantity-right-plus').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
            
            $('#quantity').val(quantity + 1);

          
            // Increment
        
    });

     $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
      
            // Increment
            if(quantity>0){
            $('#quantity').val(quantity - 1);
            }
    });
    
});
</script>
@endsection