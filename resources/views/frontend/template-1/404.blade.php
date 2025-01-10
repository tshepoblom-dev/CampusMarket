<div class="error-section pt-120 pb-120">
    <img src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top" alt="section-bg-top">
    <img src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom" alt="section-bg-top">
    <img src="{{ asset('frontend/images/bg/e-vector1.svg') }}" class="evector1" alt="section-bg-top">
    <img src="{{ asset('frontend/images/bg/e-vector2.svg') }}" class="evector2" alt="section-bg-top">
    <img src="{{ asset('frontend/images/bg/e-vector3.svg') }}" class="evector3" alt="section-bg-top">
    <img src="{{ asset('frontend/images/bg/e-vector4.svg') }}" class="evector4" alt="section-bg-top">
    <div class="container">
        <div class="row d-flex justify-content-center g-4">
            <div class="col-lg-6 col-md-8 text-center">
                <div class="error-wrapper">
                    <img src="{{ asset('frontend/images/bg/error-bg.png') }}" class="error-bg img-fluid" alt="error-bg">
                    <div class="error-content wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <h2>Sorry we can’t find that page</h2>
                        <p class="para">The page you are looking for was moved, removed, renamed or never existed</p>
                        <a href="{{ URL::to('/') }}" class="eg-btn btn--primary btn--md">Back Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
