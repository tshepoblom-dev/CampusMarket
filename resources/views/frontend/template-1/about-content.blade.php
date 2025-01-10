@php
    $aboutContentData = [];

    if (isset($singelWidgetData->widget_content)) {
        $aboutContentData = $singelWidgetData->getTranslation("widget_content");
    }
@endphp


<!-- ========== inner-page-banner end ============= -->
{{-- @if ($aboutContentData) --}}
<div class="about-section pt-120">
    <img src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top" alt="section-bg">
    <div class="container">
        <div class="row d-flex justify-content-center g-4">
            <div class="col-lg-6 col-md-10">
                <div class="about-img-area">
                    <div class="total-tag">
                        <img src="{{ asset('frontend/images/bg/total-tag.png') }}" alt="">
                        <h6>{{ translate('Total Raised') }}</h6>
                        <h5>{{ currency_symbol() . ' ' . (isset($aboutContentData['total_raised']) ? $aboutContentData['total_raised'] : 0) }}
                        </h5>
                    </div>
                    @if (isset($aboutContentData['img']))
                        <img src="{{ asset('uploads/about_content/' . $aboutContentData['img']) }}"
                            class="img-fluid about-img wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s"
                            alt="about-img">
                    @endif
                    <img src="{{ asset('frontend/images/bg/about-linear.png') }}" class="img-fluid about-linear"
                        alt="">
                    <img src="{{ asset('frontend/images/bg/about-vector.png') }}" class="img-fluid about-vector"
                        alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-10">
                <div class="about-content wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <span>{{ isset($aboutContentData['about_content_sub_title']) ? $aboutContentData['about_content_sub_title'] : '' }}</span>
                    <h2>{{ isset($aboutContentData['about_content_title']) ? $aboutContentData['about_content_title'] : '' }}
                    </h2>
                    <p class="para mb-30">
                        @php
                        $contentDescript= isset($aboutContentData['about_content_descriptions']) ?  $aboutContentData['about_content_descriptions']  : '';


                       @endphp

                        {!! clean($contentDescript) !!}
                    </p>
                    @if (isset($aboutContentData['about_content_btn_text']) && isset($aboutContentData['about_content_btn_url']))
                        <a href="{{ $aboutContentData['about_content_btn_url'] ?? '' }}"
                            class="eg-btn btn--primary btn--md">{{ $aboutContentData['about_content_btn_text'] ?? '' }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endif --}}
<!-- ===============  Choose-us start=============== -->
