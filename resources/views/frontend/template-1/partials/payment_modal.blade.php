<!-- Modal -->
<div class="modal specification-modal fade" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                @if (paymentMethods()->count() > 1)
                    <div class="currency-icon">
                        <span><i class="bi bi-currency-dollar"></i></span>
                    </div>
                    <h4 class="modal-title" id="paymentModalLabel">{{ translate('Add Balance Your Account') }}</h4>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="bi bi-x"></i></button>
            </div>
            @if (paymentMethods()->count() > 1)
                <div class="modal-body">

                    <form action="{{ route('customer.payment.method') }}" method="POST"
                        class="modal-require-validation" data-cc-on-file-modal="false"
                        data-modal-stripe-publishable-key="{{ get_payment_method('stripe_key') }}"
                        id="modal-payment-form">
                        @csrf
                        <input type="hidden" name="current_url" value="{{ URL::full() }}">
                        <div class="choose-amount-area">
                            <h5>{{ translate('Choose the amount') }}</h5>
                            <ul>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount10" name="fixed_price"
                                        value="10" checked>
                                    <label for="amount10">10</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount25" name="fixed_price"
                                        value="25">
                                    <label for="amount25">25</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount50" name="fixed_price"
                                        value="50">
                                    <label for="amount50">50</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount100" name="fixed_price"
                                        value="100">
                                    <label for="amount100">100</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount250" name="fixed_price"
                                        value="250">
                                    <label for="amount250">250</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount500" name="fixed_price"
                                        value="500">
                                    <label for="amount500">500</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount1000" name="fixed_price"
                                        value="1000">
                                    <label for="amount1000">1000</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" data-amount="$2000" id="amount2000"
                                        name="fixed_price" value="2000">
                                    <label for="amount2000">2000</label><br>
                                </li>
                                <li>
                                    <input class="form-check-input" type="radio" id="amount-other" name="fixed_price"
                                        value="other_amount">
                                    <label for="amount-other">{{ translate('Other') }}</label><br>
                                </li>
                            </ul>
                            <div id="OtherPrice" class="payment-option-hide">
                                <div class="input-area">
                                    <input type="number" id="modal_other_amount" name="other_amount"
                                        placeholder="Input Balance" />
                                </div>
                            </div>
                        </div>
                        <div class="choose-payment-mathord">
                            <h5>{{ translate('Select Your Payment Method') }}</h5>
                            <div class="payment-option">
                                <div class="payment-method-section d-flex gap-3 align-items-center flex-wrap">

                                    @foreach (paymentMethods() as $payment_method)
                                        @if ($payment_method->id == 3)
                                            <div class="custom-control custom-radio custom-control-inline stripe">
                                                <input type="radio" id="payment_method_modal1" name="payment_method"
                                                    class="custom-control-input" value="stripe">
                                                <label class="custom-control-label" for="payment_method_modal1">
                                                    @if ($payment_method->logo)
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                            alt="Stripe" height="20">
                                                    @else
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                            alt="Stripe" height="20">
                                                    @endif
                                                    <div class="checked"><i class="bi bi-check"></i></div>
                                                </label>
                                            </div>
                                        @endif
                                        @if ($payment_method->id == 2)
                                            <div
                                                class="custom-control custom-radio custom-control-inline paypal active">
                                                <input type="radio" id="payment_method_modal2"
                                                    name="payment_method" class="custom-control-input" value="paypal"
                                                    checked>
                                                <label class="custom-control-label" for="payment_method_modal2">
                                                    @if ($payment_method->logo)
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                            alt="Paypal" height="20">
                                                    @else
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                            alt="Paypal" height="20">
                                                    @endif
                                                    <div class="checked"><i class="bi bi-check"></i></div>
                                                </label>
                                            </div>
                                        @endif
                                        @if ($payment_method->id == 4)
                                            <div class="custom-control custom-radio custom-control-inline offline">
                                                <input type="radio" id="payment_method_modal3"
                                                    name="payment_method" class="custom-control-input"
                                                    value="razorpay">
                                                <label class="custom-control-label" for="payment_method_modal3">
                                                    @if ($payment_method->logo)
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                            alt="Razorpay" height="20">
                                                    @else
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                            alt="Razorpay" height="20">
                                                    @endif
                                                    <div class="checked"><i class="bi bi-check"></i></div>
                                                </label>
                                            </div>
                                        @endif
                                        @if ($payment_method->id == 5)
                                        <div class="custom-control custom-radio custom-control-inline offline">
                                            <input type="radio" id="payment_method_modal3"
                                                name="payment_method" class="custom-control-input"
                                                value="payfast">
                                            <label class="custom-control-label" for="payment_method_modal3">
                                                @if ($payment_method->logo)
                                                    <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                        alt="Payfast" height="20">
                                                @else
                                                    <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                        alt="Payfast" height="20">
                                                @endif
                                                <div class="checked"><i class="bi bi-check"></i></div>
                                            </label>
                                        </div>
                                    @endif
                                    @endforeach

                                </div>

                            </div>
                            <div class="pt-25 payment-option-hide mt-30" id="StripePayment">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <div class="input-area">
                                            <label>{{ translate('Card Number') }}</label>
                                            <input type="number" class="modal_stripe_card_number"
                                                maxlength="16" placeholder="1234 1234 1234 1234" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-area">
                                            <label>{{ translate('Expiry') }}</label>
                                            <input type="text" class="modal_stripe_card_expiry"
                                                id="modal_stripe_card_expiry" placeholder="MM/YY" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-area">
                                            <label>{{ translate('CVC') }}</label>
                                            <input type="text" class="modal_stripe_cvc"
                                                placeholder="{{ translate('CVC') }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class='form-row row pt-3'>
                                    <div class='col-md-12 modal-error form-group d-none'>
                                        <div class='alert-danger alert'>
                                            {{ translate('Please correct the errors and try again') }}.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" class="modal_amount_main_val" name="amount" value="10">
                        <input type="hidden" class="modal_tax_amount_val" name="tax_amount" value="0">
                        <input type="hidden" class="modal_total_amount_val" name="total_amount" value="10">

                        <div class="pay-btn">
                            <input type="hidden" name="type" value="1">
                            <button class="btn-hover" type="submit">{{ translate('Pay') }}
                                {{ currency_symbol() }}<span class="modal_total_amount">10</span></button>
                        </div>
                    </form>


                </div>
            @else
                <h2>{{ translate('No Payment Method Found') }}</h2>


            @endif
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="{{ asset('frontend/js/payment-transaction.js') }}"></script>
@endpush
