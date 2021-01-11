@extends('layouts.app')
@section('content') 

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

@php
$total = 0;
@endphp

<div class="cart_layout">
<section id="cart_items">
    <div class="oder-cart">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{route('index')}}">Trang chủ</a></li>
              <li style="margin-left:10px;"> Giỏ hàng của bạn</li>
            </ol>
<h2 class="cart-products__title">Giỏ hàng</h2>

        </div>
        <div class="table-responsive cart_info">
            <table class="table table-condensed">                  
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="price">Đơn giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
          
                @foreach($cartOfUser as $key => $cart)
                @php
                    $total += $cart->cart_totalPrice;   
                @endphp
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
                </tbody>
                @endforeach

            </table>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="pay">
    <div class="pay-card">
        <div class="card">
            <div class="card-body" style="
        ">     
                <form action="{{route('order.save')}}" method="POST">        
                    @csrf 
                <div class="calc-money"><div class="prices"><ul class="prices__items"><li class="prices__item"><span class="prices__text">Tạm tính</span><span class="prices__value">{{number_format($total,0,',','.').' đ'}}</span></li></ul><p class="prices__total"><span class="prices__text">Thành tiền</span><span class="prices__value prices__value--final">{{number_format($total,0,',','.').' đ'}}<i>(Đã bao gồm VAT nếu có)</i></span></p></div></div>
                    
                </form>

            </div>
           
        </div>    
        <button type="submit" class="cart__submit">Tiến hành đặt hàng</button>
    </div>
</section>

<div class="ship-address">
    <span class="text">Địa chỉ nhận hàng</span>
    <p class="title-oders"><b class="name">{{Auth::user()->name}}</b><p class="line-straight-oder"></p><b class="phone" style="font-weight: 600">{{Auth::user()->phone}}</b></p>
    <input type="text" name="order_address" class="order_address" placeholder="Bạn muốn giao hàng tới đâu ?" value="" required>
   
    </li>
</div>
</div>


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