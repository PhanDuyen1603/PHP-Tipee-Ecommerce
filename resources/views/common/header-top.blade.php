<div class="header-list-iteam list-iteam">
   <div class=" header-list-item-nav">
      <div class="middle-feft">
         <div class="logo-tipee"><a data-view-id="header_main_logo" href="/"><img class="logoTipee" src="{{URL::to('/images/tipee-logo.png')}}" alt="">
            <i class="tikicon icon-tiki_short" src="{{URL::to('/images/tipee-logo.png')}}"></i></a><a href="#" aria-label="" data-view-id="header_campaign_logo"></a>
         </div>
         <div class="search-form">
         <form class="form minisearch" id="search_mini_form" action="/search/" method="get">
            <div class="search-form-left"><input type="text" name="query_string" data-view-id="main_search_form_input" value=""
               placeholder="Tìm sản phẩm, danh mục hay thương hiệu mong muốn ..." class="eUnWAD"><button
               data-view-id="main_search_form_button" class="ieXBRV"><i class="tikicon icon-search"></i>Tìm
               kiếm</button>
            </div>
            </form>
         </div>
      </div>
      <div data-view-id="header_user_shortcut" class="order">
         <a title="Theo dõi đơn hàng"
            data-view-id="header_user_shortcut_order_tracking" href="">
            <div class="check-order"><i class="tikicon icon-tracking"></i><span class="check-order-title">Theo
               dõi<br>đơn hàng</span>
            </div>
         </a>
         <div data-view-id="header_user_shortcut_notification" class="check-order"><i
            class="tikicon icon-notification"></i><span
            class="Userstyle__ItemCount-sc-6e6am-3 lnmTTi"></span><span class=" check-order-title" href="#">Thông
            báo<br>của tôi</span>
         </div>
         
         @if(Auth::check())
         <div data-view-id="header_header_account_container" class="acc-login iasHpw">
            <div class="dropdown">
               <img class="profile-icon" src="https://salt.tikicdn.com/ts/upload/67/de/1e/90e54b0a7a59948dd910ba50954c702e.png"> <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{Auth::user()->name}}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="{{route('CustomerLogout')}}">Đăng xuất</a>
            </div>
          </div>
          </div>
         @else               
         <div data-view-id="header_user_shortcut_account" class=" check-order" type="button" data-toggle="modal"
            data-target="#loginform">
            <i class="tikicon icon-user"></i><span class="check-order-title"><span
               class="login-title">Đăng nhập</span><br><small>Tài
            khoản</small></span>
            <div class="toggle-list-login toggler"><button data-view-id="header_user_shortcut_account_item"
               class="title-login" data-toggle="modal" data-target="#LoginModal">Đăng nhập</button><button
               data-view-id="header_user_shortcut_account_item" class="title-login" data-toggle="modal"
               data-target="#RegisterModal">Tạo tài khoản</button><button
               data-view-id="header_user_shortcut_account_item" class="login-fb"><span class="account-left"><i
               class="tikicon icon-facebook-white"></i></span>Đăng nhập bằng
               Facebook</button><button data-view-id="header_user_shortcut_account_item" class="login-gg"><span
                  class="account-left"><i class="tikicon icon-google-white"></i></span>Đăng nhập bằng
               Google</button><button data-view-id="header_user_shortcut_account_item" class="login-zl"><span
                  class="account-left"><i class="tikicon icon-zalo"></i></span>Đăng nhập bằng Zalo</button>
            </div>
      
            <!-- sign up -->
          
            <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
            
         </div>
         @endif
         <div data-view-id="header_user_shortcut_cart" class=" cart">
            {{-- tạm thời chưa dùng route, 1 là user id  --}}
            <a href="{{route('cart.show')}}">
               <div class="cart-ct"><i class="tikicon icon-cart"></i><span class="check-order-title">Giỏ hàng<span
                  {{-- class="cart-index">{{$count_product}}</span></span></div> --}}
                  class="cart-index">0</span></span></div>
            </a>
         </div>
      </div>
   </div>
</div>

