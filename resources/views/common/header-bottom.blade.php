<div class="menu-top-right">
                                    <ul class="nav_login_resign_group_header clear">
                                       <li  class="customer-icon">
                                          @if(Auth::check())
                                          <?php 
                                             $url_img = 'images/avatar';
                                             $url_avatar = '';
                                             if(!empty(Auth::user()->avatar) && Auth::user()->avatar !=""):
                                                 $avatar_thumb= Helpers::getThumbnail($url_img,Auth::user()->avatar, 50, 50, "resize");
                                                 if(strpos($avatar_thumb, 'placehold') !== false):
                                                     $avatar_thumb=$url_img.$avatar_thumb;
                                                 endif;
                                             else:
                                                 $avatar_thumb="https://dummyimage.com/50x50/000/fff";
                                             endif;
                                             if(Auth::user()->avatar == ''){
                                                 $url_avatar = '<i class="fa fa-user-circle" aria-hidden="true"></i>';
                                             } else{
                                                 $url_avatar = '<img src="'.$avatar_thumb.'" class="avatar_user_header">';
                                             }
                                             ?>
                                          <a href="/">
                                          {!!$url_avatar!!}
                                          <span class="user_text">
                                          <span class="text_txt">{{Auth::user()->name}}</span>
                                          </span>
                                          </a>
                                          <div class="customer-action-hover">
                                             <a href="/">Tài khoản</a>
                                             <a href="/">Lịch sử mua hàng</a>
                                             <a href="/">Đổi mật khẩu</a>
                                             <a href="/">Đăng xuất</a>
                                          </div>
                                          @else
                                          <a href="javascript:void(0)" class="r-lnk" data-toggle="modal" data-target="#myModal" data-backdrop="false">
                                          <span class="user_text">
                                          <span class="text_txt">Đăng nhập</span>
                                          </span>
                                          </a>
                                          @endif
                                       </li>
                                       <li class= " minicart-wrapper my-card my-cart-icon shopping-cart basel-cart-design-2">
                                          <a class="icon_cart_tbn_a action showcart" href="/cart" >
                                          <span class="basel-cart-totals">
                                          <span class="basel-cart-number badge badge-notify my-cart-badge">0</span>
                                          <span class="subtotal-divider">/</span>
                                          <span class="basel-cart-subtotal">
                                          </span>
                                          </span>
                                          </a>
                                          <div class="dropdown-wrap-cat">
                                             <div class="dropdown-cat">
                                                <div class="widget woocommerce widget_shopping_cart">
                                                   <div class="widget_shopping_cart_content">
                                                   </div>
                                                   <!--widget_shopping_cart_content-->
                                                </div>
                                                <!--widget_shopping_cart-->
                                             </div>
                                             <!--dropdown-cat-->
                                          </div>
                                          <!--dropdown-wrap-cat-->
                                       </li>
                                    </ul>
                                 </div>
                                 <!--nav-main-->                 
                              </div>
<div class="header-bottom">
    <div style="position:relative;display:flex;align-items:center;justify-content:space-between;height:40px"
        class="header-list-iteam list-iteam">
        <div class="list-sp"><a class="Menu-button"><i class="Menu-icon tikicon icon-burger-menu"></i><span>DANH MỤC SẢN PHẨM</span></a></div>
        <div class="header_location"><a data-view-id="header_location_picker"><i
                    class="tikicon icon-location-picker"></i><span>Bạn muốn giao hàng tới đâu?</span></a>
        </div>

        <div class="wishlist"><a class="" href="/customer/wishlist"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg><span>Sản phẩm yêu thích</span></a></div>
        <div class="header_bottom_icons_recently_view"><a
                class="ct-cart"><i class="tikicon icon-arrow-down"></i><span>Sản phẩm bạn đã xem</span></a>
                </div>
                   <div class="header_bottom_icons_recently_view"><a
                class="ct-cart"><i class="tikicon icon-arrow-down"></i><span>Kênh người bán</span></a>
                </div>

            <div class="cart-notification">
                <div class="header-list-iteam list-iteam">
                    <div class="content" data-view-id="header_bottom_recently_view_container">
                        <p class="empty">Bạn chưa xem sản phẩm nào.<br>Hãy tiếp tục khám phá Tiki, các sản phẩm bạn
                            đã xem sẽ hiển thị ở đây!</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>