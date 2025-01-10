@php
    $limit = 3;
    $orderBy = 'asc';
    $upcomingAuctionsTitle = 'Upcoming Auction';
    $upcomingAuctionsDescriptions = 'Demo Descriptions';
    $viewUrl = '';
    $productType = '';

    if (isset($singelWidgetData->widget_content)) {
        $widgetContent = $singelWidgetData->getTranslation('widget_content');
        $upcomingAuctionsTitle = isset($widgetContent['upcoming_auctions_main_title']) ? $widgetContent['upcoming_auctions_main_title'] : '';
        $upcomingAuctionsDescriptions = isset($widgetContent['upcoming_auctions_descriptions']) ? $widgetContent['upcoming_auctions_descriptions'] : '';
        $limit = isset($widgetContent['total_upcoming_auctions_display']) ? $widgetContent['total_upcoming_auctions_display'] : 3;
        $orderBy = isset($widgetContent['upcoming_auctions_order_by']) ? $widgetContent['upcoming_auctions_order_by'] : 'asc';
        $viewUrl = isset($widgetContent['page_url']) ? $widgetContent['page_url'] : '';
        $productType = isset($widgetContent['product_type']) ? $widgetContent['product_type'] : '';
    }

    $upcomingAuctionsProduct = getUpComingAuctionsProduct($limit, $orderBy, $productType);

    // dd($upcomingAuctionsProduct);

@endphp
<div class="upcoming-seciton pt-120">
    <input type="hidden" id="upcoming_limit" value="{{ $upcomingAuctionsProduct->count() }}">
    <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="section-title1">
                    <h2>{{ $upcomingAuctionsTitle }}</h2>
                    <p class="mb-0">{{ $upcomingAuctionsDescriptions }}</p>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            @if ($upcomingAuctionsProduct->count() > 0)
                <div class="swiper upcoming-slider">
                    <div class="swiper-wrapper">
                        @foreach ($upcomingAuctionsProduct as $key => $productItem)
                            <div class="swiper-slide">
                                <div class="eg-card c-feature-card1 wow animate fadeInDown" data-wow-duration="1.5s"
                                    data-wow-delay="0.{{ $key + 1 * 2 }}s">
                                    <div class="auction-img">

                                        <img alt="Acution image"
                                            src="{{ asset('uploads/products/features/' . $productItem->features_image) }}">
                                        @if ($productItem->sale_type == 1)
                                            <div class="auction-timer2 gap-lg-3 gap-md-2 gap-1"
                                                id="upcoming{{ $key }}"
                                                data-upcoming-start-date="{{ date('F d, Y H:i:s', strtotime($productItem->start_date)) }}">
                                                <div class="countdown-single">
                                                    <h5 id="upcoming_days{{ $key }}"></h5>
                                                    <span>{{ translate('Days') }}</span>
                                                </div>
                                                <div class="countdown-single">
                                                    <h5 id="upcoming_hours{{ $key }}"></h5>
                                                    <span>{{ translate('Hours') }}</span>
                                                </div>
                                                <div class="countdown-single">
                                                    <h5 id="upcoming_minutes{{ $key }}"></h5>
                                                    <span>{{ translate('Mins') }}</span>
                                                </div>
                                                <div class="countdown-single">
                                                    <h5 id="upcoming_seconds{{ $key }}"></h5>
                                                    <span>{{ translate('Secs') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="author-area2">
                                            <a class="d-flex"
                                                href="{{ url('shop/' . $productItem?->users?->shop?->slug) }}">
                                                <div class="author-name">
                                                    <span>{{ translate('by') }}
                                                        {{ '@' . $productItem?->users?->shop?->name }}</span>
                                                </div>
                                                <div class="author-emo">
                                                    @if (fileExists('uploads/shop/', $productItem?->users?->shop?->logo) != false &&
                                                            $productItem?->users?->shop?->logo != null)
                                                        <img src="{{ asset('uploads/shop/' . $productItem?->users?->shop?->logo) }}"
                                                            alt="Shop Logo">
                                                    @else
                                                        <img src="{{ asset('uploads/placeholder.jpg') }}"
                                                            alt="Shop Logo">
                                                    @endif


                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="c-feature-content">
                                        <div class="c-feature-category">
                                            {{ $productItem?->category?->getTranslation('name', $lang) }}</div>
                                        <a href="{{ route('auction.details', $productItem->slug) }}">
                                            <h4>{{ $productItem->getTranslation('name', $lang) }}</h4>
                                        </a>
                                        @if ($productItem->sale_type == 1)
                                            <p>{{ translate('Bidding Price') }} :
                                                <span>{{ currency_symbol() . $productItem->min_bid_price }}</span>
                                            </p>
                                        @else
                                            <p>{{ translate('Buy Price') }} : @if ($productItem->sale_price)
                                                    <del>{{ currency_symbol() . $productItem->price }}</del>
                                                <span>{{ currency_symbol() . $productItem->sale_price }}</span>@else<span>{{ currency_symbol() . $productItem->price }}</span>
                                                @endif
                                            </p>
                                        @endif

                                        <div class="auction-card-bttm">
                                            <a href="{{ route('auction.details', $productItem->slug) }}"
                                                class="eg-btn btn--primary btn--sm">{{ translate('View Details') }}</a>
                                            <div class="share-area">
                                                <ul class="social-icons d-flex">
                                                    <li><a href="https://www.facebook.com/"><i
                                                                class="bx bxl-facebook"></i></a></li>
                                                    <li><a href="https://www.twitter.com/"><i
                                                                class="bx bxl-twitter"></i></a></li>
                                                    <li><a href="https://www.pinterest.com/"><i
                                                                class="bx bxl-pinterest"></i></a></li>
                                                    <li><a href="https://www.instagram.com/"><i
                                                                class="bx bxl-instagram"></i></a></li>
                                                </ul>
                                                <div>
                                                    <div class="share-btn"><i class='bx bxs-share-alt'></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="slider-bottom d-flex justify-content-between align-items-center">
                    <a href="{{ $viewUrl }}" class="eg-btn btn--primary btn--md">{{ translate('View ALL') }}</a>
                    <div class="swiper-pagination style-3 d-lg-block d-none"></div>

                    <div class="slider-arrows coming-arrow d-flex gap-3">
                        <div class="coming-prev1 swiper-prev-arrow" tabindex="0" role="button"
                            aria-label="Previous slide"><i class="bi bi-arrow-left"></i></div>
                        <div class="coming-next1 swiper-next-arrow" tabindex="0" role="button"
                            aria-label="Next slide"><i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
            @else
                <h2 class="text-center">{{ translate('No Data Found') }}</h2>
            @endif
        </div>
    </div>
</div>
