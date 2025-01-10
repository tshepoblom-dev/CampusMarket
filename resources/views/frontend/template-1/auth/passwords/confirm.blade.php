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
                            <h3>{{ translate('Confirm Password') }}</h3>
                            <p>{{ translate('Please confirm your password before continuing') }}.</p>
                        </div>

                        <form class="w-100" method="POST" action="{{ route('password.confirm') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Password') }}<span class="text-danger">*</span></label>
                                        <input type="password" class="@error('password') is-invalid @enderror"
                                            name="password" placeholder="{{ translate('Password') }}" required
                                            autocomplete="current-password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="account-btn">{{ translate('Confirm Password') }}</button>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="forgot-pass">{{ translate('Forgotten Password') }}</a>
                            @endif
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
