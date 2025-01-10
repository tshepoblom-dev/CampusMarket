@extends('frontend.template-'.selectedTheme().'.partials.master')
@section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')
    <div class="dashboard-section pt-120 customer-order-details">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    @include('frontend.template-'.selectedTheme().'.customer.sidenav')
                </div>
                <div class="col-lg-9">
                    <!-- table title-->
                    <div class="table-title-area">
                        @if ($bidSingle->type == 2)
                            <h3>{{ translate('Bidding ID') }} #{{ $bidSingle->order_number }}</h3>
                        @else
                            <h3>{{ translate('Order ID') }} #{{ $bidSingle->order_number }}</h3>
                        @endif
                        <p>{{ dateFormat($bidSingle->created_at) }} @if ($bidSingle->status == 1)
                                <span class="text-blue fs-5 d-inline"> {{ translate('Processing') }}</span>
                            @elseif($bidSingle->win_status == 1)
                                <span class="text-green fs-5 d-inline">{{ translate('Win') }}</span>
                            @elseif($bidSingle->status == 3)
                                <span class="text-red fs-5 d-inline">{{ translate('Cancelled') }}</span>
                            @elseif($bidSingle->status == 4)
                                <span class="text-green fs-5 d-inline">{{ translate('Completed') }}</span>
                            @elseif($bidSingle->status == 5)
                                <span class="text-warning fs-5 d-inline">{{ translate('On Hold') }}</span>
                            @elseif($bidSingle->status == 6)
                                <span class="text-green fs-5 d-inline">{{ translate('Delivered') }}</span>
                            @elseif($bidSingle->status == 7)
                                <span class="text-red fs-5 d-inline">{{ translate('Refunded') }}</span>
                            @elseif($bidSingle->status == 8)
                                <span class="text-red fs-5 d-inline">{{ translate('Shipped') }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="ps-title">{{ translate('Order Summary') }}</h5>
                            <div class="table-wrapper">
                                <table class="eg-table order-table table mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ translate('Image') }}</th>
                                            <th>{{ translate('Name') }}</th>
                                            <th>{{ translate('Quantity') }}</th>
                                            @if ($bidSingle->type == 2)
                                                <th>{{ translate('Bid Amount') }}</th>
                                                <th>{{ translate('Payment') }}</th>
                                            @else
                                                <th>{{ translate('Price') }}</th>
                                            @endif
                                            <th>{{ translate('Tax') . '(' . get_setting('tax_rate') . '%)' }}</th>
                                            <th>{{ translate('Total') }}</th>
                                            @if ($bidSingle->payment_status != 3 && $bidSingle->status !==7)
                                                <th>{{ translate('Action') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($bidSingle->wallets->count() > 0)
                                            @foreach ($bidSingle->wallets as $bid_payment)
                                                <tr>
                                                    <td>
                                                        @if ($bidSingle->products->features_image)
                                                            <img alt="image"
                                                                src="{{ asset('uploads/products/features/' . $bidSingle->products->features_image) }}"
                                                                class="work-img img-fluid">
                                                        @else
                                                            <img alt="image"
                                                                src="{{ asset('uploads/placeholder.jpg') }}"
                                                                class="work-img img-fluid">
                                                        @endif
                                                    </td>
                                                    <td><a target="__blank"
                                                            href="{{ url('product/' . $bidSingle->products->slug) }}">{{ $bidSingle->products->getTranslation('name', $lang) }}</a>
                                                    </td>
                                                    <td>{{ $bidSingle->quantity }}</td>
                                                    @if ($bidSingle->type == 2)
                                                        <td>{{ currency_symbol() . number_format($bidSingle->bid_amount, 2) }}
                                                        </td>
                                                        <td>{{ currency_symbol() . number_format($bid_payment->amount, 2) }}
                                                        </td>
                                                    @else
                                                        <td>{{ currency_symbol() . number_format($bid_payment->amount, 2) }}
                                                        </td>
                                                    @endif
                                                    <td>{{ currency_symbol() . number_format($bid_payment->tax_amount, 2) }}
                                                    </td>
                                                    <td>{{ currency_symbol() . number_format($bid_payment->amount + $bid_payment->tax_amount, 2) }}
                                                    </td>
                                                    @if ($bidSingle->payment_status != 3  &&  $bidSingle->status !==7)
                                                        <td>
                                                            <button type="button" class="eg-btn btn--primary btn--sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#finalPaymentModal">{{ translate('Pay Now') }}</button>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>


                                    @if ($bidSingle->type == 2)
                                        <tfoot>
                                            <tr>
                                                <td @if ($bidSingle->type == 2) colspan="4" @else colspan="3" @endif>
                                                </td>
                                                <td>{{ currency_symbol() . number_format($bidSingle->wallets->sum('amount'), 2) }}
                                                </td>
                                                <td>{{ currency_symbol() . number_format($bidSingle->wallets->sum('tax_amount'), 2) }}
                                                </td>
                                                <td>{{ currency_symbol() . number_format($bidSingle->wallets->sum('total_amount'), 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="@if ($bidSingle->shipping_first_name) col-md-6 @else col-md-12 @endif">
                            <div class="billing-and-shipping-address">
                                <h4>{{ translate('Billing Details') }}</h4>
                                <p><strong>{{ translate('Full Name') }}</strong>: {{ $bidSingle->billing_first_name }}
                                    {{ $bidSingle->billing_last_name }}</p>
                                <p><strong>{{ translate('Address') }}</strong>: {{ $bidSingle->billing_address }}</p>
                                <p><strong>{{ translate('City') }}</strong>: {{ $bidSingle->billing_cities->name ?? '' }}
                                </p>
                                <p><strong>{{ translate('State') }}</strong>: {{ $bidSingle->billing_states->name ?? '' }}
                                </p>
                                <p><strong>{{ translate('Country') }}</strong>:
                                    {{ $bidSingle->billing_countries->name ?? '' }}</p>
                                <p><strong>{{ translate('Post Code') }}</strong>: {{ $bidSingle->billing_post_code }}</p>
                                <p><strong>{{ translate('Phone') }}</strong>: {{ $bidSingle->billing_phone }}</p>
                                <p><strong>{{ translate('Email') }}</strong>: {{ $bidSingle->billing_email }}</p>
                            </div>
                        </div>
                        @if ($bidSingle->shipping_first_name)
                            <div class="col-md-6">
                                <div class="billing-and-shipping-address">
                                    <h4>{{ translate('Shipping Details') }}</h4>
                                    <p><strong>{{ translate('Full Name') }}</strong>:
                                        {{ $bidSingle->shipping_first_name }} {{ $bidSingle->shipping_first_name }}</p>
                                    <p><strong>{{ translate('Address') }}</strong>: {{ $bidSingle->shipping_address }}</p>
                                    <p><strong>{{ translate('City') }}</strong>:
                                        {{ $bidSingle->shipping_cities->name ?? '' }}</p>
                                    <p><strong>{{ translate('State') }}</strong>:
                                        {{ $bidSingle->shipping_states->name ?? '' }}</p>
                                    <p><strong>{{ translate('Country') }}</strong>:
                                        {{ $bidSingle->shipping_countries->name ?? '' }}</p>
                                    <p><strong>{{ translate('Post Code') }}</strong>: {{ $bidSingle->shipping_post_code }}
                                    </p>
                                    <p><strong>{{ translate('Phone') }}</strong>: {{ $bidSingle->shipping_phone }}</p>
                                    <p><strong>{{ translate('Email') }}</strong>: {{ $bidSingle->shipping_email }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($bidSingle->type == 2 && $bidSingle->status == 4 && $review_confirm == 0)
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="review-form">
                                    <div class="number-of-review">
                                        <h4>{{ translate('Write A Review') }}</h4>
                                    </div>
                                    <form action="{{ route('review.submit', $bidSingle->products->id) }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-inner2 mb-40">
                                                    <h6>{{ translate('Be the first to review') }}
                                                        “{{ $bidSingle->products->name }}”</h6>
                                                    <p>{{ translate('Your email address will not be published') }}.</p>
                                                    <div class="review-rate-area">
                                                        <p>{{ translate('Your Rating') }}</p>
                                                        <div class="rate">
                                                            <input type="radio" id="star5" name="rate"
                                                                value="5">
                                                            <label for="star5" title="text">5
                                                                {{ translate('stars') }}</label>
                                                            <input type="radio" id="star4" name="rate"
                                                                value="4">
                                                            <label for="star4" title="text">4
                                                                {{ translate('stars') }}</label>
                                                            <input type="radio" id="star3" name="rate"
                                                                value="3">
                                                            <label for="star3" title="text">3
                                                                {{ translate('stars') }}</label>
                                                            <input type="radio" id="star2" name="rate"
                                                                value="2">
                                                            <label for="star2" title="text">2
                                                                {{ translate('stars') }}</label>
                                                            <input type="radio" id="star1" name="rate"
                                                                value="1">
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
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div class="balance-content order-details">
        @include('frontend.template-'.selectedTheme().'.partials.final_payment_modal')
    </div>
@endsection
