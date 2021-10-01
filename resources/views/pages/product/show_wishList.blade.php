@extends('layouts.app')
@section('content') 

<section id="wishList">
    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Tên sản phẩm</th>                   
                    <th scope="col">Giá</th>
                    
                </tr>
            </thead>              
            @foreach($wishListOfUser as $key => $wish)
            <tbody>
                <tr>
                    <td><img src="{{asset('images/product/'.$wish->thubnail)}}" width="100px" height="100px" alt=""></td>
                    <td>{{$wish->title}}</td>
                    <td>{{number_format($wish->price_promotion) . ' đ'}}</td>
                </tr>                   
            </tbody>               
        
          @endforeach    
      </table>
    </div>
</section>

@endsection