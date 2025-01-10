@extends('frontend.template-'.selectedTheme().'.partials.master')
@section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')
    <div class="login-section pt-120 pb-120">
        <img alt="imges" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="imges" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-xl-6 col-lg-8 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>{{ translate('Log In') }}</h3>
                            <p>{{ translate('New Customer') }}? <a
                                    href="{{ url('register') }}">{{ translate('signup here') }}</a></p>
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <p><span class="text-danger">{{ $error }}</span></p>
                                @endforeach
                            @endif
                        </div>

                        <form class="w-100" method="POST" id="loginForm" action="{{ route('login') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Enter Your Email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('login') }}"
                                            class="@error('login') is-invalid @enderror" name="login"
                                            placeholder="{{ translate('Enter Username or Email') }}">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Password') }} <span class="text-danger">*</span></label>
                                        <input type="password" class="@error('password') is-invalid @enderror"
                                            name="password" id="password" placeholder="{{ translate('Password') }}" />
                                        <i class="bi bi-eye-slash" id="togglePassword"></i>

                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-agreement form-inner d-flex justify-content-between flex-wrap">
                                        <div class="form-group">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}"
                                                class="forgot-pass">{{ translate('Forgotten Password') }}</a>
                                        @endif
                                    </div>
                                </div>
                                @if (get_setting('google_recapcha_check') == 1)
                                    <div class="g-recaptcha mb-3" data-sitekey="{{ get_setting('recaptcha_key') }}"></div>
                                    @if (Session::has('g-recaptcha-response'))
                                        <p class="text-danger"> {{ Session::get('g-recaptcha-response') }}</p>
                                    @endif
                                @endif
                            </div>
                            <button type="submit" class="account-btn mt-3">{{ translate('Log in') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
