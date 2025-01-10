@extends('frontend.template-'.selectedTheme().'.partials.master')
@section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')
    <div class="login-section pt-120 pb-120">
        <img alt="imges" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="imges" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-xl-10 col-lg-10 col-md-10">
                    <div class="form-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <div class="form-title">
                            <h3>{{ translate('Verify Your Email Address') }}</h3>
                            <p>{{ translate('Before proceeding, please check your email for a verification link') }}.</p>
                            <p>{{ translate('If you did not receive the email') }},</p>
                        </div>
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ translate('A fresh verification link has been sent to your email address') }}.
                            </div>
                        @endif
                        <form class="w-100 text-center" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="eg-btn btn--primary header-btn border-0">{{ translate('click here to request another') }}</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
