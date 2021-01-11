@extends('layouts.app')
@section('content') 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<section>

    <div class="container">
        <h1>Tra cứu đơn hàng</h1>
        <div class="timeline">

        </div>
        <div class="customer_info">

        </div>
        <div class="orders">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                    </tr>
                </thead>
                 @foreach($user_order as $key => $order)
                <tbody>
                    <tr>
                        <td>{{$order->title}}</td>
                        <td>{{$order->order_quantity}}</td>
                    </tr>
                </tbody>
               @endforeach
               
            
               
                
            </table>
        </div>
       
    </div>
</section>

@endsection