@extends('frontend.template-'.$templateId.'.partials.master')
@section('content')
    @include('frontend.template-'.$templateId.'.breadcrumb.breadcrumb')
    <div class="live-auction-section pt-120">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-12">
                    <div class="store-wrap">
                        <div class="cover-photo">

                            @if (fileExists('uploads/shop/', $shop_details->cover_img) != false && $shop_details->cover_img != null)
                                <img src="{{ asset('uploads/shop/' . $shop_details->cover_img) }}" alt="Shop Logo">
                            @else
                                <img src="{{ asset('uploads/author-cover-placeholder.webp') }}" alt="cover photo">
                            @endif


                        </div>
                        <div class="store-information">
                            <div class="store-logo">
                                @if (fileExists('uploads/shop/', $shop_details->logo) != false && $shop_details->logo != null)
                                    <img src="{{ asset('uploads/shop/' . $shop_details->logo) }}" alt="Shop Logo">
                                @else
                                    <img src="{{ asset('uploads/placeholder.jpg') }}" alt="Shop Logo">
                                @endif
                            </div>
                            <div class="store-content">
                                <div class="content-left">
                                    <h4>{{ $shop_details->name }}</h4>
                                    <div class="location">
                                        <a
                                            href="https://www.google.com/maps/search/{{ $shop_details->address }}/@23.8223868,90.3654215,15z/data=!3m1!4b1?entry=ttu">{{ $shop_details->address }}</a>
                                    </div>
                                    <div class="total-product">
                                        <p><strong>{{ translate('Total Items') }}:</strong> {{ $products->count() }}
                                        </p>
                                    </div>
                                    <div class="total-review">
                                        <ul>
                                            @php

                                                $reviews = merchantViewRatings($shop_details->author_id);
                                            @endphp
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
                                            <li><a href="#" class="review-no">({{ $reviews->avg('rate') ?? 0 }})</a>
                                            </li>
                                        </ul>
                                        <span>{{ $reviews->count() }} {{ translate('Reviews') }}</span>
                                    </div>
                                </div>
                                <ul class="social-icons">
                                    @if ($shop_details->facebook)
                                        <li><a href="{{ $shop_details->facebook }}"><i class="bx bxl-facebook"></i></a>
                                        </li>
                                    @endif
                                    @if ($shop_details->twitter)
                                        <li><a href="{{ $shop_details->twitter }}"><i class="bx bxl-twitter"></i></a></li>
                                    @endif
                                    @if ($shop_details->linkedin)
                                        <li><a href="{{ $shop_details->linkedin }}"><i class="bx bxl-linkedin"></i></a>
                                        </li>
                                    @endif
                                    @if ($shop_details->instagram)
                                        <li><a href="{{ $shop_details->instagram }}"><i class="bx bxl-instagram"></i></a>
                                        </li>
                                    @endif
                                    @if ($shop_details->pinterest)
                                        <li><a href="{{ $shop_details->pinterest }}"><i
                                                    class="bx bxl-pinterest-alt"></i></a></li>
                                    @endif
                                    @if ($shop_details->youtube)
                                        <li><a href="{{ $shop_details->youtube }}"><i class="bx bxl-youtube"></i></a></li>
                                    @endif
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="row g-4 justify-content-center shop-details-page">
                        <div class="col-lg-12">
                            <div class="show-item-and-filte">
                                <input type="hidden" id="product_type">
                                <p>{{ translate('Showing') }} <strong class="show_count">{{ $products->count() }}</strong>
                                    {{ translate('result') }}</p>
                                <div class="filter-area">
                                    <h6>{{ translate('Filter By') }}:</h6>
                                    <div class="form-inner">
                                        <select class="price_order_by">
                                            <option disabled selected>{{ translate('Filter By') }}</option>
                                            <option value="all">{{ translate('All') }}</option>
                                            <option value="1">{{ translate('Auction Products') }}</option>
                                            <option value="2">{{ translate('General Products') }}</option>
                                            <option value="3">{{ translate('Comming Products') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4" id="loadProducts">
                            @include('frontend.template-' . $templateId . '.partials.filter-products', [
                                'products' => $products,
                            ])
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('frontend/js/shop-product.js') }}"></script>
@endpush
