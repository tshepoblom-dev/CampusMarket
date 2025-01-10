
@extends('frontend.template-'.$templateId.'.partials.master')
@section('content')
    @include('frontend.template-'.$templateId.'.breadcrumb.breadcrumb')

    <div class="auction-details-section pt-120">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row g-lg-4 gy-5 mb-50">
                <div class="col-xl-6 col-lg-7">
                    <div class="swiper thumb-big">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img alt="image"
                                    src="{{ asset('uploads/products/features/' . $auction_details->features_image) }}"
                                    class="img-fluid">
                            </div>
                            @foreach ($img_galleries as $img_gallery)
                                <div class="swiper-slide">
                                    <img alt="image" src="{{ asset('uploads/products/gallery/' . $img_gallery->image) }}"
                                        class="img-fluid">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div thumbsSlider="" class="swiper slider-thumb">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset('uploads/products/features/' . $auction_details->features_image) }}" />
                            </div>
                            @foreach ($img_galleries as $img_gallery)
                                <div class="swiper-slide">
                                    <img src="{{ asset('uploads/products/gallery/' . $img_gallery->image) }}" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-5">
                    <div class="product-details-right  wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                        <h3>{{ $auction_details->getTranslation('name') }}</h3>
                        <p class="para">{{ $auction_details->getTranslation('short_desc') }}</p>
                        @if ($auction_details->sale_type == 1)
                            @php
                                $latest_bid = latestBidPrice($auction_details->id);
                                $auctionDate= currentDate() < $auction_details->start_date ? $auction_details->start_date : $auction_details->end_date
                            @endphp

                            @if (isset($latest_bid->bid_amount))
                                <h4>{{ translate('Current bid') }}:
                                    <span>{{ currency_symbol() }}{{ $latest_bid->bid_amount ?? $auction_details->min_bid_price }}</span>
                                </h4>
                            @else
                                <h4>{{ translate('Bidding Price') }}:
                                    <span>{{ currency_symbol() }}{{ $latest_bid->bid_amount ?? $auction_details->min_bid_price }}</span>
                                </h4>
                            @endif




                            <div class="countdown-timer">
                                <ul data-countdown="{{ date('d M, Y H:i:s', strtotime($auctionDate)) }}">
                                    <li data-days="00">00 </li><b>{{ translate('Days') }}</b>
                                    <li data-hours="00">00</li><b>{{ translate('Hours') }}</b>
                                    <li data-minutes="00">00</li><b>{{ translate('Mins') }}</b>
                                    <li data-seconds="00">00</li><b>{{ translate('Secs') }}</b>
                                </ul>
                            </div>

                            <div class="bid-form">
                                <div class="form-title">
                                    @if ($auction_details->start_date < now())
                                        <h5>{{ translate('Bid Now') }}</h5>
                                    @else
                                        <h5>{{ translate('Bid is coming soon') }}</h5>
                                    @endif
                                    <p>{{ translate('Bid Amount') }} : {{ translate('Minimum Bid') }}
                                        {{ currency_symbol() . ($latest_bid->bid_amount ?? $auction_details->min_bid_price) + 1 }}
                                    </p>
                                </div>
                                @if ($auction_details->start_date < now())
                                    <form action="{{ route('live.auction.checkout.check') }}" method="POST">
                                        @csrf
                                        <div class="form-inner gap-2">
                                            <input type="hidden" name="quantity" value="{{ $auction_details->quantity }}">
                                            <input type="hidden" name="product_id" value="{{ $auction_details->id }}">
                                            <input type="number" step="any"
                                                min="{{ ($latest_bid->bid_amount ?? $auction_details->min_bid_price) + 1 }}"
                                                name="price"
                                                placeholder="{{ ($latest_bid->bid_amount ?? $auction_details->min_bid_price) + 1 }}"
                                                required>
                                            <button class="eg-btn btn--primary btn--sm"
                                                type="submit">{{ translate('Place Bid') }}</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @else
                            <div class="purchase-form">
                                <form action="{{ route('live.auction.checkout.check') }}" method="POST">
                                    @csrf
                                    <div class="price-area">
                                        <h4>{{ translate('Price') }}: @if ($auction_details->sale_price)
                                                <del class="opacity-50 me-3">{{ currency_symbol() }}<span
                                                        class="rprice">{{ $auction_details->price }}</span></del>
                                            @endif
                                            <span>{{ currency_symbol() }}<span
                                                    class="sprice">{{ $auction_details->sale_price ?? $auction_details->price }}</span></span>
                                        </h4>
                                        <input type="hidden" class="mainPrice" name="price"
                                            value="{{ $auction_details->sale_price ?? $auction_details->price }}">
                                        <input type="hidden" name="product_id" value="{{ $auction_details->id }}">
                                        <input type="hidden" class="psale_price"
                                            value="{{ $auction_details->sale_price }}">
                                        <input type="hidden" class="pregular_price" value="{{ $auction_details->price }}">
                                    </div>
                                    <div class="qty-and-buy-btn d-flex flex-wrap align-items-end gap-4 ">
                                        <div class="quantity-area">
                                            <h6>{{ translate('Quantity') }}</h6>
                                            <div class="quantity-counter">
                                                <a href="#" class="quantity__minus"><i class="bx bx-minus"></i></a>
                                                <input name="quantity" type="text" class="quantity__input"
                                                    value="01">
                                                <a href="#" class="quantity__plus"><i class="bx bx-plus"></i></a>
                                            </div>
                                        </div>
                                        <div class="shop-details-btn">
                                            @if ($auction_details->start_date < now())
                                                <button class="eg-btn btn--primary btn-lg border-0"
                                                    type="submit">{{ translate('Buy Now') }}</button>
                                            @else
                                                <h5>{{ translate('Coming Soon') }}</h5>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <div class="product-info">
                            <ul class="product-info-list">
                                @if ($auction_details->sku)
                                    <li> <span>{{ translate('SKU') }}:</span> {{ $auction_details->sku }}</li>
                                @endif
                                @if ($auction_details->category_id)
                                    <li> <span>{{ translate('Category') }}:</span> <a
                                            href="{{ url('category/' . $auction_details->categories->slug) }}">{{ $auction_details?->categories?->getTranslation('name') }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center g-4 mb-3">
                <div class="col-lg-8">
                    <ul class="nav nav-pills d-flex flex-row justify-content-start gap-sm-2 gap-3 mb-45 wow fadeInDown"
                        data-wow-duration="1.5s" data-wow-delay=".2s" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active details-tab-btn" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">{{ translate('Description') }}</button>
                        </li>

                        @if ($specifications->count() > 0)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link details-tab-btn" id="pills-specification-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-specification" type="button"
                                    role="tab" aria-controls="pills-specification"
                                    aria-selected="false">{{ translate('Specifications') }}</button>
                            </li>
                        @endif


                        @if ($auction_details->sale_type == 1)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link details-tab-btn" id="pills-bid-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-bid" type="button" role="tab" aria-controls="pills-bid"
                                    aria-selected="false">{{ translate('Biding History') }}</button>
                            </li>
                        @endif
                        @if ($auction_details->sale_type == 1)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link details-tab-btn" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact"
                                    aria-selected="false">{{ translate('Other Auction') }}</button>
                            </li>
                        @endif
                        @if ($auction_details->sale_type == 2)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link details-tab-btn" id="pills-review-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-review" type="button" role="tab"
                                    aria-controls="pills-review" aria-selected="false"> {{ translate('Reviews') }}
                                    ({{ $product_reviews->count() }})</button>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s"
                            id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="describe-content">

                            @php
                                $description= prelaceScript(html_entity_decode($auction_details->getTranslation('long_desc')))
                            @endphp
                            {!! clean($description) !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-specification" role="tabpanel"
                            aria-labelledby="pills-specification-tab">
                            <div class="bid-list-area">
                                <table class="table table-bordered table-striped mt-3" style="width:100%;">
                                    <tbody>
                                        @foreach ($specifications as $specification)
                                            <tr>
                                                <td>{{ $specification->getTranslation('label') }}</td>
                                                <td>{{ $specification->getTranslation('value') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if ($auction_details->sale_type == 1)
                            <div class="tab-pane fade" id="pills-bid" role="tabpanel" aria-labelledby="pills-bid-tab">
                                <div class="bid-list-area">
                                    <ul class="bid-list">
                                        @if ($bidHistories->count() > 0)
                                            @foreach ($bidHistories as $bidhistory)
                                                <li>
                                                    <div class="row d-flex align-items-center">
                                                        <div class="col-7">
                                                            <div class="bidder-area">
                                                                <div class="bidder-img">
                                                                    @if (fileExists('uploads/users/', $bidhistory->users?->image) != false && $bidhistory->users?->image != null)
                                                                        <img src="{{ asset('uploads/users/' .  $bidhistory->users?->image) }}">
                                                                    @else
                                                                        <img src="{{ asset('uploads/users/user.png') }}">
                                                                    @endif
                                                                </div>
                                                                <div class="bidder-content">
                                                                    <a href="#">
                                                                        <h6>
                                                                            @if ($bidhistory->users?->fname && $bidhistory->users?->lname)
                                                                                {{ $bidhistory->users?->fname . ' ' . $bidhistory->users?->lname }}@else{{ $bidhistory->users->username ?? '' }}
                                                                            @endif
                                                                        </h6>
                                                                    </a>
                                                                    <p>{{ currency_symbol(). number_format($bidhistory->bid_amount, 2) }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-5 text-end">
                                                            <div class="bid-time">
                                                                <p>{{ $bidhistory->created_at }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @else
                                            <h2 class="text-center">{{ translate('No Data Found') }}</h2>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="row d-flex justify-content-center g-4">
                                <input type="hidden" id="live_limit" value="{{ $live_auctions->count() }}">
                                @foreach ($live_auctions as $key => $productItem)
                                    <div class="col-lg-6 col-md-6 col-sm-10 ">
                                        @include('frontend.template-1.partials.live_auction')
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                            <div class="reviews-area">

                                <div class="row gy-5">
                                    <div class="col-lg-12">
                                        <div class="number-of-review">
                                            <h4>{{ translate('Review') }} ({{ $product_reviews->count() }}) :</h4>
                                        </div>
                                        <div class="review-list-area">
                                            <ul class="comment">
                                                @if ($product_reviews->count() > 0)
                                                    @foreach ($product_reviews as $product_review)
                                                        <li>
                                                            <div class="single-comment-area">
                                                                <div class="author-img">
                                                                    @if ($product_review->users->image)
                                                                        <img src="{{ asset('uploads/users/' . $product_review->users->image) }}"
                                                                            alt="{{ $product_review->users->custom_id }}">
                                                                    @else
                                                                        <img src="{{ asset('uploads/users/user.png') }}"
                                                                            alt="{{ $product_review->users->custom_id }}">
                                                                    @endif
                                                                </div>
                                                                <div class="comment-content">
                                                                    <div class="author-and-review">
                                                                        <div class="author-name-deg">
                                                                            <h6>{{ $product_review->users->fname ? $product_review->users->fname . ' ' . $product_review->users->lname : $product_review->users->username }},
                                                                            </h6>
                                                                            <span>{{ $product_review->created_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        <ul
                                                                            class="review d-flex flex-row align-items-center">
                                                                            @switch($product_review->rate)
                                                                                @case(1)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                @break

                                                                                @case(1.5)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-half"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                @break

                                                                                @case(2)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                @break

                                                                                @case(2.5)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-half"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                @break

                                                                                @case(3)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                @break

                                                                                @case(3.5)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-half"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                @break

                                                                                @case(4)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star"></i></li>
                                                                                @break

                                                                                @case(4.5)
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-half"></i></li>
                                                                                @break

                                                                                @default
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                                    <li><i class="bi bi-star-fill"></i></li>
                                                                            @endswitch
                                                                        </ul>
                                                                    </div>
                                                                    <p>{{ $product_review->comments }}</p>

                                                                </div>
                                                            </div>
                                                            @if ($product_review->replies->count() > 0)
                                                                <ul class="comment-replay">
                                                                    @foreach ($product_review->replies as $reply)
                                                                        <li>
                                                                            <div class="single-comment-area">
                                                                                <div class="author-img">
                                                                                    @if ($reply->users->image)
                                                                                        <img src="{{ asset('uploads/users/' . $reply->users->image) }}"
                                                                                            alt="{{ $reply->users->username }}">
                                                                                    @else
                                                                                        <img src="{{ asset('uploads/users/user.png') }}"
                                                                                            alt="{{ $reply->users->username }}">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="comment-content">
                                                                                    <div class="author-name-deg">
                                                                                        <h6>{{ $reply->users->fname ? $reply->users->fname . ' ' . $reply->users->lname : $reply->users->username }},
                                                                                        </h6>
                                                                                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                                                                                    </div>
                                                                                    <p>{{ $reply->comments }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                @else
                                                    <li>
                                                        <h4 class="text-center">{{ translate('No Review Found') }}</h4>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    @if ($auction_details->sale_type == 2)
                                        @customer
                                            @if ($reviewAllow == 0)
                                                <div class="col-lg-12">
                                                    <div class="review-form">
                                                        <div class="number-of-review">
                                                            <h4>{{ translate('Write A Review') }}</h4>
                                                        </div>
                                                        <form action="{{ route('review.submit', $auction_details->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="form-inner2 mb-40">
                                                                        <h6>{{ translate('Be the first to review') }}
                                                                            “{{ $auction_details->name }}”</h6>
                                                                        <p>{{ translate('Your email address will not be published') }}.
                                                                        </p>
                                                                        <div class="review-rate-area">
                                                                            <p>{{ translate('Your Rating') }}</p>
                                                                            <div class="rate">
                                                                                <input type="radio" id="star5"
                                                                                    name="rate" value="5">
                                                                                <label for="star5" title="text">5
                                                                                    {{ translate('stars') }}</label>
                                                                                <input type="radio" id="star4"
                                                                                    name="rate" value="4">
                                                                                <label for="star4" title="text">4
                                                                                    {{ translate('stars') }}</label>
                                                                                <input type="radio" id="star3"
                                                                                    name="rate" value="3">
                                                                                <label for="star3" title="text">3
                                                                                    {{ translate('stars') }}</label>
                                                                                <input type="radio" id="star2"
                                                                                    name="rate" value="2">
                                                                                <label for="star2" title="text">2
                                                                                    {{ translate('stars') }}</label>
                                                                                <input type="radio" id="star1"
                                                                                    name="rate" value="1">
                                                                                <label for="star1" title="text">1
                                                                                    {{ translate('star') }}</label>
                                                                            </div>
                                                                            @error('rate')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-inner mb-10">
                                                                        <textarea name="review" placeholder="{{ translate('Write Your Review') }}" required></textarea>
                                                                        @error('review')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-12">
                                                                    <div class="form-inner two">
                                                                        <button class="eg-btn btn--primary btn-lg"
                                                                            type="submit">{{ translate('Submit') }}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endcustomer
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-sidebar">
                        @if ($auction_details->author_id)
                            <div class="merchant-card">
                                <div class="merchant-image-and-name">
                                    <div class="marchant-img">
                                        @if ($auction_details->users->image)
                                            <img src="{{ asset('uploads/users/' . $auction_details->users->image) }}"
                                                alt="pro-pic">
                                        @else
                                            <img src="{{ asset('uploads/users/user.png') }}" alt="pro-pic">
                                        @endif
                                        <div class="varify-batch">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                                viewBox="0 0 15 14">
                                                <path
                                                    d="M5.21591 14L3.92045 11.8333L1.34659 11.3167L1.63636 8.86667L0 7L1.63636 5.15L1.34659 2.7L3.92045 2.18333L5.21591 0L7.5 1.03333L9.78409 0L11.0966 2.18333L13.6534 2.7L13.3636 5.15L15 7L13.3636 8.86667L13.6534 11.3167L11.0966 11.8333L9.78409 14L7.5 12.9667L5.21591 14ZM5.67614 12.6833L7.5 11.9333L9.375 12.6833L10.517 11.0167L12.5114 10.5167L12.3068 8.53333L13.6875 7L12.3068 5.43333L12.5114 3.45L10.517 2.98333L9.34091 1.31667L7.5 2.06667L5.625 1.31667L4.48295 2.98333L2.48864 3.45L2.69318 5.43333L1.3125 7L2.69318 8.53333L2.48864 10.55L4.48295 11.0167L5.67614 12.6833ZM6.76705 9.21667L10.6364 5.46667L9.86932 4.78333L6.76705 7.78333L5.14773 6.13333L4.36364 6.88333L6.76705 9.21667Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="maechent-name">
                                        <h6>{{ $auction_details->users->fname . ' ' . $auction_details->users->lname ?? $auction_details->users->username }}
                                        </h6>
                                        <a
                                            href="mailto:{{ $auction_details->users->email }}">{{ $auction_details->users->email }}</a>
                                    </div>
                                </div>
                                <ul class="maechent-info">
                                    <li><span
                                            class="title">{{ translate('Member Since') }}:</span>{{ $auction_details->users->created_at->diffForHumans() }}
                                    </li>
                                    @php
                                        $reviews = merchantViewRatings($auction_details->author_id);
                                    @endphp
                                    <li><span class="title">{{ translate('Total Item') }}:</span>
                                        <span>{{ totalMerchantProduct($auction_details->author_id) }} <a
                                                href="{{ route('shop.details', $auction_details->users->shop->slug) }}">{{ translate('View All') }}</a></span>
                                    </li>
                                    <li><span
                                            class="title">{{ translate('Total Sale') }}:</span>{{ totalSaleMerchant($auction_details->author_id) }}
                                    </li>
                                </ul>
                                <div class="rating-wrap text-center">
                                    <h6>{{ translate('Marchant Rating') }}</h6>
                                    <div class="review-and-review-number">
                                        <ul class="maechent-review d-flex flex-row align-items-center mb-25">

                                            @switch($reviews->avg('rate') ?? 0)
                                                @case(1)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                @break

                                                @case(1.5)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-half"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                @break

                                                @case(2)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                @break

                                                @case(2.5)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-half"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                @break

                                                @case(3)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                @break

                                                @case(3.5)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-half"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                @break

                                                @case(4)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                @break

                                                @case(4.5)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-half"></i></li>
                                                @break

                                                @case(5)
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                    <li><i class="bi bi-star-fill"></i></li>
                                                @break

                                                @default
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                                    <li><i class="bi bi-star"></i></li>
                                            @endswitch
                                            <li><a href="#"
                                                    class="review-no">({{ $reviews->avg('rate') ?? 0 }})</a></li>
                                        </ul>
                                        <span>{{ $reviews->count() }} {{ translate('Reviews') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($randomBlog)
                            <div class="sidebar-banner wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="1s"
                                style="background-image: linear-gradient(90deg, rgba(31, 34, 48, 0.75), rgba(31, 34, 48, 0.75)), url(/uploads/blog/{{ $randomBlog->image }});">
                                <div class="banner-content">
                                    <span>{{ $randomBlog->blog_categories->getTranslation('name', $lang) }}</span>
                                    <h3>{{ $randomBlog->getTranslation('title', $lang) }}</h3>
                                    <a href="{{ url('blog/' . $randomBlog->slug) }}"
                                        class="eg-btn btn--primary card--btn">{{ translate('Details') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
