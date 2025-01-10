@extends('frontend.template-'.$templateId.'.partials.master')
@section('content')
    @include('frontend.template-'.$templateId.'.breadcrumb.breadcrumb')
    <div class="thankyou-section pt-120 pb-120">
        <img src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top" alt="section-bg">
        <img src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom" alt="section-bg">
        <img src="{{ asset('frontend/images/bg/e-vector1.svg') }}" class="evector1" alt="evector1">
        <img src="{{ asset('frontend/images/bg/e-vector2.svg') }}" class="evector2" alt="evector2">
        <img src="{{ asset('frontend/images/bg/e-vector3.svg') }}" class="evector3" alt="evector3">
        <img src="{{ asset('frontend/images/bg/e-vector4.svg') }}" class="evector4" alt="evector4">
        <div class="container">
            <div class="row d-flex justify-content-center g-4">
                <div class="col-lg-8 col-md-8 text-center">
                    <div class="thankyou-wrapper">
                        <div class="thankyou-text">
                            <h1>{{ translate('Thank You') }}!</h1>
                            <p class="para">
                                {{ translate("Thank you for choosing us! We're thrilled to have you as our customer") }}.
                                <br> {{ translate("We can't wait to serve you again") }}.</p>
                        </div>
                        <div class="check-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                <path
                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                            </svg>
                        </div>
                        <table class="table table-striped" style="width:100%;">
                            <tr>
                                <td>{{ translate('Product') }}:</td>
                                <td><strong>{{ $orderSingle->products->name }}</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Quantity') }}:</td>
                                <td>{{ $orderSingle->quantity }}</td>
                            </tr>
                            <tr>
                                <td>{{ $orderSingle->type == 2 ? translate('Bid Price') : translate('Price') }}:</td>
                                <td>{{ $orderSingle->type == 2 ? currency_symbol() . $orderSingle->bid_amount : currency_symbol() . $orderSingle->amount }}
                                </td>
                            </tr>
                            @if ($orderSingle->type == 2)
                                <tr>
                                    <td>{{ $orderSingle->payment_status == 3 ? translate('Final Amount') : translate('Initial Amount') }}:
                                    </td>
                                    <td>{{ currency_symbol() . $orderSingle->amount }}</td>
                                </tr>
                            @endif

                            @if ($orderSingle->amount != 0)
                                <tr>
                                    <td>{{ translate('Tax') . '(' . get_setting('tax_rate') . '%)' }}:</td>
                                    <td>{{ currency_symbol() . $orderSingle->tax_amount }}</td>
                                </tr>
                            @endif

                            <tr>
                                <td>{{ translate('Total') }}:</td>
                                <td>{{ currency_symbol() . ($orderSingle->amount + $orderSingle->tax_amount) }}</td>
                            </tr>
                        </table>
                        <div class="thankyou-content wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <p class="para"><strong>Note: </strong>An Confirmation Message will be sent in Your Email.
                                Stay With us.</p>
                            <!-- <p class="para">Your message has been received, and we appreciate your kind words! <br> Our team is already excited to help you with any inquiries you might have.</p> -->
                            <a href="{{ url('/') }}" class="eg-btn btn--primary btn--md">Back Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
