@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            @if (session('notify'))
                <div class="card form-forget-pw">
                    <div class="title-forget-pw">
                        <h3 class="title">Quên mật khẩu?</h3>


                    </div>

                    <div class="card-body">
                        <p class="description">Email đã được gửi, vui lòng kiểm tra hộp thư để cập nhật thông tin.</p>
                        <div class="form-group">
                           <a href="/">
                            <input type="submit" value="Thoát" class="btn float-right login_btn"> </a>
                        </div>
                    </div>
                </div>
        </div>
    @else
        <div class="card form-forget-pw">
            <div class="title-forget-pw">
                <h3 class="title">Quên mật khẩu?</h3>
            </div>

            <div class="card-body">
                <p class="description">Vui lòng cung cấp email đăng nhập để lấy lại mật khẩu.</p>
                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="text-danger"> {{ $error }}</div>
                    @endforeach
                @endif
                @if (session('status'))
                    <div class="text-danger"> {{ session('status') }}</div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('actionForgetPassword') }}">
                    {{ csrf_field() }}
                    <div class="input-group form-group">

                        <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}"
                            required autofocus>
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
