@php 
$email = session('email');
if(!$email){
  // $url = URL::to('/');
  // header("Location: $url");
  // die();
}
@endphp
@extends('layouts.app')
@section('content')
    <div class="wrap proceed">
    	<div class="container ">
    		<br>
        @php   $mail = $email ? $email : 'info@gmail.com'; @endphp
		 Chúng tôi đã gửi liên kết để đăng nhập vào {{$mail}}. Kiểm tra cả hộp thư rác nếu bạn không tìm thấy email trong hộp thư chính.
     <div class="btn-footer">
                        <a href="{{route('index')}}" class="btn bg-red waves-effect btn-close">Quay về trang chủ</a>
                      </div>
    	</div>
    </div>
    <style>
      .proceed .btn-footer{
          text-align: center;
          margin-top: 10px;
      }
      .proceed .btn-footer .btn-close:hover{
        color: #fff;
        text-decoration: none;
      }
      .proceed .btn-footer .btn-close{
            padding: 7px 15px;
      }
    </style>
@endsection

