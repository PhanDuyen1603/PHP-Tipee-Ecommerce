@extends('layouts.app')
@section('seo')
<title>404 Trang bạn truy cập không tồn tại - Thông tin doanh nghiệp</title>
@endsection
@section('content')
    <div id="wrapper_container_fix" class="clear">
    	<div class="container clear">
    	    <div class="body-container border-group clear">
               <section id="section" class="section clear">
                      <div class="group-section-wrap clear row">
                            <div class="col-xs-12 col-sm-7 col-lg-7">
                               <!-- Info -->
                                <div class="info">
                                   <h1>Oppps!</h1>
                                   <h2>Trang bạn truy cập không tồn tại!</h2>
                                   <p>Vui lòng nhập đường dẫn chính xác hoặc trở về Trang chủ</p>
                                   <div class="tbl_back clear">
                                    <a href="{{url('/')}}" class="btn btn-info">Trang chủ</a>
                                    <a href="{{url('/')}}/lien-he/" class="btn btn-warning">Liên hệ</a>
                                   </div>
                               </div>
                               <!-- end Info -->
                            </div>
                            <div class="col-xs-12 col-sm-5 col-lg-5 text-center">
                                <div class="fighting">
                                     <img src="{{ asset('img/fighting.gif') }}" alt="Fighting">
                                </div>
                                <!-- end Fighting -->
                           </div>
                      </div><!--group-section-wrap-->
               </section><!--#section-->
            </div><!--body-container-->
    	</div>
    </div>
@endsection
