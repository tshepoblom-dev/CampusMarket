<?php
$proceduresList = [];
if (isset($singelWidgetData->widget_content)) {
    $proceduresList = $singelWidgetData->getTranslation("widget_content");
}
?>

<!-- ===============  How-it-works start=============== -->
@if ($proceduresList)
    <div class="how-work-section pt-120">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="section-bg-top">
        <div class="container">
            @php
                $count = 0;
                $total = count($proceduresList['procedures']);
            @endphp
            @foreach ($proceduresList['procedures'] as $key => $procedureItem)
                @if ($count == 0 || $count % 2 == 0)
                    <div class="row g-4  {{$total!==$key? "mb-60" :""}} ">
                        <div class="col-xl-6 col-lg-6">
                            <div class="how-work-content wow fadeInUp" data-wow-duration="1.5s"
                                data-wow-delay=".{{ $count + 1 }}s">
                                <span>{{ $count + 1 }}.</span>

                                @if (isset($procedureItem['name']))
                                    <h3>{{ $procedureItem['name'] }}</h3>
                                @endif

                                @if (isset($procedureItem['description']))
                                    <p class="para">
                                        {{ $procedureItem['description'] }}
                                    </p>
                                @endif
                                @if (isset($procedureItem['button_text']) && isset($procedureItem['button_url']))
                                    <a href="{{ $procedureItem['button_url'] }}"
                                        class="eg-btn btn--primary btn--md">{{ $procedureItem['button_text'] }}</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 d-flex justify-content-lg-end justify-content-center">
                            <div class="how-work-img wow fadeInDown" data-wow-duration="1.5s"
                                data-wow-delay=".{{ $count + 1 }}s">
                                @if (isset($procedureItem['img']))
                                    <img alt="image" src="{{ asset('uploads/procedures/' . $procedureItem['img']) }}"
                                        class="work-img">
                                @else
                                    <img alt="image" src="{{ asset('frontend/images/bg/how-work1.png') }}"
                                        class="work-img">
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row g-4 {{$total!==$key? "mb-60" :""}} ">
                        <div
                            class="col-xl-6 col-lg-6 d-flex justify-content-lg-start justify-content-center order-lg-1 order-2">
                            <div class="how-work-img wow fadeInDown" data-wow-duration="1.5s"
                                data-wow-delay=".{{ $count + 1 }}s">
                                @if (isset($procedureItem['img']))
                                    <img alt="image" src="{{ asset('uploads/procedures/' . $procedureItem['img']) }}"
                                        class="work-img">
                                @else
                                    <img alt="image" src="{{ asset('frontend/images/bg/how-work1.png') }}"
                                        class="work-img">
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 order-lg-2 order-1">
                            <div class="how-work-content wow fadeInUp" data-wow-duration="1.5s"
                                data-wow-delay=".{{ $count + 1 }}s">
                                <span>{{ $count + 1 }}.</span>
                                @if (isset($procedureItem['name']))
                                    <h3>{{ $procedureItem['name'] }}</h3>
                                @endif
                                @if (isset($procedureItem['description']))
                                    <p class="para">
                                        {{ $procedureItem['description'] }}
                                    </p>
                                @endif
                                @if (isset($procedureItem['button_text']) && isset($procedureItem['button_url']))
                                    <a href="{{ $procedureItem['button_url'] }}"
                                        class="eg-btn btn--primary btn--md">{{ $procedureItem['button_text'] }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @php
                    $count++;
                @endphp
            @endforeach

        </div>
    </div>
@endif
<!-- ===============  How-it-works end=============== -->
