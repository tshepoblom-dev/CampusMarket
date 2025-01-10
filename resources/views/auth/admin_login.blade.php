<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $page_title ?? '' }}</title>
    <link rel="icon" href="{{ asset('frontend/images/bg/sm-logo.png') }}" type="image/gif" sizes="20x20">
    <link rel="stylesheet" href="{{ asset('backend/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
</head>

<body>

    <div class="login-bg d-flex jusify-content-center align-items-center">
        <img src="{{ asset('backend/images/bg/login-vector.png') }}" class="img-fluid login-vector">
        <div class="login-form-area">
            <div class="form-title">
                <h4>{{ translate('Wellcome To') }} <span>{{ get_setting('company_name') }}</span></h4>
                <p>{{ $page_title ?? '' }}</p>
            </div>
            <form class="admin-login" action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="form-inner mb-35">
                    <label>{{ translate('Username or Email') }} <span class="text-danger">*</span></label>
                    <input type="text" name="login" value="{{ old('login') }}"
                        class="@error('login') is-invalid @enderror @if (Session::has('error')) is-invalid @endif"
                        placeholder="{{ translate('Enter Username or Email') }}">
                    <img src="{{ asset('backend/images/icons/user-icon.png') }}" class="input-icon" alt="username">
                    @error('login')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if (Session::has('error'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ session('error') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-inner mb-25">
                    <label>{{ translate('Password') }} <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="@error('password') is-invalid @enderror"
                        placeholder="*******">
                    <img src="{{ asset('backend/images/icons/pass-icon.png') }}" class="input-icon" alt="password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="eg-btn btn--primary login-btn"> <img
                        src="{{ asset('backend/images/icons/login-user.svg') }}" alt=""> {{translate('Login')}}</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('backend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/fontawesome.min.js') }}"></script>

</body>
</html>
