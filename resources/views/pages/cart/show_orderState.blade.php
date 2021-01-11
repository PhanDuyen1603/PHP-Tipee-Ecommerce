@extends('layouts.app')
@section('content') 

<section>

    <div class="container">
        <h1>Tra cứu đơn hàng</h1>
        <div class="timeline">

        </div>
        <div class="customer_info">

        </div>
        <div class="orders">
            <div class="table">
                <thead>
                    <tr>
                        <td>Tên sản phẩm</td>
                        <td>Số lượng</td>
                    </tr>
                </thead>
                @foreach($user_order as $key => $order)
                <tbody>
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
                @endforeach
            </div>
        </div>
       
    </div>
</section>

@endsection