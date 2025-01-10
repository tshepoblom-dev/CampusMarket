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
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form class="w-100" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Enter Your Email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" value="{{ old('email') }}"
                                            class="@error('email') is-invalid @enderror" name="email"
                                            placeholder="{{ translate('Enter Your Email') }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="account-btn">{{ translate('Send Password Reset Link') }}</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
