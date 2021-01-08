@extends('layouts.app')
@section('content')
<div id="__next">
    <div class="home-page">
        <main>
            <div style="margin-top:15px ; margin-bottom:15px; display:flex" class="header-list-iteam list-iteam">
                @include('common.main_navigation')
                <div wrap="true" class=" wrap-home">
                    <div class="wrap-home-top ">
                        <div style="position:relative" width="100%" height="362px" class=" banners-maingrid">
                            <div data-view-id="home_top_banner_container" class="slide-root">
                                <div class="slider-wrapper">
                                    <div id="items-slick">
                                        <div class="item"><img src="./images/banner-center.jpg"></div>
                                        <div class="item"><img src="./images/banner-center-5.jpg"></div>
                                        <div class="item"><img src="./images/banner-center-3.jpg"></div>
                                        <div class="item"><img src="./images/banner-center-5.png"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div width="100%" data-view-id="home_top_banner_bottom_container"
                            class=" banner-bottom-container">
                            <div width="50%" height="181px" class=" 
                        banner-item">
                                <a data-view-id="home_top_banner_bottom_item" data-view-index="0" href=""
                                    aria-label=""><img width="292" height="181" src="./images/tiki-banner-8.png"
                                        srcSet="./images/tiki-banner-8.png" alt="" /></a>
                            </div>
                            <div width="50%" height="181px" class="banner-right-item">
                                <a data-view-id="home_top_banner_bottom_item" data-view-index="1" href=""
                                    aria-label=""><img width="292" height="181" src="./images/tiki-banner-5.png"
                                        alt="" /></a>
                            </div>
                        </div>
                    </div>
                    <div width="412px" data-view-id="home_top_banner_right_container" class=" banner-right-container">
                        <div width="50%" height="181px" class="banner-item">
                            <a data-view-index="0" data-view-id="home_top_banner_right_container" href=""
                                aria-label=""><img width="206" height="181" src="./images/tiki-banner-1.png"
                                    alt="" /></a>
                        </div>
                        <div width="50%" height="181px" class="banner-right-item">
                            <a data-view-index="1" data-view-id="home_top_banner_right_container" href=""
                                aria-label=""><img width="206" height="181" src="./images/banner-left-1.png"
                                    alt="" /></a>
                        </div>
                        <div width="50%" height="181px" class="banner-right-item">
                            <a data-view-index="2" data-view-id="home_top_banner_right_container" href=""
                                aria-label=""><img width="206" height="181" src="./images/tiki-banner-3.png"
                                    srcSet="./images/tiki-banner-3.png" alt="" /></a>
                        </div>
                        <div width="50%" height="181px" class="banner-item">
                            <a data-view-index="3" data-view-id="home_top_banner_right_container" href=""
                                aria-label=""><img width="206" height="181" src="./images/tiki-banner-4.png"
                                    alt="" /></a>
                        </div>
                        <div width="50%" height="181px" class="banner-item">
                            <a data-view-index="4" data-view-id="home_top_banner_right_container" href=""
                                aria-label=""><img width="206" height="181" src="./images/tiki-banner-2.png"
                                    alt="" /></a>
                        </div>
                        <div width="50%" height="181px" class="banner-right-item">
                            <a data-view-index="5" data-view-id="home_top_banner_right_container" href=""
                                aria-label=""><img width="206" height="181" src="../images/tiki-banner-1.png"
                                    srcSet="./images/tiki-banner-1.png" alt="" /></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Container-itwfbd-0 jFkAwY">
                <div class="style__StyledCallout-g2h8v0-0 bSfpQf"><img
                        src="https://salt.tikicdn.com/ts/banner/7c/aa/05/05f8119e8d13328a782a35ec01a7ea8d.png"
                        naptha_cursor="text"></div>
            </div>
            <div class="Container-itwfbd-0 jFkAwY">
                <div data-view-id="home_deal" class="TikiDeal__Wrapper-sc-1p33ah9-0 bjCkCy">
                    <div class="header">
                        <div><img src="https://frontend.tikicdn.com/_desktop-next/static/img/giasoc.svg"
                                alt="flash deal"><img
                                src="https://frontend.tikicdn.com/_desktop-next/static/img/flash.gif"
                                alt="flash deal"><img
                                src="https://frontend.tikicdn.com/_desktop-next/static/img/homnay.svg" alt="flash deal">
                        </div>
                        <div class="navigation">
                            <a data-view-id="home_deal_view_more" title="Xem tất cả Deal Hot"
                                href="/deal-hot?tab=now&amp;page=1">
                                Xem Tất Cả
                                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24"
                                    height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="body">
                        <div id="home_flashdeal_container" class="List__Wrapper-sc-1ap7nsk-0 SutiD">
                          <?php echo  WebService::getProductHome($allProducts);?>
                  
                        </div>
                    </div>
                    <div class="footer more"><a data-view-id="home_deal_view_more" href="/deal-hot?tab=now&amp;page=1"
                            title="Xem thêm Deal Hot" class="read-more">Xem thêm</a></div>
                </div>
            </div>
        </main>
        <span></span>
    </div>
    <div id="portal"></div>
</div>
@endsection
