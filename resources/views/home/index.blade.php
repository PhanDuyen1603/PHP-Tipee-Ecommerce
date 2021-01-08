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
                            
                        </div>
                        <div class="body">
                            <div id="home_new" class="home_flashdeal_container">
                                <?php echo WebService::getProductHome($productNews); ?>
                            </div>
                            
                            
                        </div>

                        
                            
                       
                    </div>

                    <div id="home_sale">
                                <div class="header-title">
                                    <h3 class="title">SẢN PHẨM BÁN CHẠY</h3>
                                </div>
                                <div class="home_flashdeal_container">
                                    <?php echo WebService::getProductHome($productSales); ?>
                                </div>
                        </div>

                    <div id="home_favourite">
                                <div class="header-title">
                                    <h3 class="title">SẢN PHẨM ĐƯỢC YÊU THÍCH</h3>
                                </div>
                                <div class="home_flashdeal_container">
                                    <?php echo WebService::getProductHome($productFavourite); ?>
                                </div>
                            </div>
                </div>
            </main>
            <span></span>
        </div>
        <div id="portal"></div>
    </div>
@endsection
