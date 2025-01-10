<!-- Modal -->
<div class="modal specification-modal fade" id="finalPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="finalPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="currency-icon">
                    <span><i class="bi bi-currency-dollar"></i></span>
                </div>
                <h4 class="modal-title" id="finalPaymentModalLabel">{{ translate('Bid Final Payment') }}</h4>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="bi bi-x"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customer.payment.method') }}" method="POST" class="modal-require-validation"
                    data-cc-on-file-modal="false"
                    data-modal-stripe-publishable-key="{{ get_payment_method('stripe_key') }}" id="modal-payment-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $bidSingle->product_id }}">
                    <input type="hidden" name="current_url" value="{{ URL::full() }}">
                    <div class="choose-payment-mathord">
                        <h5>{{ translate('Select Your Payment Method') }}</h5>

                        @if (paymentMethods()->count() > 0)
                            <div class="payment-option final-payment-option">
                                <div class="payment-method-section d-flex gap-3 align-items-center flex-wrap">
                                    @foreach (paymentMethods() as $payment_method)
                                        @if ($payment_method->id == 1)
                                            <div class="custom-control custom-radio custom-control-inline offline">
                                                <input type="radio" id="{{ $payment_method->method_name }}"
                                                    name="payment_method" class="custom-control-input"
                                                    value="{{ $payment_method->method_name }}">
                                                <label class="custom-control-label"
                                                    for="{{ $payment_method->method_name }}">

                                                    @if ($payment_method->logo)
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                            alt="Wallet" height="20">
                                                    @else
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                            alt="Wallet" height="20">
                                                    @endif
                                                    <div class="checked"><i class="bi bi-check"></i></div>
                                                </label>
                                            </div>
                                        @else
                                            <div
                                                class="custom-control custom-radio custom-control-inline {{ $payment_method->method_name }}">
                                                <input type="radio" id="{{ $payment_method->method_name }}"
                                                    name="payment_method" class="custom-control-input"
                                                    value="{{ $payment_method->method_name }}">
                                                <label class="custom-control-label"
                                                    for="{{ $payment_method->method_name }}">
                                                    @if ($payment_method->logo)
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                                            alt="{{ $payment_method->method_name }}" height="25">
                                                    @else
                                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                                            alt="{{ $payment_method->method_name }}" height="25">
                                                    @endif

                                                    <div class="checked"><i class="bi bi-check"></i></div>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach



                                </div>
                            </div>
                        @else
                            {{ translate('No Payment Method Found') }}
                        @endif

                        <div class="pt-25 payment-option-hide mt-30 " id="StripePayment">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <div class="input-area">
                                        <label>{{ translate('Card Number') }}</label>
                                        <input type="number" class="modal_stripe_card_number stripe_card_number "
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
                                        <input type="text" class="modal_stripe_cvc" placeholder="CVC" />
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

                    @php
                        $last_amount = $bidSingle->bid_amount - $bidSingle->amount;
                        $tax_amount = ($last_amount / 100) * get_setting('tax_rate');
                        $total_amount = $last_amount + $tax_amount;
                    @endphp
                    <input type="hidden" name="order_id" value="{{ $bidSingle->id }}">
                    <input type="hidden" class="modal_amount_main_val" name="amount"
                        value="{{ number_format($last_amount, 2) ?? 0 }}">
                    <input type="hidden" class="modal_tax_amount_val" name="tax_amount"
                        value="{{ number_format($tax_amount, 2) ?? 0 }}">
                    <input type="hidden" class="modal_total_amount_val" name="total_amount"
                        value="{{ number_format($total_amount, 2) ?? 0 }}">
                    <div class="total-amount-area">
                        <ul>
                            <li>{{ translate('Payment Amount') }}<span
                                    class="amount-main">{{ currency_symbol() }}{{ number_format($last_amount, 2) ?? 0 }}</span>
                            </li>
                            <li>{{ get_setting('tax_rate') ?? 0 }}% {{ translate('TAX') }}<span
                                    class="amount">{{ currency_symbol() }}{{ number_format($tax_amount, 2) ?? 0 }}</span>
                            </li>
                            <li>{{ translate('Total for payment') }}<span
                                    class="amount">{{ currency_symbol() }}{{ number_format($total_amount, 2) ?? 0 }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="pay-btn">
                        <input type="hidden" name="type" value="7">
                        <button class="btn-hover" type="submit">{{ translate('Pay') }} {{ currency_symbol() }}<span
                                class="modal_total_amount">{{ number_format($total_amount, 2) ?? 0 }}</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="{{ asset('frontend/js/payment-transaction.js') }}"></script>
@endpush
