@extends('layouts.app')
@section('content') 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


<section>
    <div class="container-xl">
        @php
            $total = 0;
        @endphp
        @foreach($cart_user as $key => $cart)
        <div class="row">
            <div class="col-9">
             
                <div class="card" style="padding:30px;margin:50px 0;">
                    <div class="card-body">
                        <div class="row">

                            <div class="col">
                              <img width="100" height="100" src="{{asset('images/product/'.$cart['thubnail'])}}" alt="">
                            </div>

                            <div class="col-6">
                              <h5>{{$cart->title}}</h5>
                            </div>


                            <div class="col-4" sytle="display:flex">
                                <div class="row">

                                    <div class="col" style="text-align: center">
                                        <span class="price_promotion">
                                            <h4 style="font-weight: bold">{{number_format($cart->price_promotion). ' đ'}}</h4>
                                        </span>
                                        <?php $saleOff = round(100 - $cart->price_promotion / $cart->price_origin * 100) ?>
                                        <span id="price_origin">
                                            <span>- <?php echo $saleOff . "%";?></span> 
                                            <strike>{{number_format($cart->price_origin). ' đ'}}</strike>
                                        </span>                                   
                                    </div>

                                    <div class="col" >
                                        <div  class="quantityChanger" style="display:flex;align-items:center; flex-direction:column;">
                                        <form action="http://127.0.0.1:8000/delete-cart" method="POST">      
                                            {{-- <div style="display:flex;">
        
                                                <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                                    <span class="glyphicon glyphicon-minus"></span>
                                                </button>
                                    
                                                <input style="max-width: 50px;" type="text" id="quantity" name="cart_quantity" class="form-control input-number cart_quantity" value="1" min="1" max="100">
                                     
                                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                                    <span class="glyphicon glyphicon-plus"></span>
                                                </button>    
                                                     
                                            </div> --}}
                                            <input type="hidden" name="userId" class="userId" value="{{$cart->cart_user}}">
                                            <input type="hidden" name="cart_product" class="cart_product" value="{{$cart->cart_product}}">

                                           <div style="margin-top:10px;" class="btnDeleteProduct">
                                                <button type="submit" class="btn btn-danger"  >
                                                    <span>Xoá</span>
                                                </button>
                                           </div>
                                        </form> 
                                        </div>
                                    </div>

                                </div>
                                    
                            </div>

                                
                        </div> <!-- /row-->
                    </div> <!-- /carbody-->
                </div>
               
            </div>
            <div class="col-3" style="margin: 50px 0;" >
                @foreach($user_info as $key => $user)
                <div class="card">
                    <div class="card-body">
                        <div style="display: flex;flex-direction:column;text-align:center" id="discount">
                            <span>Tên người nhận: <span  style="font-weight: bold">{{$user->name}}</span></span>
                            <span>Số điện thoại: <span style="font-weight: bold">{{$user->phone}}</span></span>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="pay">
                    <div class="card">
                        <div class="card-body" style="display: flex;flex-direction:column;">
                            <div class="card-body" >
                                    <span>Tạm tính</span>
                                    <span style="font-weight: bold;float:right">{{number_format($cart->price_promotion). ' đ'}}</span>
                                    <br>
                                    <span>Phí vận chuyển: </span>
                                    <span style="font-weight: bold;float:right">15,000</span>

                            </div>
                            <hr>
                            <div class="card-body" >
                                    <span>Thành tiền</span>
                                    <span style="font-weight: bold;float:right; color:#FF424E; font-size:30px;">{{number_format($cart->price_promotion+ 15000) . ' đ'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="http://127.0.0.1:8000/pay-cart" method="POST">
                    <div class="btnPay" style="text-align: center;margin-top:20px;">
                        <button type="button" class="btn btn-danger">Tiến hành đặt hàng</button> 
                    </div>
                </form>
                

            </div>
          </div>
    @endforeach
    </div>

</section>

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
