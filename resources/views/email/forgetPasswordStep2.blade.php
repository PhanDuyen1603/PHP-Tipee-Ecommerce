@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-center h-100">
       <div class="card">
          <div class="card-header">
             <h3>Quên mật khẩu</h3>
          </div>
          <div class="card-body">
             @if (count($errors) >0)
                @foreach($errors->all() as $error)
                  <div class="text-danger"> {{ $error }}</div>
                @endforeach
             @endif
             @if (session('status'))
                <div class="text-danger"> {{ session('status') }}</div>
             @endif
             <form class="form-horizontal" method="POST" action="{{ route('actionForgetPasswordStep3') }}">
                {{ csrf_field() }}
                <div class="input-group form-group">
                   <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                   </div>
                   <input type="password" name="new_password" class="form-control" placeholder="Mật khẩu mới" required autofocus>
                   @if ($errors->has('new_password'))
                   <span class="help-block">
                   <strong>{{ $errors->first('new_password') }}</strong>
                   </span>
                   @endif
                </div>
                <div class="input-group form-group">
                   <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                   </div>
                   <input type="password" class="form-control" placeholder="Xác nhận mật khẩu mới" name="confirm_new_password" required>
                   @if ($errors->has('confirm_new_password'))
                   <span class="help-block">
                   <strong>{{ $errors->first('confirm_new_password') }}</strong>
                   </span>
                   @endif
                </div>
                <div class="form-group">
                   <input type="submit" value="Đổi mật khẩu" class="btn float-right login_btn" style="width: 150px">
                </div>
             </form>
          </div>
          <div class="card-footer">
             
          </div>
       </div>
    </div>
 </div>
 @endsection