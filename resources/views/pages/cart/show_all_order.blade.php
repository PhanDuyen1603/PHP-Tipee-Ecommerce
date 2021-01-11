@extends('layouts.app')
@section('content') 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<style>
    h3{text-align: center}
    th{
        font-size:17px;
    }
</style>

<section>

    <div class="container">
        <h1 style="text-align: center">Đơn hàng của bạn</h1>
        <div class="orders">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Ngày mua</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col">Tình trạng</th>
                    </tr>
                </thead>
                 @foreach($user_order as $key => $order)
                <tbody>
                    <tr>
                        <td>{{$order->title}}</td>
                        <td>{{$order->created_at->format('Y-m-d')}}</td>
                        <td>{{$order->order_quantity}}</td>
                        <td>{{number_format($order->order_price) . ' đ'}}</td>
                        <td>{{$order->order_state}}</td>
                    </tr>
                </tbody>
               @endforeach      
            </table>
        </div>
       
    </div>
</section>

@endsection