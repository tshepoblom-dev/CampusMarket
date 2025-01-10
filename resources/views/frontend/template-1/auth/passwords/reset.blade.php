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
                            <h3>{{ translate('Reset Password') }}</h3>
                        </div>

                        <form class="w-100" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Email Address') }}<span class="text-danger">*</span></label>
                                        <input type="email" value="{{ $email ?? old('email') }}"
                                            class="@error('email') is-invalid @enderror" name="email"
                                            placeholder="{{ translate('Email Address') }}" required autocomplete="email"
                                            autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-inner">
                                        <label>{{ translate('Password') }}<span class="text-danger">*</span></label>
                                        <input type="password" class="@error('password') is-invalid @enderror"
                                            name="password" placeholder="{{ translate('Password') }}" required
                                            autocomplete="new-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-inner">
                                        <label>{{ translate('Confirm Password') }} <span
                                                class="text-danger">*</span></label>
                                        <input id="password-confirm" type="password" name="password_confirmation" required
                                            autocomplete="new-password" placeholder="{{ translate('Confirm Password') }}">
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="account-btn">{{ translate('Reset Password') }}</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
