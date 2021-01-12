@extends('layouts.app')
@section('content')

    <div class="heading">Danh sách yêu thích</div>
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
                @foreach ($wishListOfUser as $key => $wish)
                    <tbody>
                        <tr>
                            <td><a href="{{ route('product.detail', $wish->slug) }}"><img
                                        src="{{ asset('images/product/' . $wish->thubnail) }}" width="100px" height="100px"
                                        alt=""></a></td>
                            <td><a class="name"
                                href="{{ route('product.detail', $wish->slug) }}">{{ $wish->title }}</a></td>
                            <td>{{ number_format($wish->price_promotion) . ' đ' }}</td>
                        </tr>
                    </tbody>

                @endforeach
            </table>

            
    </section>

@endsection
