@if ($products->isEmpty())
    <h1 class="text-center">
        {{ translate('No Data Found') }}</h1>
@else
    <input type="hidden" id="live_limit" value="{{ $products->count() }}">
    @foreach ($products as $key => $productItem)
        <div class="col-lg-4 col-md-6">
            <div class="eg-card auction-card1 style-2">
                <div class="auction-img">
                    @if ($productItem->sale_type == 1)
                        <span class="product-type">{{ translate('Auction') }}</span>

                    @else
                        <span class="product-type bg-red">{{ translate('General') }}</span>
                    @endif
                   @if ( currentDate() < $productItem->start_date )
                   <span class="product-type comming-soon"> {{translate('Comning Soon')}} </span>
                   @endif

                    @if ($productItem->features_image)
                        <img alt="Acution image"
                            src="{{ asset('uploads/products/features/' . $productItem->features_image) }}">
                    @else
                        <img alt="Acution image" src="{{ asset('uploads/placeholder.jpg') }}">
                    @endif
                    @if ($productItem->sale_type == 1)
                     @php
                          $auctionDate= currentDate() < $productItem->start_date ? $productItem->start_date : $productItem->end_date
                     @endphp

                        <div class="auction-timer">
                            <div class="countdown" id="timer{{ $key }}"
                                data-live-end-date="{{ date('F d, Y H:i:s', strtotime($auctionDate)) }}">
                                <h4><span id="days{{ $key }}"></span>D : <span
                                        id="hours{{ $key }}"></span>H : <span
                                        id="minutes{{ $key }}"></span>M : <span
                                        id="seconds{{ $key }}"></span>S</h4>
                            </div>
                        </div>
                    @endif
                    <div class="author-area">
                        <div class="author-emo">
                            @if (fileExists('uploads/shop/', $productItem?->users?->shop?->logo) != false && $productItem?->users?->shop?->logo != null)
                                <img src="{{ asset('uploads/shop/' .  $productItem?->users?->shop?->logo) }}" alt="Shop Logo">
                            @else
                                <img src="{{ asset('uploads/placeholder.jpg') }}" alt="Shop Logo">
                            @endif

                        </div>
                        <div class="author-name">
                            <span><a href="{{ route('shop.details', $productItem->users->shop->slug) }}"> {{translate('by')}}
                                    {{ '@' . $productItem->users?->shop?->name }}</a></span>
                        </div>
                    </div>
                </div>
                <div class="auction-content">
                    <h4><a
                            href="{{ route('auction.details', $productItem->slug) }}">{{ $productItem->getTranslation('name', $lang) }}</a>
                    </h4>
                    @if ($productItem->sale_type == 1)
                        @php
                            $latest_bid = latestBidPrice($productItem->id);

                        @endphp

                        @if (isset($latest_bid->bid_amount))
                            <p>{{ translate('Current bid') }}:
                                <span>{{ currency_symbol() }}{{ $latest_bid->bid_amount ?? $productItem->min_bid_price }}</span>
                            </p>
                        @else
                            <p>{{ translate('Bidding Price') }}:
                                <span>{{ currency_symbol() }}{{ $latest_bid->bid_amount ?? $productItem->min_bid_price }}</span>
                            </p>
                        @endif
                    @else
                        <div class="price">{{ translate('Price') }} : @if ($productItem->sale_price)
                                <del>{{ currency_symbol() . $productItem->price }}</del>
                            <span>{{ currency_symbol() . $productItem->sale_price }}</span>@else<span>{{ currency_symbol() . $productItem->price }}</span>
                            @endif
                        </div>
                    @endif
                    <div class="auction-card-bttm">
                        @if ($productItem->sale_type == 1)
                            <a href="{{ route('auction.details', $productItem->slug) }}"
                                class="eg-btn btn--primary btn--sm">{{ translate('Place a Bid') }}</a>
                        @else
                            <a href="{{ route('auction.details', $productItem->slug) }}"
                                class="eg-btn btn--primary2 btn--sm">{{ translate('Buy Now') }}</a>
                        @endif
                        <div class="share-area">
                            <ul class="social-icons d-flex">
                                <li><a target="_blank"
                                        href="https://www.facebook.com/sharer.php?u={{ url('product/' . $productItem->slug) }}"><i
                                            class="bx bxl-facebook"></i></a></li>
                                <li><a target="_blank"
                                        href="https://twitter.com/intent/tweet?url={{ url('product/' . $productItem->slug) }}&text={{ $productItem->name }}"><i
                                            class="bx bxl-twitter"></i></a></li>
                                <li><a target="_blank"
                                        href="https://www.linkedin.com/shareArticle?url={{ url('product/' . $productItem->slug) }}&title={{ $productItem->name }}"><i
                                            class="bx bxl-linkedin"></i></a></li>
                                <li><a target="_blank"
                                        href="https://www.pinterest.com/pin/create/bookmarklet/?url=={{ url('product/' . $productItem->slug) }}"><i
                                            class="bx bxl-pinterest"></i></a></li>
                            </ul>
                            <div>
                                <a href="#" class="share-btn"><i class='bx bxs-share-alt'></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
    <div class="row">
        {!!  prelaceScript($products->links('vendor.pagination.custom')) !!}
    </div>
@endif
