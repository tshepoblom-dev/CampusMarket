<!-- ========== inner-page-banner start ============= -->

<div class="inner-banner">
    <div class="container">
        <h2 class="inner-banner-title wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s">{{ $title }}
        </h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}"> {{ translate('Home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </nav>
        <img class="breadcumb-img d-lg-flex d-none" src="{{ asset('assets/logo/' . get_setting('breadcamp_img')) }}"
            alt="">
    </div>


</div>

<!-- ========== inner-page-banner end ============= -->
