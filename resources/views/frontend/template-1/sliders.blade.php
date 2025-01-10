@php
    $sliderDataItem = [];
    if (isset($singelWidgetData->widget_content)) {
        $sliderDataItem = $singelWidgetData->getTranslation('widget_content');
    }
@endphp
@if (isset($sliderDataItem['slider']))
    <div class="hero-area hero-style-one">
        <div class="hero-main-wrapper position-relative">
            <div class="swiper banner1">
                <div class="swiper-wrapper">
                    @foreach ($sliderDataItem['slider'] as $key => $itemData)
                        <div class="swiper-slide">
                            <div class="slider-bg-{{ $key }}">
                                <style>
                                    .hero-style-one .slider-bg-{{ $key }} {
                                        padding: 160px 0px;
                                        width: 100%;
                                        overflow: hidden;
                                        height: 100%;
                                        z-index: 1;
                                        position: relative;
                                    }

                                    @media (min-width: 1200px) and (max-width: 1399px) {
                                        .hero-style-one .slider-bg-{{ $key }} {
                                            padding: 160px 0px;
                                        }
                                    }

                                    @media (min-width: 992px) and (max-width: 1199px) {
                                        .hero-style-one .slider-bg-{{ $key }} {
                                            padding: 160px 0px;
                                        }
                                    }

                                    @media (max-width: 991px) {
                                        .hero-style-one .slider-bg-{{ $key }} {
                                            padding: 120px 0px;
                                        }
                                    }

                                    .hero-style-one .slider-bg-{{ $key }}::before {
                                        content: "";

                                        @if (isset($itemData['img']))
                                            background-image: url({{ asset('uploads/sliders/' . $itemData['img']) }}) !important;
                                        @endif
                                        background-size: cover;
                                        position: absolute;
                                        width: 100%;
                                        height: 100%;
                                        top: 0;
                                        left: 0;
                                        right: 0;
                                        z-index: -9;
                                        -webkit-animation: large 26s linear infinite alternate;
                                        animation: large 26s linear infinite alternate;
                                    }

                                    .hero-style-one .slider-bg-{{ $key }}::after {
                                        content: "";
                                        position: absolute;
                                        width: 100%;
                                        height: 100%;
                                        top: 0;
                                        left: 0;
                                        z-index: -9;
                                        background: rgba(0, 0, 0, 0.55);
                                    }

                                    @-webkit-keyframes large {
                                        0% {
                                            transform: scale(1);
                                        }

                                        100% {
                                            transform: scale(1.6);
                                        }
                                    }
                                </style>

                                <div class="container">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-xl-10 col-lg-10">
                                            <div class="banner1-content">
                                                <span>{{ $itemData['sub_title'] ?? '' }}</span>
                                                <h1>{{ $itemData['title'] ?? '' }}</h1>
                                                <p>{{ $itemData['description'] ?? '' }}</p>
                                                @if (isset($itemData['button_text']))
                                                    <a href="{{ $itemData['button_url'] }}"
                                                        class="eg-btn btn--primary btn--lg">{{ $itemData['button_text'] }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="hero-one-pagination d-flex justify-content-center flex-column align-items-center gap-3"></div>
        </div>
    </div>
@endif
