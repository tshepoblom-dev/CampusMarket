@extends('backend.layouts.master')
              @section('content')
                <div class="row d-flex justify-content-center">
                    <div class="col-md-7 col-sm-8">
                        <div class="eg-card deposit-card text-center position-relative">
                            @if($withdraw->status == 1)
                            <span class="eg-badge orange deopsit-badge">Pending</span>
                            @elseif($withdraw->status == 2)
                            <span class="eg-badge green deopsit-badge">Completed</span>
                            @else
                            <span class="eg-badge red deopsit-badge">Rejected</span>
                            @endif
                            <div class="winner-body">
                            @if($withdraw->payments->payment_type == 1)
                            <img src="{{asset('backend/images/bg/bank.jpg')}}" class="paypal img-fluid" alt="Bank">
                            @elseif($withdraw->payments->payment_type == 2)
                            <img src="{{asset('backend/images/bg/mobile_banking.jpg')}}" class="paypal img-fluid" alt="mobile_banking">
                            @else
                            <img src="{{asset('backend/images/bg/paypal.png')}}" class="paypal img-fluid" alt="paypal">
                            @endif
                                
                                <h4>{{translate('Withdraw Via')}} @if($withdraw->payments->payment_type == 1) {{translate('Bank')}} @elseif($withdraw->payments->payment_type == 2) {{translate('Mobile Banking')}} @else {{translate('Paypal')}} @endif</h4>
                                <div class="winner-details-list">
                                    <li><a href="#"><span>{{translate('Date')}} :</span><span>{{date('d M, Y H:i:s A', strtotime($withdraw->updated_at))}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Transaction Number')}} :</span><span>{{$withdraw->transaction_id}}</span></a></li>
                                    <li><a href="#"><span>{{translate('User Name')}} :</span><span class="username">{{'@'.$withdraw->users->username}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Method')}} :</span><span>@if($withdraw->payments->payment_type == 1) {{translate('Bank')}} @elseif($withdraw->payments->payment_type == 2) {{translate('Mobile Banking')}} @else {{translate('Paypal')}} @endif</span></a></li>
                                    @if($withdraw->payments->payment_type == 1)
                                    <li><a href="#"><span>{{translate('Name')}} :</span><span>{{$withdraw->payments->bank_name}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Branch Name')}} :</span><span>{{$withdraw->payments->branch_name}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Account Name')}} :</span><span>{{$withdraw->payments->bank_ac_name}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Account Number')}} :</span><span>{{$withdraw->payments->bank_ac_number}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Routing Number')}} :</span><span>{{$withdraw->payments->bank_routing_number}}</span></a></li>
                                    @elseif($withdraw->payments->payment_type == 2)
                                    <li><a href="#"><span>{{translate('Type')}} :</span><span>{{$withdraw->payments->mobile_banking_name}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Number')}} :</span><span>{{$withdraw->payments->mobile_banking_number}}</span></a></li>
                                    @else
                                    <li><a href="#"><span>{{translate('Name')}} :</span><span>{{$withdraw->payments->paypal_name}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Username')}} :</span><span>{{$withdraw->payments->paypal_username}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Email')}} :</span><span>{{$withdraw->payments->paypal_email}}</span></a></li>
                                    <li><a href="#"><span>{{translate('Mobile Number')}} :</span><span>{{$withdraw->payments->paypal_mobile_number}}</span></a></li>
                                    @endif
                                    <li><a href="#"><span>{{translate('Amount')}} :</span><span>{{$withdraw->amount.' '.$withdraw->currency}}</span></a></li>
                                </div>
                                @if($withdraw->status == 1)
                                <form action="{{route('withdraw.status.change',$withdraw->id)}}" method="post">
                                    <input name="_method" type="hidden" value="PATCH">
                                    @csrf
                                    <div class="button-group mt-15 d-flex justify-content-between">
                                        <button type="submit" class="radio-button">
                                            <input type="radio" id="approved" name="status" value="1"/>
                                            <label class="eg-btn btn--green medium-btn" for="approved">{{translate('Approved')}}</label>
                                        </button>
                                        <button type="submit" class="radio-button">
                                            <input type="radio" id="reject" name="status" value="2"/>
                                            <label class="eg-btn btn--red medium-btn" for="reject">{{translate('Reject')}}</label>
                                        </button>
                                    </div>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
@endsection