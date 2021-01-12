<?php
  $segment_check = Request::segment(2); 
?>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
   <div class="logo-tipee" style="
    
    text-align: center;
    margin-top: 10px;

"><a data-view-id="header_main_logo" href="#"><img class="logoTipee" src="./images/tipee-logo.png" alt="" style="
    width: 110px;
">
            <i class="tikicon icon-tiki_short" src="./images/tipee-logo.png"></i></a><a href="#" aria-label="" data-view-id="header_campaign_logo"></a>
         </div>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview">
            <a href="{{route('admin.dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="{{route('index')}}" target="_blank" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Xem trang chủ
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-pages', 'page', 'edit-page'))){ echo 'menu-open'; } ?>">
            <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-pages', 'page', 'edit-page'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Page
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.pages')}}" class="nav-link <?php if(in_array($segment_check, array('list-pages'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.createPage')}}" class="nav-link <?php if(in_array($segment_check, array('page'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New Page</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview hidden <?php if(in_array($segment_check, array('list-post', 'post', 'edit-post', 'list-category-post', 'category-post'))){ echo 'menu-open'; } ?>">
            <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-post', 'post', 'edit-post', 'list-category-post', 'category-post'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>
                Tin tức
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.posts')}}" class="nav-link <?php if(in_array($segment_check, array('list-post'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Tất cả tin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.createPost')}}" class="nav-link <?php if(in_array($segment_check, array('post'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Viết bài mới</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.listCategoryPost')}}" class="nav-link <?php if(in_array($segment_check, array('list-category-post', 'category-post'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Thể loại tin</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-products', 'product', 'product', 'list-category-product', 'category-product', 'list-variable-product', 'variable-product', 'list-combo', 'combo'))){ echo 'menu-open'; } ?>">
            <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-products', 'product', 'product', 'list-category-product', 'category-product', 'list-variable-product', 'variable-product', 'list-combo', 'combo'))){ echo 'active'; } ?>">
              <i class="nav-icon fab fa-product-hunt"></i>
              <p>
                Sản phẩm
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.listProduct')}}" class="nav-link <?php if(in_array($segment_check, array('list-products', 'product'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Tất cả sản phẩm</p>
                </a>
              </li>
            
              <li class="nav-item ">
                <a href="{{route('admin.listCategoryProduct')}}" class="nav-link <?php if(in_array($segment_check, array('list-category-product', 'category-product'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Thể loại sản phẩm</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item hidden">
            <a href="{{route('admin.listBrand')}}" class="nav-link <?php if(in_array($segment_check, array('list-brand', 'brand'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-blog"></i>
              <p>
                Thương hiệu
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{route('admin.listOrder')}}" class="nav-link <?php if(in_array($segment_check, array('list-order', 'order'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Đơn hàng
              </p>
            </a>
          </li>
        
          <li class="nav-item">
            <a href="{{route('admin.revenue')}}" class="nav-link <?php if(in_array($segment_check, array('list-order', 'order'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Doanh thu
              </p>
            </a>
          </li>

          <li class="nav-item hidden">
            <a href="{{route('admin.slider')}}" class="nav-link <?php if(in_array($segment_check, array('list-slider', 'slider'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Slider Home
              </p>
            </a>
          </li>
         
          
          <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-users', 'user'))){ echo 'menu-open'; } ?>">
            <a href="javascript:void(0)" class="nav-link <?php if(in_array($segment_check, array('list-users', 'user'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.listUsers')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>List Users</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.addUsers')}}" class="nav-link">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Add New User</p>
                </a>
              </li>
            </ul>
          </li>
         
          <!-- Setting -->
          <li class="nav-header">Setting</li>
          <li class="nav-item hidden">
            <a href="{{route('admin.themeOption')}}" class="nav-link">
              <i class="nav-icon fas fa-sliders-h"></i>
              <p>
                Theme Option
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.menu')}}" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Menu
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.changePassword')}}" class="nav-link">
              <i class="nav-icon fas fa-unlock-alt"></i>
              <p>
                Đổi mật khẩu
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.logout')}}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          <!-- Export Excel -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>