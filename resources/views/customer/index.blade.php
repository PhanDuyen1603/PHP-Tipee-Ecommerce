@extends('layouts.app')
@section('content')
                  <meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <link rel="stylesheet" href="css/customer.css">
  <script
  src="https://code.jquery.com/jquery-3.5.1.js"
  integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/customer.js"></script>
<div id="__next">
    <div class="account-page" >
        <main>
            <div style="margin-top:15px ; margin-bottom:15px; display:flex" class="header-list-iteam list-iteam">
                @include('common.customer.left-sidebar')
              <div style=" margin-left:15px ; width:500px;">
                <div>
                    <h3>Thông tin tài khoản</h3>
                </div>
                <div style=" margin-left:15px ; width:950px; background-color: #fff7f7; padding: 30px; ">
                  <form style="  width:500px;">
                    <div class="mb-3">
                        <label for="inputName" class="form-label">Họ tên:</label>
                        <input type="text" class="form-control" id="inputName" value="{{$userinfo->name }}" pattern="[A-z]{1,30}">
                    </div>
                    <div class="mb-3">
                        <label for="inputPhone" class="form-label">Số điện thoại:</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inputPhone" value="{{$userinfo->phone }}" pattern="[0-9]{10-14}" placeholder="Hãy nhập SĐT để trãi nghiệm tốt hơn" aria-label="Hãy nhập SĐT để trãi nghiệm tốt hơn" aria-describedby="button-addon2" >
                        </div>
                    </div>
                  
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="inputEmail" value="{{$userinfo->email }}" placeholder="Thêm email để cập nhật những chương trình khuyến mãi mới nhất">
                    </div>
                    <div class="mb-3">
                        <label style="margin-right:10px;" class="form-label">Giới tính:</label>
                        <div  class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"  @if ($userinfo->gender === "male") checked="true" @endif>
                            <label class="form-check-label" for="inlineRadio1">Nam</label>
                        </div>
                            <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" @if ($userinfo->gender === "female") checked="true" @endif id="inlineRadio2" value="option2">
                            <label class="form-check-label" for="inlineRadio2">Nữ</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="datepicker" class="form-label">Ngày sinh:</label>
                        <input type="datetime" class="form-control" id="datepicker" value="{{$userinfo->birthday }}" placeholder="Không bắt buộc">
                    
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="changePassword">
                        <label class="form-check-label" for="changePassword">
                            Thay đổi mật khẩu
                        </label>
                        <div id="changepassblock" class="hide">
                            <div class="mb-3">
                                <label for="OldPassword" class="form-label">Mật khẩu cũ:</label>
                                <input type="password" class="form-control" id="OldPassword" placeholder="Nhập mật khẩu cũ">
                            </div>
                            <div class="mb-3">
                                <label for="NewPassword" class="form-label">Mật khẩu mới:</label>
                                <input type="password" class="form-control" id="NewPassword" placeholder="Nhập mật khẩu mới">
                            </div>
                            <div class="mb-3">
                                <label for="NewPassword1" class="form-label">Nhập lại:</label>
                                <input type="password" class="form-control" id="NewPassword1" placeholder="Nhập lại mật khẩu mới">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <button class="btn btn-success" type="button" id="UpdateButton">Cập nhật</button>
                </form>
                </div>
              </div>
        </main>
    </div>
</div>
@endsection
