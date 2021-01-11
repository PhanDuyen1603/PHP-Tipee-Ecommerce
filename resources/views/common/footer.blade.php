<div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="RegisterModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-5 log-left">
                    <h2 id="exampleModalLabel">Tạo tài khoản</h2>
                    <p>Tạo tài khoản để theo dõi đơn hàng, lưu
                        <br>danh sách sản phẩm yêu thích, nhận
                        <br>nhiều ưu đãi hấp dẫn.
                    </p>
                    <img src="images/graphic-map-tipee.png" alt="">
                </div>
                <div class="col-7 log-right">
                <div class="icon-close" >
                    <span type="button" class="tikicon icon-circle-close" data-dismiss="modal" aria-label="Close"> </div>
                    <div class="test">
                        <div class="log-right-header">
                            <ul class="list-inline">
                                <li class="list-inline-item "><a class="social-icon text-xs-center" href="">Đăng
                                        nhập</a>    
                                </li>
                                <li class="list-inline-item log-active"><a class="social-icon text-xs-center"
                                        href="">Tạo tài khoản</a>
                                </li>
                            </ul>
                        </div>
                        <div class="login-form">
                            <!-- form dang ky -->
                            <form id="sign_in" method="POST" action="{{ route('register-account') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group row">
                                    <label for="full_name" class="col-3 col-form-label">Họ tên</label>
                                    <input type="text" class="form-control col-9 login-input" value="{{old('full_name')}}" id="full_name"
                                        name="full_name" placeholder="Nhập họ tên">
                                            @if($errors->has('full_name'))
                        <div class="error"><?php echo $errors->first('full_name');
                         ?></div>
                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-3 col-form-label">SĐT</label>
                                    <input type="text" class="form-control col-9 login-input" value="{{old('full_name')}}" id="phone"
                                        name="phone" placeholder="Nhập số điện thoại">
                                         @if($errors->has('phone'))
                        <div class="error"><?php echo $errors->first('phone');
                         ?></div>
                    @endif
                                </div>
                                
                                <div class="form-group row">
                                    <label for="email" class="col-3 col-form-label">Email</label>
                                    <input type="text" class="form-control col-9 login-input" value="{{old('full_name')}}" id="email" name="email"
                                        placeholder="Nhập email">
                                       @if($errors->has('email'))
                        <div class="error"><?php echo $errors->first('email');
                         ?></div>
                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-3 col-form-label">Mật khẩu</label>
                                    <input type="password" class="form-control col-9 login-input" value="{{old('full_name')}}" id="password"
                                        name="password" placeholder="Mật khẩu từ 6 đến 32 ký tự">
                                        @if($errors->has('password'))
                        <div class="error"><?php echo $errors->first('password');
                         ?></div>
                    @endif
                                </div>
                                <!-- gender -->
                                <div class="form-group row">
                                    <label for="gender" class="col-3 col-form-label">Giới tính</label>
                                    <div class="form-group row" style="margin-left: 10px;">
                                        <div class="form-check-inline gender-check">
                                            <input class="form-check-input" @php echo 'male'==old('gender') ? 'checked': '' @endphp type="radio" name="gender" value="male"
                                                checked>
                                            <label class="form-check-label" for="gender">Nam</label>
                                        </div>
                                        <div class="form-check-inline gender-check">
                                            <input class="form-check-input" @php echo 'female'==old('gender') ? 'checked': '' @endphp type="radio" name="gender" value="female">
                                            <label class="form-check-label" for="gender">Nữ</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- birth -->
                                <div class="form-group row">
                                    <label for="birthday" class="col-3 col-form-label">Ngày sinh</label>
                                    <div class="dropdown col-3">
                                         <select name="day"  class="form-control form-control-sm">
                                         @for($i=1;$i<=31;$i++)
                                         @php $number = $i<10 ? '0'.$i : $i; @endphp 
                                           <option @php echo $i==old('day') ? 'selected': '' @endphp >{{$number}}</option>
                                           @endfor
                                         </select>
                                    </div>
                                    <div class="dropdown col-3">
                                        <select name="month"  class="form-control form-control-sm">
                                         @for($i=1;$i<=12;$i++)
                                          @php $number = $i<10 ? '0'.$i : $i; @endphp 
                                           <option @php echo $i==old('day') ? 'selected': '' @endphp>{{$number}}</option>
                                           @endfor
                                         </select>
                                    </div>
                                    <div class="dropdown col-3">
                                        <select name="year" class="form-control form-control-sm">
                                         @for($i=1960;$i<=date('Y');$i++)
                                           <option @php echo $i==old('day') ? 'selected': '' @endphp>{{$i}}</option>
                                           @endfor
                                         </select>
                                    </div>
                                </div>
                                <!-- -->
                                <div class="form-group row">
                                    <div class="col-3"></div>
                                    <div class="col-9 log-right-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="inboxCheck"
                                                style="margin-top: 15px;">
                                            <label class="form-check-label" for="inboxCheck"
                                                style="margin: 10px 0px 15px; font-size: 12px; line-height: 22px;">Nhận
                                                các thông tin và chương trình khuyến mãi của Tiki qua
                                                email.</label>
                                        </div>
                                        <button type="submit" class="btn-lg btn-block log-btn">Tạo tài
                                            khoản</button>
                                        <p style="margin-bottom: 15px; font-size: 12px; line-height: 22px;">
                                            Khi bạn nhấn Đăng ký, bạn đã đồng ý thực hiện mọi giao dịch
                                            mua bán theo
                                            <a target="_blank" href=""
                                                rel="noreferrer">điều kiện sử dụng và chính sách của
                                                Tiki</a>.
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- {{\App\myHelper::getLogin()}} --}}
<!-- Modal -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-5 log-left">
                    <h2 id="exampleModalLabel">Đăng nhập</h2>
                    <p>Đăng nhập để theo dõi đơn hàng, lưu
                        <br>danh sách sản phẩm yêu thích, nhận
                        <br>nhiều ưu đãi hấp dẫn.
                    </p>
                    <img src="images/graphic-map-tipee.png" alt="">
                </div>
                <div class="col-7 log-right">
                    <div class="icon-close" >
                    <span type="button" class="tikicon icon-circle-close" data-dismiss="modal" aria-label="Close"> </div>
                    <div class="test">
                        <div class="log-right-header">
                            <ul class="list-inline">
                                <li class="list-inline-item log-active"><a class="social-icon text-xs-center"
                                        href="">Đăng nhập</a>
                                </li>
                                <li class="list-inline-item"><a class="social-icon text-xs-center"
                                        data-target="#signupform" href="">Tạo tài khoản</a>
                                </li>
                            </ul>
                        </div>
                        <!-- form dang nhap -->
                        <div class="login-form">
                           <form method="POST" action="{{route('loginCustomerAction')}}">
               {{ csrf_field() }}
                                <div class="form-group row">
                                    <label for="email" class="col-3 col-form-label">Email / SĐT</label>
                                    <input type="text" class="form-control col-9 login-input" name="email" id="email"
                                        placeholder="Nhập Email hoặc Số điện thoại">
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-3 col-form-label">Mật khẩu</label>
                                    <input type="password" class="form-control col-9 login-input" name="password" id="password"
                                        placeholder="Mật khẩu từ 6 đến 32 ký tự">
                                </div>
                                <!-- -->
                                <div class="form-group row">
                                    <div class="col-3"></div>
                                    <div class="col-9 log-right-item">
                                        <p class="forgot-password">Quên mật khẩu? Nhấn vào <a href="{{route('forgetPassword')}}"> đây</a>
                                        </p>
                                        <button type="submit" class="btn-lg btn-block log-btn">Đăng
                                            nhập</button>
                                        <button type="button" class="btn-lg btn-block log-btn log-fb"
                                            style="background: rgb(59, 89, 152); color: rgb(255, 255, 255)">
                                            <i class="fa fa-facebook-f"></i>
                                            <span>Đăng nhập bằng Facebook</span>
                                        </button>
                                        <button type="button" class="btn-lg btn-block log-btn log-fb"
                                            style="background: rgb(223, 74, 50); color: rgb(255, 255, 255)">
                                            <i class="fa fa-google-plus"></i>
                                            <span>Đăng nhập bằng Google</span>
                                        </button>
                                        <button type="button" class="btn-lg btn-block log-btn log-fb"
                                            style="background: rgb(15, 142, 221); color: rgb(255, 255, 255)">
                                            <i class="fa fa-tumblr"></i>
                                            <span>Đăng nhập bằng Zalo</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="footer-item">
        <div class="Container-itwfbd-0 jFkAwY" style="display: flex; height: 100px; padding-top: 32px;">
            <div class="NewsLetter-icon"><img
                    src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/newsletter.png" width="163"
                    alt=""></div>
            <div class="NewsLetter-description">
                <h3>Đăng ký nhận bản tin Tipee</h3>
                <h5>Đừng bỏ lỡ hàng ngàn sản phẩm và chương trình siêu hấp dẫn</h5>
            </div>
            <div class="NewsLetter-form">
                <div><input type="email" placeholder="Địa chỉ email của bạn" value=""></div>
                <button>Đăng ký</button>
            </div>
        </div>
    </div>
    <div class="footer__information">   
    <div class="flex-view jFkAwY">
        <div class="block" style="width: 268px;">
            <h4>HỖ TRỢ KHÁCH HÀNG</h4>
            <p class="hotline">Hotline chăm sóc khách hàng: <a href="">1900-6035</a><span
                    class="small-text">(1000đ/phút , 8-21h kể cả T7, CN)</span></p><a rel="noreferrer"
                href="" class="small-text" target="_blank">Các câu hỏi thường gặp</a><a
                rel="noreferrer" href="" class="small-text" target="_blank">Gửi
                yêu cầu hỗ trợ</a><a rel="noreferrer" href=""
                class="small-text" target="_blank">Hướng dẫn đặt hàng</a><a rel="noreferrer"
                href="" class="small-text" target="_blank">Phương thức
                vận chuyển</a><a rel="noreferrer" href="" class="small-text"
                target="_blank">Chính sách đổi trả</a><a rel="noreferrer"
                href="" class="small-text" target="_blank">Hướng dẫn trả
                góp</a><a rel="noreferrer" href="" class="small-text"
                target="_blank">Chính sách hàng nhập khẩu</a>
            <p class="security">Hỗ trợ khách hàng: <a href="">hotro@tipee.vn</a></p>
            <p class="security">Báo lỗi bảo mật: <a href="">security@tipee.vn</a></p>
        </div>
        <div class="block">
            <h4>VỀ TIPEE</h4><a rel="noreferrer" href="" class="small-text"
                target="_blank">Giới thiệu Tipee</a><a rel="noreferrer" href=""
                class="small-text" target="_blank">Tuyển Dụng</a><a rel="noreferrer"
                href="" class="small-text" target="_blank">Chính sách bảo mật thanh
                toán</a><a rel="noreferrer" href="" class="small-text"
                target="_blank">Chính sách bảo mật thông tin cá nhân</a><a rel="noreferrer"
                href="" class="small-text" target="_blank">Chính sách
                giải quyết khiếu nại</a><a rel="noreferrer" href=""
                class="small-text" target="_blank">Điều khoản sử dụng</a><a rel="noreferrer"
                href=""
                class="small-text" target="_blank">Giới thiệu Tipee Xu</a><a rel="noreferrer"
                href="" class="small-text" target="_blank">Bán hàng
                doanh nghiệp</a>
        </div>
        <div class="block">
            <h4>HỢP TÁC VÀ LIÊN KẾT</h4><a rel="noreferrer" href=""
                class="small-text" target="_blank">Quy chế hoạt động Sàn GDTMĐT</a><a rel="noreferrer"
                href="" class="small-text" target="_blank">Bán hàng cùng Tipee</a>
        </div>
        <div class="block">
            <h4>PHƯƠNG THỨC THANH TOÁN</h4>
            <p><img class="icon" src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/visa.svg" width="54"
                    alt=""><img class="icon"
                    src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/mastercard.svg" width="54"
                    alt=""><img class="icon" src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/jcb.svg"
                    width="54" alt=""><img class="icon"
                    src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/cash.svg" width="54" alt=""><img
                    class="icon" src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/internet-banking.svg"
                    width="54" alt=""><img class="icon"
                    src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/installment.svg" width="54"
                    alt=""></p>
        </div>
        <div class="block">
            <h4>KẾT NỐI VỚI CHÚNG TÔI</h4>
            <p><a rel="noreferrer" href="" class="icon" target="_blank"
                    title="Facebook"><img src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/fb.svg"
                        width="32" alt=""></a><a rel="noreferrer" href=""
                    class="icon" target="_blank" title="Youtube"><img
                        src="https://frontend.tikicdn.com/_desktop-next/static/img/footer/youtube.svg" width="32"
                        alt=""></a><a rel="noreferrer" href="" class="icon"
                    target="_blank" title="Zalo"><i class="icon tikicon icon-footer-zalo"></i></a></p>
            
        </div>
    </div>
</div>
    <script type="text/javascript">
    $(document).ready(function() {
        jQuery('#items-slick').slick({
            dots: true,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true
        });
    });
   @if(URL::current()!=route('forgetPassword')):
    @if ($errors->any())
    $('#RegisterModal').modal('show')

    @endif
    @endif
    </script>
</footer>
<div class="message"><a href="https://www.facebook.com/messages/t/100025635753016" target="_blank" class="bt-fbmessage"><i><img src="/images/ico-message.png" alt=""></i></a></div>


</body>

</html>