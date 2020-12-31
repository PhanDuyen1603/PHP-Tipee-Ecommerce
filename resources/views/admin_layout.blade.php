<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Material Design Inspired Side Navigation Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.5.2/materia/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{asset('/backend/css/sidebar.css')}}">
    <link rel="stylesheet" href="{{asset('/backend/css/main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
</head>
<body>
    <main>
        <aside>
            <nav class="sidebar">
                <div class="sidebar-header">
                    <a href="#" class="ml-4"><img width="200" src="{{asset('/backend/images/logo.png')}}" alt=""></a>
                    <i class="btn-sidebar-close mdi mdi-close mdi-24px"></i>
                </div>
                <div class="sidebar-content">
                    <ul>
                        <li class="header-menu">
                            <span>Quản lý</span>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="mdi mdi-monitor-dashboard mdi-18px"></i>                               
                                <span class="menu-text">Danh mục</span>
                                <!-- <span class="badge badge-pill badge-warning">Admin</span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li><a href="{{URL::to('add-category')}}">Thêm danh mục</a></li>
                                    <li><a href="{{URL::to('all-category')}}">Danh sách danh mục</a></li>
                                    <!-- <li><a href="#">Dashboard v.3<span class="badge badge-pill badge-success">Admin</span></a></li> -->
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="mdi mdi-monitor-dashboard mdi-18px"></i>
                                <span class="menu-text">Sản phẩm</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li><a href="{{URL::to('add-product')}}">Thêm sản phẩm</a></li>
                                    <li><a href="{{URL::to('all-product')}}">Danh sách sản phẩm</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="mdi mdi-monitor-dashboard mdi-18px"></i>
                                <span class="menu-text">Thương hiệu</span>
                                <!-- <span class="badge badge-pill badge-danger">3</span> -->
                            </a>
                            <div class="sidebar-submenu">
                                <ul>
                                    <li><a href="{{URL::to('add-brand')}}">Thêm thương hiệu</a></li>
                                    <li><a href="{{URL::to('all-brand')}}">Danh sách thương hiệu</a></li>
                                </ul>
                            </div>
                        </li>
                     
                        <li>
                            <a href="#">
                                <i class="mdi mdi-card-account-details-outline mdi-18px"></i>
                                <span class="menu-text">Danh sách Admin</span>

                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="mdi mdi-book mdi-18px"></i>
                                <span class="menu-text">Projects</span>

                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="mdi mdi-folder mdi-18px"></i>
                                <span class="menu-text">Documents</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="mdi mdi-calendar mdi-18px"></i>
                                <span class="menu-text">Calendar</span>
                                <span class="badge badge-pill badge-primary">Beta</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-footer">
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0,10">
                            <i class="mdi mdi-bell mdi-18px"></i>
                            <span class="badge badge-pill badge-warning">3</span>
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="notifications-header">
                                <i class="mdi mdi-bell"></i>
                                Notifications
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <div class="notification-content">
                                    <div class="icon">
                                        <i class="mdi mdi-check-bold text-success border border-success"></i>
                                    </div>
                                    <div class="content">
                                        <div class="notification-detail">Do eiusmod tempor incididunt est pariatur aute laboris cillum consequat reprehenderit excepteur.</div>
                                        <div class="notification-time">
                                            6 minutes ago
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="notification-content">
                                    <div class="icon">
                                        <i class="mdi mdi-exclamation-thick text-info border border-info"></i>
                                    </div>
                                    <div class="content">
                                        <div class="notification-detail">Deserunt fugiat exercitation cillum duis cillum tempor esse incididunt ex esse mollit.</div>
                                        <div class="notification-time">
                                            Today
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="notification-content">
                                    <div class="icon">
                                        <i class="mdi mdi-alert text-warning border border-warning"></i>
                                    </div>
                                    <div class="content">
                                        <div class="notification-detail">Ullamco minim nostrud exercitation ipsum eu.</div>
                                        <div class="notification-time">
                                            Yesterday
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">View all notifications</a>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0,10">
                            <i class="mdi mdi-email mdi-18px"></i>
                            <span class="badge badge-pill badge-success">7</span>
                        </a>
                        <div class="dropdown-menu messages">
                            <div class="messages-header">
                                <i class="mdi mdi-email"></i>
                                Messages
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">
                                <div class="message-content">
                                    <div class="pic">
                                        <img src="img/user.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="message-title">
                                            <strong>Sander Sørensen</strong>
                                        </div>
                                        <div class="message-detail">Lorem ipsum dolor sit amet consectetur adipisicing elit. In totam explicabo</div>
                                    </div>
                                </div>

                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="message-content">
                                    <div class="pic">
                                        <img src="img/user.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="message-title">
                                            <strong>Jenny Ford</strong>
                                        </div>
                                        <div class="message-detail">Veniam velit tempor aliquip duis deserunt culpa et fugiat ea minim.</div>
                                    </div>
                                </div>

                            </a>
                            <a class="dropdown-item" href="#">
                                <div class="message-content">
                                    <div class="pic">
                                        <img src="img/user.jpg" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="message-title">
                                            <strong>Kayla Wood</strong>
                                        </div>
                                        <div class="message-detail">Voluptate sint laboris est officia quis dolore laborum ex magna tempor id aute.</div>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="#">View all messages</a>

                        </div>
                    </div>
                    <a href="#"><i class="mdi mdi-cog mdi-18px"></i> </a>
                    <a href="#"><i class="mdi mdi-power mdi-18px"></i></a>
                </div>
            </nav>

            <a class="btn-sidebar-show btn btn-sm btn-dark" href="#">
                <i class="mdi mdi-menu"></i>
            </a>

        </aside>
     
        <section class="content">
            <header>
                <h1>TRANG QUẢN LÝ - ADMIN</h1>
            </header>
            
            <article> 
                <div class="main_content">
             
                    @yield('admin_content')
                </div>
                <div class="footer">
                    <p>© Copyright Tipee 2020</p>
                </div>
                {{-- <button type="button" class="btn btn-primary btn-lg" id="btn-show"><i class="mdi mdi-eye-outline mr-3"></i>Show</button> --}}
                {{-- <button type="button" class="btn btn-primary btn-lg" id="btn-hide"><i class="mdi mdi-eye-off-outline mr-3"></i>Hide</button> --}}
            </article>
        </section>
    
        
    </main>
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="{{asset('/backend/js/main.js')}}"></script>
</body>
</html>
