@php

    $limit = 6;
    $orderBy = 'asc';
    $liveAuctionsTitle = '';
    $liveAuctionsDescriptions = '';
    $productType = '';
    $page_url = '';
    if (isset($singelWidgetData->widget_content)) {
        $widgetContent = $singelWidgetData->getTranslation('widget_content');
        $liveAuctionsTitle = isset($widgetContent['live_auctions_title']) ? $widgetContent['live_auctions_title'] : '';
        $liveAuctionsDescriptions = isset($widgetContent['live_auctions_descriptions']) ? $widgetContent['live_auctions_descriptions'] : '';
        $limit = isset($widgetContent['total_display_live_auctions']) ? $widgetContent['total_display_live_auctions'] : 6;
        $orderBy = isset($widgetContent['live_auctions_order_by']) ? $widgetContent['live_auctions_order_by'] : 'asc';
        $productType = isset($widgetContent['product_type']) ? $widgetContent['product_type'] : 'all';
        $page_url = isset($widgetContent['page_url']) ? $widgetContent['page_url'] : '#';
    }

    $type = $productType == 'auction' ? 1 : ($productType == 'direct' ? 2 : '');
    $liveAuctionsProduct = products(['type' => $type], $limit = $limit, '', $orderBy);

@endphp
<div class="live-auction pt-120">
    <input type="hidden" id="live_limit" value="{{ $liveAuctionsProduct->count() }}">
    <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg">
    <div class="container position-relative">
        <img alt="image" src="{{ asset('frontend/images/bg/dotted1.png') }}" class="dotted1">
        <img alt="image" src="{{ asset('frontend/images/bg/dotted1.png') }}" class="dotted2">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="section-title1">
                    <h2>{{ $liveAuctionsTitle }}</h2>
                    <p class="mb-0">{{ $liveAuctionsDescriptions }}</p>
                </div>
            </div>
        </div>
        <div class="row gy-4 d-flex justify-content-center">
            @if ($liveAuctionsProduct->count() > 0)
                @foreach ($liveAuctionsProduct as $key => $productItem)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        @include('frontend.template-'.$templateId.'.partials.live_auction')
                    </div>
                @endforeach
            @else
                <h2 class="text-center">{{ translate('No Data Found') }}</h2>
            @endif
        </div>
        <div class="row d-flex justify-content-center pt-60">
            <div class="col-md-4 text-center">
                <a target="__blank" href="{{ $page_url }}"
                    class="eg-btn btn--primary btn--md mx-auto">{{ translate('View All') }}</a>
            </div>
        </div>
    </div>
</div>
