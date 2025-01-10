@extends('frontend.template-'.selectedTheme().'.partials.master')
@section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')
    <div class="checkout-section pt-120 pb-120">
        <div class="container">
            <form action="{{ route('customer.payment.method') }}" method="POST" class="require-validation"
                data-cc-on-file="false" data-stripe-publishable-key="{{ get_payment_method('stripe_key') }}" id="payment-form">
                @csrf
                @if ($singleProduct->sale_type == 1)
                    <input type="hidden" name="type" value="2">
                @else
                    <input type="hidden" name="type" value="3">
                @endif

                <div id="razorScript">

                </div>

                <input type="hidden" name="product_id" value="{{ $singleProduct->id }}">
                <input type="hidden" name="current_url" value="{{ URL::full() }}">

                <div class="row gy-5">
                    <div class="col-lg-7">
                        <div class="form-wrap mb-30">
                            <h4>{{ translate('Billing Details') }}</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{ translate('First Name') }}</label>
                                        <input type="text" class="@error('billing_first_name') is-invalid @enderror"
                                            name="billing_first_name"
                                            value="{{ old('billing_first_name', $loginUser->fname) }}"
                                            placeholder="{{ translate('Your first name') }}">
                                        @error('billing_first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{ translate('Last Name') }}</label>
                                        <input type="text" class="@error('billing_last_name') is-invalid @enderror"
                                            name="billing_last_name"
                                            value="{{ old('billing_last_name', $loginUser->lname) }}"
                                            placeholder="{{ translate('Your last name') }}">
                                        @error('billing_last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Street Address') }}</label>
                                        <input type="text" class="@error('billing_address') is-invalid @enderror"
                                            name="billing_address"
                                            value="{{ old('billing_address', $loginUser->address) }}"
                                            placeholder="{{ translate('House and street name') }}">
                                        @error('billing_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <select class="country_id @error('billing_country_id') is-invalid @enderror"
                                            name="billing_country_id" id="billing_country_id">
                                            <option value="">{{ translate('Country') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('billing_country_id', $loginUser->country_id) == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('billing_country_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <select class="state_id @error('billing_state_id') is-invalid @enderror"
                                            name="billing_state_id" id="billing_state_id">
                                            <option value="">{{ translate('Region / State') }}</option>

                                            @if ($loginUser->state_id)
                                                <option value="{{ $loginUser->state_id }}" selected>
                                                    {{ $loginUser->states->name }}</option>
                                            @endif
                                        </select>
                                        @error('billing_state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <select class="city_id @error('billing_city_id') is-invalid @enderror"
                                            name="billing_city_id" id="billing_city_id">
                                            <option value="">{{ translate('Town / City') }}</option>
                                            @if ($loginUser->city_id)
                                                <option value="{{ $loginUser->city_id }}" selected>
                                                    {{ $loginUser->cities->name }}</option>
                                            @endif
                                        </select>
                                        @error('billing_city_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <input type="text" class="@error('billing_post_code') is-invalid @enderror"
                                            name="billing_post_code"
                                            value="{{ old('billing_post_code', $loginUser->zip_code) }}"
                                            placeholder="Post Code">
                                        @error('billing_post_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Additional Information') }}</label>
                                        <input type="text" class="@error('billing_phone') is-invalid @enderror"
                                            name="billing_phone" value="{{ old('billing_phone', $loginUser->phone) }}"
                                            placeholder="{{ translate('Your Phone Number') }}">
                                        @error('billing_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <input type="email" class="@error('billing_email') is-invalid @enderror"
                                            name="billing_email" value="{{ old('billing_email', $loginUser->email) }}"
                                            placeholder="{{ translate('Your Email Address') }}">
                                        @error('billing_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1"
                                            id="shippingCheckbox">
                                        <label class="form-check-label" for="shippingCheckbox">
                                            {{ translate('Are You Ship to a Different Address') }}?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="shippingBox" class="form-wrap box--shadow d-none">
                            <h4>{{ translate('Are You Ship to a Different Address') }}?</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{ translate('First Name') }}</label>
                                        <input type="text" class="@error('shipping_first_name') is-invalid @enderror"
                                            name="shipping_first_name" value="{{ old('shipping_first_name') }}"
                                            placeholder="{{ translate('Your first name') }}">
                                        @error('shipping_first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{ translate('Last Name') }}</label>
                                        <input type="text" class="@error('shipping_last_name') is-invalid @enderror"
                                            name="shipping_last_name" value="{{ old('shipping_last_name') }}"
                                            placeholder="{{ translate('Your last name') }}">
                                        @error('shipping_last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Street Address') }}</label>
                                        <input type="text" class="@error('shipping_address') is-invalid @enderror"
                                            name="shipping_address" value="{{ old('shipping_address') }}"
                                            placeholder="{{ translate('House and street name') }}">
                                        @error('shipping_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <select
                                            class="shipping_country_id @error('shipping_country_id') is-invalid @enderror"
                                            name="shipping_country_id" id="shipping_country_id">
                                            <option value="">{{ translate('Country') }}</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('shipping_country_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <select class="shipping_state_id @error('shipping_state_id') is-invalid @enderror"
                                            name="shipping_state_id" id="shipping_state_id">
                                            <option value="">{{ translate('Region / State') }}</option>
                                        </select>
                                        @error('shipping_state_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <select class="shipping_city_id @error('shipping_city_id') is-invalid @enderror"
                                            name="shipping_city_id" id="shipping_city_id">
                                            <option value="">{{ translate('Town / City') }}</option>
                                        </select>
                                        @error('shipping_city_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-inner">
                                        <input type="text" class="@error('shipping_post_code') is-invalid @enderror"
                                            name="shipping_post_code" value="{{ old('shipping_post_code') }}"
                                            placeholder="Post Code">
                                        @error('shipping_post_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label>{{ translate('Additional Information') }}</label>
                                        <input type="text" class="@error('shipping_phone') is-invalid @enderror"
                                            name="shipping_phone" value="{{ old('shipping_phone') }}"
                                            placeholder="{{ translate('Your Phone Number') }}">
                                        @error('shipping_phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-inner">
                                        <input type="email" class="@error('shipping_email') is-invalid @enderror"
                                            name="shipping_email" value="{{ old('shipping_email') }}"
                                            placeholder="{{ translate('Your Email Address') }}">
                                        @error('shipping_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-wrap box--shadow">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <textarea name="message" placeholder="Order Notes (Optional)" rows="6">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="added-product-summary mb-30">
                            <h5>{{ translate('Order Summary') }}</h5>
                            <ul class="added-products">
                                <li class="single-product">
                                    <div class="product-area">
                                        <div class="product-img">
                                            <img src="{{ asset('uploads/products/features/' . $singleProduct->features_image) }}"
                                                alt="{{ $singleProduct->name }}">
                                        </div>
                                        <div class="product-info">
                                            <h5><a href="#">{{ $singleProduct->name }}</a></h5>
                                            <div class="product-total">
                                                @if ($singleProduct->sale_type == 1)
                                                    <strong>
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $singleProduct->quantity }}">
                                                        <span
                                                            class="product-quantity">{{ translate('Quantity') . ': ' . $singleProduct->quantity }}</span>
                                                    </strong>
                                                    <strong>
                                                        <input type="hidden" name="bid_price"
                                                            value="{{ $price }}">
                                                        <span
                                                            class="product-price">{{ translate('Bid Price') . ': ' . currency_symbol() . $price }}</span>
                                                    </strong>
                                                @else
                                                    <strong>
                                                        <input type="hidden" name="quantity"
                                                            value="{{ $quantity }}">
                                                        <span
                                                            class="product-quantity">{{ translate('Quantity') . ': ' . $quantity }}</span>
                                                    </strong>
                                                    <strong>
                                                        <input type="hidden" name="bid_price"
                                                            value="{{ $price }}">
                                                        <span
                                                            class="product-price">{{ translate('Price') . ': ' . currency_symbol() . $price }}</span>
                                                    </strong>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="cost-summary mb-30">
                            <table class="table cost-summary-table">
                                <thead>
                                    <tr>
                                        <th>
                                            @if ($singleProduct->sale_type == 1)
                                                {{ translate('Minimum Deposit') }}@else{{ translate('Total') }}
                                            @endif
                                        </th>
                                        @php
                                            if ($singleProduct->sale_type == 1) {
                                                if ($singleProduct->min_deposit_type == 1) {
                                                    $main_amount = ($price / 100) * $singleProduct->min_deposit;
                                                } else {
                                                    $main_amount = $singleProduct->min_deposit;
                                                }
                                            } else {
                                                $main_amount = $price;
                                            }

                                            $tax_amount = ($main_amount / 100) * get_setting('tax_rate');
                                            $total_amount = $main_amount + $tax_amount;
                                        @endphp
                                        <th>{{ currency_symbol() . number_format($main_amount, 2) }} <input type="hidden"
                                                name="amount" value="{{ $main_amount }}"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tax">{{ translate('Tax') }} ({{ get_setting('tax_rate') . '%' }})
                                        </td>
                                        <td>{{ currency_symbol() . number_format($tax_amount, 2) }}<input type="hidden"
                                                name="tax_amount" value="{{ $tax_amount }}"></td>
                                    </tr>
                                    <tr>
                                        <td>Total ( tax incl.)</td>
                                        <td>{{ currency_symbol() . number_format($total_amount, 2) }}<input type="hidden"
                                                name="total_amount" value="{{ $total_amount }}"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="payment-form balance-content p-0">
                            <div class="payment-methods mb-30">
                                <ul class="payment-list">
                                    @if ($payment_methods->count() > 0)
                                        @foreach ($payment_methods as $payment_method)
                                            @if ($payment_method->id == 1)
                                                <li class="{{ $payment_method->method_name }}-payment">
                                                    <input type="radio" id="wallet" name="payment_method"
                                                        value="{{ $payment_method->method_name }}" checked>
                                                    <label for="wallet">
                                                        <h6>{{ translate('Wallet') }}
                                                            @if ($payment_method->logo)
                                                                <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                                    alt="Wallet" height="20">
                                                            @else
                                                                <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                                    alt="Wallet" height="20">
                                                            @endif
                                                            <span
                                                                class="wallet-balance">({{ currency_symbol() . wallet_balance(Auth::user()->id) }})</span>
                                                        </h6>
                                                    </label>
                                                    <p class="para">
                                                        {{ translate('If there is insufficient balance please') }} <button
                                                            type="button" class="modal-btn btn" data-bs-toggle="modal"
                                                            data-bs-target="#paymentModal">{{ translate('Add Balance') }}+</button>
                                                    </p>
                                                </li>
                                            @else
                                                <li class="{{ $payment_method->method_name }} mb-3">
                                                    <input type="radio" id="{{ $payment_method->method_name }}"
                                                        name="payment_method"
                                                        value="{{ $payment_method->method_name }}">
                                                    <label for="{{ $payment_method->method_name }}">
                                                        @if ($payment_method->logo)
                                                            <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                                alt="{{ $payment_method->method_name }}" height="25">
                                                        @else
                                                            <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                                alt="{{ $payment_method->method_name }}" height="25">
                                                        @endif
                                                    </label>
                                                </li>
                                            @endif
                                        @endforeach
                                    @else
                                        <li>
                                            <h3>{{ translate('No Payment Method Found') }}</h3>
                                        </li>
                                    @endif
                                </ul>
<!--
                                <div class="choose-payment-method pt-25 pb-25 d-none" id="strip-payment">
                                    <h5>{{ translate('Select Your Payment Method') }}</h5>
                                    <div class="row gy-4 g-4">
                                        <div class="col-md-12">
                                            <div class="input-area">
                                                <label>{{ translate('Card Number') }}</label>
                                                <div class="input-field">
                                                    <input type="number" class="stripe_card_number"
                                                        placeholder="1234 1234 1234 1234" maxlength="16">
                                                    <img src="{{ asset('frontend/images/bg/payment.png') }}"
                                                        alt="Stripe">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-area">
                                                <label>{{ translate('Expiry') }}</label>
                                                <input type="text" class="stripe_card_expiry" id="stripe_card_expiry"
                                                    placeholder="MM/YY">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-area">
                                                <label>{{ translate('CVC') }}</label>
                                                <input type="text" class="stripe_cvc" placeholder="123">
                                            </div>
                                        </div>



                                    </div>
                                    <div class='form-row row pt-3'>
                                        <div class='col-md-12 error form-group d-none'>
                                            <div class='alert-danger alert'>
                                                {{ translate('Please correct the errors and try again') }}.
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="payment-form-bottom d-flex align-items-start">
                                    <input type="checkbox" name="terms" id="terms" value="1" required>
                                    <label for="terms">{{ translate('I have read and agree to the website') }} <br> <a
                                            target="__blank"
                                            href="{{ get_setting('term_conditions_link') }}">{{ translate('Terms and conditions') }}</a></label>
                                </div>
                            </div>
                            <div class="place-order-btn">
                                <button type="submit"
                                    class="eg-btn btn--primary header-btn">{{ translate('Place Order') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="balance-content">
        @include('frontend.template-1.partials.payment_modal')
    </div>
    @push('js')
          <script src="{{asset('frontend/js/payment.js')}}"></script>
    @endpush
@endsection
