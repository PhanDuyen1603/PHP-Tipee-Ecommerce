<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('t-admin/css/login.min.css') }}">
    <!--===============================================================================================-->
</head>

<body class="login-admin  login">
    <img class="logo-admin logo" src="./images/tipee-logo.png" alt="">
    <div class="content">
        <div class="login-form">
            <h3 class="form-title font-green">Admin Login</h3>
            <form action="{{ route('admin.login') }}" method="POST" class="login100-form validate-form p-b-33 p-t-5">
                @csrf
                <div class="control-label visible-ie8 visible-ie9" data-validate="Enter username">
                    <input
                        class="form-control form-control-solid placeholder-no-fix @error('email') is-invalid @enderror"
                        type="text" name="email" id="email" placeholder="Username or Email" required autofocus>
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="control-label visible-ie8 visible-ie9" data-validate="Enter password">
                    <input
                        class="form-control form-control-solid placeholder-no-fix @error('password') is-invalid @enderror"
                        type="password" id="password" name="password" placeholder="Password" required
                        autocomplete="current-password">
                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button class="btn green uppercase">
                        Login
                    </button>

                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1">Remember
                        <span></span>
                    </label>

                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>    
                </div>

                

                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Create an account</a>
                    </p>
                </div>

            </form>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('assets/login/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/select2/select2.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/login/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/vendor/countdowntime/countdowntime.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('assets/login/js/main.js') }}"></script>

</body>

</html>
