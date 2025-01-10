<?php
$featuresContent = '';
$featuresTitle = 'Demo Title';
$featureDescriptions = 'Demo Description';
if (isset($singelWidgetData->widget_content)) {
    $featuresContent = $singelWidgetData->getTranslation('widget_content');
    $featuresTitle = isset($featuresContent['features_main_title']) ? $featuresContent['features_main_title'] : '';
    $featureDescriptions = isset($featuresContent['features_main_descriptions']) ? $featuresContent['features_main_descriptions'] : '';
    $featuresContent = isset($featuresContent['features']) ? $featuresContent['features'] : '';
}
?>


<!-- ===============  Choose-us start=============== -->

<div class="choose-us-section pt-120">
    <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="section-bg-bottom">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="section-title1">
                    <h2>{{ $featuresTitle }}</h2>
                    <p class="mb-0">{{ $featureDescriptions }}</p>
                </div>
            </div>
        </div>
        @if ($featuresContent)


            <div class="row d-flex justify-content-center g-4">
                @php
                    $count = 1;
                @endphp
                @foreach ($featuresContent as $key => $featureContentItem)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <div class="single-feature hover-border1 wow fadeInDown" data-wow-duration="1.5s"
                            data-wow-delay=".2s">
                            <span class="sn">{{ $count }}</span>
                            @if (isset($featureContentItem['img']))
                                <div class="icon">
                                    <img src="{{asset('uploads/features/' . $featureContentItem['img'] . '') }}" alt="image" width="70" height="70">
                                </div>
                            @endif
                            <div class="content">
                                @if ($featureContentItem['name'])
                                    <h5>{{ $featureContentItem['name'] }}</h5>
                                @endif

                                @if ($featureContentItem['descriptions'])
                                    <p class="para">{{ $featureContentItem['descriptions'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @php
                        $count++;
                    @endphp
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- ===============  Choose-us end=============== -->
