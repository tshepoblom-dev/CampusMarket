 <!-- Modal -->
                    <div class="modal fade" id="staticBackdropPayment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropPaymentLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropPaymentLabel">{{translate('Payement Details')}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                   <table class="table table-bordered table-striped">
                                    <tbody>
                                    @foreach($merchant_payment as $marchantPayment)
                        <tr>
                            <td>{{translate('Type')}}:</td>
                            <td>{{ $marchantPayment->payment_type == 1 ? "Bank" : ($marchantPayment->payment_type == 2 ? "Mobile Banking" : "Paypal") }}</td>
                        </tr>
                        @if($marchantPayment->payment_type == 1)
                        <tr>
                            <td>{{translate('Bank Name')}}:</td>
                            <td>{{ $marchantPayment->bank_name }}</td>
                        </tr>
                        <tr>
                            <td>{{translate('Bank Account Name')}}:</td>
                            <td>{{ $marchantPayment->bank_ac_name }}</td>
                        </tr>
                        <tr>
                            <td>{{translate('Bank Account Number')}}:</td>
                            <td>{{ $marchantPayment->bank_ac_number }}</td>
                        </tr>
                        <tr>
                            <td>{{translate('Bank Routing Number')}}:</td>
                            <td>{{ $marchantPayment->bank_routing_number }}</td>
                        </tr>
                        @elseif($marchantPayment->payment_type == 2)
                        <tr>
                            <td>{{translate('Mobile Banking Name')}}:</td>
                            <td>{{ $marchantPayment->mobile_banking_name }}</td>
                        </tr>
                        <tr>
                            <td>{{translate('Mobile Number')}}:</td>
                            <td>{{ $marchantPayment->mobile_banking_number }}</td>
                        </tr>
                        @else
                        <tr>
                            <td>{{translate('Paypal Name')}}:</td>
                            <td>{{ $marchantPayment->paypal_name }}</td>
                        </tr>
                        <tr>
                            <td>{{translate('Paypal Username')}}:</td>
                            <td>{{ $marchantPayment->paypal_username }}</td>
                        </tr>
                        <tr>
                            <td>{{translate('Paypal Email')}}:</td>
                            <td>{{ $marchantPayment->paypal_email }}</td>
                        </tr>
                        <tr>
                            <td>{{translate('Paypal Mobile Number')}}:</td>
                            <td>{{ $marchantPayment->paypal_mobile_number }}</td>
                        </tr>
                        @endif
                        @endforeach
                                    </tbody>
                                   </table>
                            </div>
                            <div class="modal-footer border-white">
                                <button type="button" class="eg-btn btn--red py-1 px-3 rounded" data-bs-dismiss="modal">{{ translate('Close') }}</button>
                            </div>
                            </div>
                        </div>
                    </div>