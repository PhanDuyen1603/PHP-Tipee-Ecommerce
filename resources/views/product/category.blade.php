@extends('layouts.app')
@section('content')
    <div id="__next">
        <div class="home-page">
            <main>
                <div class="Container-itwfbd-0 jFkAwY">
                    <div data-view-id="home_deal" class="TikiDeal__Wrapper-sc-1p33ah9-0 bjCkCy">
                        <div class="body">
                            <div id="home_sale">
                                <div class="header-title">
                                    <h3 class="title">Danh mục : "{{ $category->categoryName }}"</h3>
                                </div>
                                <div class="home_flashdeal_container">
                                    @foreach ($products as $product)
                                        @include('partials.product_item')
                                    @endforeach

                                </div>
                            </div>
                            <div class="pagination-search">
                            {{ $products->links() }}
                            </div>

                        </div>

                    </div>
                </div>
            </main>
            <span></span>
        </div>
        <div id="portal"></div>
    </div>
@endsection
