@extends('frontend.template-'.selectedTheme().'.partials.master')
@section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')

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
                    <button id="rzp-button1" hidden>Pay</button>
                    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                    <script>
                        var options = {

                            "key": "{{ isset($response['razorpayId']) ? $response['razorpayId'] : '' }}", // Enter the Key ID generated from the Dashboard
                            "amount": "{{ isset($response['amount']) ? $response['amount'] : '' }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                            "currency": "{{ isset($response['currency']) ? $response['currency'] : '' }}",
                            "name": "{{ isset($response['name']) ? $response['name'] : '' }}",
                            "description": "{{ isset($response['description']) ? $response['description'] : '' }}",
                            "image": "{{ asset('assets/logo/' . get_setting('front_favicon')) }}", // You can give your logo url
                            "order_id": "{{ isset($response['orderId']) ? $response['orderId'] : '' }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                            "handler": function(response) {
                                document.getElementById('rzp_paymentid').value = response.razorpay_payment_id;
                                document.getElementById('rzp_orderid').value = response.razorpay_order_id;
                                document.getElementById('rzp_signature').value = response.razorpay_signature;
                                document.getElementById('rzp-paymentresponse').click();
                            },
                            "prefill": {
                                "name": "{{ isset($response['name']) ? $response['name'] : '' }}",
                                "email": "{{ isset($response['email']) ? $response['email'] : '' }}",
                                "contact": "{{ isset($response['contactNumber']) ? $response['contactNumber'] : '' }}"
                            },
                            "notes": {
                                "address": "{{ isset($response['address']) ? $response['address'] : '' }}"
                            },
                            "theme": {
                                "color": "#F37254"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        window.onload = function() {
                            document.getElementById('rzp-button1').click();
                        };
                        document.getElementById('rzp-button1').onclick = function(e) {
                            rzp1.open();
                            e.preventDefault();
                        }
                    </script>
                    <!-- This form is hidden -->
                    <form action="{{ route('razorpay.success') }}" method="POST" hidden>
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" />
                        <input type="text" class="form-control" id="rzp_paymentid" name="rzp_paymentid">
                        <input type="text" class="form-control" id="rzp_orderid" name="rzp_orderid">
                        <input type="text" class="form-control" id="rzp_signature" name="rzp_signature">
                        <button type="submit" id="rzp-paymentresponse" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
