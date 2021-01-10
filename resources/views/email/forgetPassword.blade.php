@extends('layouts.app')
@section('content')
<div class="container">
    <div class="d-flex justify-content-center h-100">
      @if(session('notify'))
        <h1>Bạn vui lòng check mail để lấy link đổi mật khẩu</h1>
      @else
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
            <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword') }}">
               {{ csrf_field() }}
               <div class="input-group form-group">
                  <div class="input-group-prepend">
                     <span class="input-group-text"><i class="fas fa-user"></i></span>
                  </div>
                  <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required autofocus>
                  @if ($errors->has('email'))
                  <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
               </div>
               <div class="form-group">
                  <input type="submit" value="Tiếp tục" class="btn float-right login_btn">
               </div>
            </form>
         </div>
      </div>
      @endif
       
    </div>
 </div>
@endsection

