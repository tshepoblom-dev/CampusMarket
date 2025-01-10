@php
    $breadcrumb = get_setting('breadcrumb_color');
    $breadcrumb = str_replace(' ', '', $breadcrumb);
    $hex = $breadcrumb;
    [$r, $g, $b] = sscanf($hex, '#%02x%02x%02x');
    $hex = "$r $g $b";
    $hex = str_replace(' ', ',', $hex);

@endphp

@php
    if (Session::has('locale')) {
        $locale = Session::get('locale', Config::get('app.locale'));
    } else {
        $locale = get_setting('DEFAULT_LANGUAGE', 'en');
    }
@endphp


<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $locale == 'sa' ? 'rtl' : '' }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (Request::url() != url('/'))
        <title>{{ $title ?? '' }} - {{ get_setting('company_name') }} </title>
    @else
        <title>{{ $title ?? get_setting('company_name') }} </title>
    @endif


    @if (fileExists('assets/logo/', get_setting('front_favicon')) != false &&  get_setting('front_favicon') != null)
        <link rel="icon" href="{{ asset('assets/logo/' . get_setting('front_favicon')) }}" type="image/gif"
            sizes="20x20">
    @else
        <link rel="icon" href="{{ asset('frontend/images/bg/sm-logo.png') }}" type="image/gif" sizes="20x20">
    @endif

    <!-- Meta -->
    @if (!Request::is('customer/*'))
        <meta name="robots" content="index, follow">
        <meta name="googlebot-news" content="index, follow">
        <meta name="msnbot" content="index, follow">
    @endif




    <meta name="description" content="{{isset($meta_description)? clean($meta_description):"" }}">
    <meta name="keywords" content="{{ $meta_keyward ?? '' }}">

    <meta name="author" content="{{ get_setting('company_name') }}">
    <meta name="resource-type" content="document">
    <meta name="contact" content="{{ get_setting('company_email1') }}">

    <meta property="og:site_name" content="{{ get_setting('company_name') }}">
    <meta property="og:title" content="{{ $title ?? '' }}">
    <meta property="og:description" content="{{isset($meta_description)?clean($meta_description):"" }}">
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:site" content="{{ '@' . get_setting('company_name') }}">
    <meta name="brand_name" content="{{ get_setting('company_name') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? '' }}">
    <meta name="twitter:description" content="{{isset($meta_description)?clean($meta_description):"" }}">
    <meta name="twitter:domain" content="{{ url('/') }}">
    @if (isset($meta_image) && $meta_image)
        <meta property="og:image" content="{{ $meta_image?? '' }}">
        <meta name="twitter:image" content="{{ $meta_image?? '' }}">
    @endif


    <link rel="stylesheet" href="{{ asset('frontend/css/animate.css') }}">
    <!-- css file link -->
    <link rel="stylesheet" href="{{ asset('frontend/css/all.css') }}">

    <!-- bootstrap 5 -->

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.rtl.min.css') }}">

    <!-- box-icon -->
    <link rel="stylesheet" href="{{ asset('frontend/css/boxicons.min.css') }}">

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap-icons.css') }}">

    <!-- jquery ui -->
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery-ui.css') }}">

    <!-- swiper-slide -->
    <link rel="stylesheet" href="{{ asset('frontend/css/swiper-bundle.min.css') }}">

    <!-- slick-slide -->
    <link rel="stylesheet" href="{{ asset('frontend/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/libraries/cutealert/css/style.css') }}">
    <!-- select 2 -->
    <link rel="stylesheet" href="{{ asset('frontend/css/nice-select.css') }}">

    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/magnific-popup.css') }}">

    <!-- odometer css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/odometer.css') }}">

    <!-- style css -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/modify.css') }}">
    @if ($locale == 'sa')
        <link rel="stylesheet" href="{{ asset('frontend/css/style-rtl.css') }}">
    @endif

    @if (get_setting('analytics_id'))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ get_setting('analytics_id') }}"></script>

        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', "{{ get_setting('analytics_id') }}");
        </script>
    @endif

    <style>
        :root {
            --primary: {{ get_setting('primary_color') ?? '#32c36c' }};
            --secondary: {{ get_setting('secondary_color') ?? '#1F2230' }};
        }

        .inner-banner {
            background: rgba(<?php echo $hex; ?>, .9);
        }
    </style>




</head>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<body>

    @if (get_setting('show_preloader') == 1)
        <!-- preloader -->
        <div class="preloader">
            <div class="loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    @endif

    <div class="layout-wrapper">
        <!-- =============== search-area start =============== -->

        @include('frontend.template-1.partials.mobile_search')

        <!-- =============== search-area end  =============== -->

        <!-- ========== topbar ============= -->
        @include('frontend.template-1.partials.topbar')

        <!-- ========== header============= -->

        @include('frontend.template-1.partials.header')

        <!-- ========== header end============= -->

        <!-- ===============  Hero area end=============== -->

        <!-- main-container -->
        {{-- Main Content Area --}}
        <div class="main-content">
            @yield('content')
        </div>

        <!-- =============== counter-section end =============== -->

        <!-- =============== Footer-action-section start =============== -->

        @include('frontend.template-1.partials.footer')

        <!-- =============== Footer-action-section end =============== -->
    </div>
    <!-- js file link -->
    <script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.js') }}"></script>
    <script src="{{ asset('backend/libraries/cutealert/js/cute-alert.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.nice-select.js') }}"></script>
    <script src="{{ asset('frontend/js/odometer.min.js') }}"></script>
    <script src="{{ asset('frontend/js/range-slider.js') }}"></script>
    <script src="{{ asset('frontend/js/viewport.jquery.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('frontend/js/main.js') }}"></script>
    <!--Start of Tawk.to Script-->




    <!--End of Tawk.to Script-->
    <script>
        var successAlertImage = "{{ asset('backend/libraries/cutealert/img/success.svg') }}";
        var errorAlertImage = "{{ asset('backend/libraries/cutealert/img/error.svg') }}";

        @if (Session::has('success'))
            cuteToast({
                type: "success",
                message: "{{ session('success') }}",
                img: successAlertImage,
                timer: 4000
            });
        @endif

        @if (Session::has('error'))
            cuteToast({
                type: "error",
                message: "{{ session('error') }}",
                img: errorAlertImage,
                timer: 4000
            });
        @endif
    </script>

    @stack('js')


    @if (get_setting('tawk_enabled') == 1 && get_setting('tawk_code') !== '')
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = "{{ get_setting('tawk_code') }}";
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    @endif


    <p class="d-none cookie"></p>
</body>

</html>
