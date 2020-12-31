<?php
  $segment_check = Request::segment(2); 
?>
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
      <img src="{{asset('img/avatar-admin.png')}}" alt="Siêu Thị Miền Nam" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Siêu Thị Miền Nam</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/avatar-admin.png')}}" class="img-circle elevation-2" alt="Siêu Thị Miền Nam">
        </div>
        <div class="info">
          <a href="javascript:void(0)" class="d-block">Siêu Thị Miền Nam</a>
        </div>
      </div>

      <?php /* <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> */ ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
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
          <li class="nav-item has-treeview <?php if(in_array($segment_check, array('list-post', 'post', 'edit-post', 'list-category-post', 'category-post'))){ echo 'menu-open'; } ?>">
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
              <li class="nav-item">
                <a href="{{route('admin.listCombo')}}" class="nav-link <?php if(in_array($segment_check, array('list-combo', 'combo'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Gói Combo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.listCategoryProduct')}}" class="nav-link <?php if(in_array($segment_check, array('list-category-product', 'category-product'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Thể loại sản phẩm</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.listVariableProduct')}}" class="nav-link <?php if(in_array($segment_check, array('list-variable-product', 'variable-product'))){ echo 'active'; } ?>">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Biến thể sản phẩm</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
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
            <a href="{{route('admin.discountCode')}}" class="nav-link <?php if(in_array($segment_check, array('list-discount-code', 'discount-code'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-percent"></i>
              <p>
                Mã giảm giá
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.slider')}}" class="nav-link <?php if(in_array($segment_check, array('list-slider', 'slider'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Slider Home
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.listVideo')}}" class="nav-link <?php if(in_array($segment_check, array('list-video', 'video'))){ echo 'active'; } ?>">
              <i class="nav-icon fas fa-film"></i>
              <p>
                Videos
              </p>
            </a>
          </li>
          {{--
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
          --}}
          <!-- Setting -->
          <li class="nav-header">Setting</li>
          <li class="nav-item">
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
          <li class="nav-header">Export Excel</li>
          <li class="nav-item">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-export-customer" class="nav-link">
              <i class="nav-icon fas fa-file-excel"></i>
              <p>
                Export Customers
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-export-order" class="nav-link">
              <i class="nav-icon fas fa-file-excel"></i>
              <p>
                Export Orders
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.exportProducts')}}" class="nav-link">
              <i class="nav-icon fas fa-file-excel"></i>
              <p>
                Export Products
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>