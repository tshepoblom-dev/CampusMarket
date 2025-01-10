<?php
$displyProduct = 9;
$orderBy = 'ASC';

if (isset($singelWidgetData->widget_content)) {
    $widgetContent = $singelWidgetData->getTranslation('widget_content');
    $displyProduct = isset($widgetContent['display_per_page']) ? $widgetContent['display_per_page'] : 9;
    $orderBy = isset($widgetContent['storted_by']) ? $widgetContent['storted_by'] : 'ASC';
    $productType = isset($widgetContent['product_type']) ? $widgetContent['product_type'] : 'all';
    $sidebar_enable = isset($widgetContent['sidebar_enable']) ? $widgetContent['sidebar_enable'] : 'yes';
}

$type = $productType == 'auction' ? 1 : ($productType == 'direct' ? 2 : '');
$products = products(['type' => $type], '', $perpage = $displyProduct, $orderBy);

?>

<div class="live-auction-section pt-120">
    <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
    <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
    <div class="container">
        <div class="row gy-4">

            @if ($sidebar_enable == 'yes')

                <div class="col-xl-3">
                    <div class="product-sidebar">


                        <div class="product-widget-item">
                            <div class="search-area">
                                <div class="sidebar-widget-title">
                                    <h4>{{ translate('Search Product') }}</h4>
                                    <span></span>
                                </div>
                                <div class="product-widget-body">
                                    <div class="form-inner">
                                        <input type="text" class="keyword"
                                            placeholder="{{ translate('Search Here') }}">
                                        <button class="search--btn keyword-search"><i
                                                class='bx bx-search-alt-2'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-widget-item">
                            <div class="search-area">
                                <div class="sidebar-widget-title">
                                    <h4>{{ translate('Price Filter') }}</h4>
                                    <span></span>
                                </div>
                                <div class="product-widget-body">
                                    <div class="range-wrap">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="hidden" id="min_value" class="min_value" name="min_value">
                                                <input type="hidden" id="max_value" class="max_value" name="max_value">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="slider-range"></div>
                                            </div>
                                        </div>
                                        <div class="slider-labels">
                                            <div class="caption">
                                                <span id="slider-range-value1"></span>
                                            </div>
                                            <div class="priceRange">{{ translate('Apply') }}</div>
                                            <div class="caption">
                                                <span id="slider-range-value2"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        @if (categoryProducts()->count() > 0)
                            <div class="product-widget-item">
                                <div class="top-product">
                                    <div class="sidebar-widget-title">
                                        <h4>{{ translate('Product Categories') }}</h4>
                                        <span></span>
                                    </div>
                                    <div class="auction-widget-body">
                                        <ul class="checkbox-container">
                                            @foreach (categoryProducts() as $category)
                                                <li>
                                                    <label class="containerss">
                                                        <input type="checkbox" class="categories filter-option category"
                                                            value="{{ $category->id }}">
                                                        <span class="checkmark"></span>
                                                        <span
                                                            class="text">{{ $category->getTranslation('name') }}</span>
                                                        <span
                                                            class="qty">{{ $category->action_products_count }}</span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="text-center  show-reset mb-40">
                            <a class="eg-btn btn--primary2 btn--sm text-center reset-btns"
                                id="refreshPage">{{ translate('Reset') }}</a>
                        </div>

                        @if (latestBidingProducts(5)->count() > 0)
                            <div class="product-widget-item">
                                <div class="product-category">
                                    <div class="sidebar-widget-title">
                                        <h4>{{ translate('Top Bidding Product') }}</h4>
                                        <span></span>
                                    </div>
                                    <div class="product-widget-body">
                                        <ul class="recent-post">
                                            @foreach (latestBidingProducts(5) as $top_bid)
                                                <li class="single-post">
                                                    <div class="post-img">
                                                        <a href="{{ route('auction.details', $top_bid->slug) }}">
                                                            @if ($top_bid->features_image)
                                                                <img alt="Acution image"
                                                                    src="{{ asset('uploads/products/features/' . $top_bid->features_image) }}">
                                                            @else
                                                                <img alt="Acution image"
                                                                    src="{{ asset('uploads/placeholder.jpg') }}">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="post-content">
                                                        <h6><a
                                                                href="{{ route('auction.details', $top_bid->slug) }}">{{ $top_bid->getTranslation('name', $lang) }}</a>
                                                        </h6>
                                                        <span>{{ translate('Bidding Price') }} :
                                                            {{ currency_symbol() . $top_bid->min_bid_price }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            @endif

            <div class="{{ $sidebar_enable == 'yes' ? 'col-xl-9' : 'col-xl-12' }}">
                <div id="productPage" class="row g-4 justify-content-center product-page">
                    <input type="hidden" value="all-product" id="widget_name">
                    <input type="hidden" value="{{ $displyProduct }}" id="item_show">
                    <div class="col-lg-12">
                        <div class="show-item-and-filte">
                            <p>{{ translate('Showing') }} <strong class="show_count">
                                    {{ $products->count() }}</strong> {{ translate('result') }}</p>
                            @if ($productType == 'all')
                                <div class="filter-area">
                                    <input type="hidden" id="product_type">
                                    <h6>{{ translate('Filter By') }}:</h6>
                                    <div class="form-inner">
                                        <select class="price_order_by">
                                            <option disabled selected>{{ translate('Filter By') }}</option>
                                            <option value="1">{{ translate('Auction Products') }}</option>
                                            <option value="2">{{ translate('General Products') }}</option>
                                            <option value="3">{{ translate('Comming Products') }}</option>
                                        </select>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" id="product_type" value="{{ $type }}">
                            @endif
                        </div>
                    </div>
                    <div class="circle-loader"></div>
                    <div class="row g-4" id="loadProducts">
                        @include('frontend.template-' . $templateId . '.partials.filter-products', [
                            'products' => $products,
                        ])
                    </div>
                    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                </div>

            </div>
        </div>
    </div>
</div>
<input type="hidden" id="highest_price" value="{{ highestPrice() }}">

@push('js')
    <script src="{{ asset('frontend/js/product-filter.js') }}"></script>
@endpush
