@extends('backend.layouts.master')
              @section('content')
                <div class="row mb-35 g-4">
                        <div class="page-title d-flex justify-content-between align-items-center">
                            <h4>{{$page_title ?? ''}}</h4>
                            <a href="{{route('withdraw.list')}}" class="eg-btn btn--primary back-btn"> <img src="{{asset('backend/images/icons/back.svg')}}" alt="{{ translate('Go Back') }}"> {{ translate('Go Back') }}</a>
                        </div>    
                </div>
                <div class="eg-card product-card">
                    <form action="{{route('withdraw.request')}}" method="post">
                        @csrf
                        <h4 class="form-box-title text-center">{{translate('Withdraw')}}</h4>
                        <div class="form-box mb-35">
                            <div class="row">
                                <div class="col-lg-6 mx-auto">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Amount')}} <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" value="{{old('amount')}}" min="1" max="{{Auth::user()->wallet_balance}}" class="username-input" placeholder="{{number_format(Auth::user()->wallet_balance,2)}}">
                                        @error('amount')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-inner mb-35">
                                    <label>{{translate('Payment Method')}} <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single payment_method" name="payment_method">
                                            <option value="">{{translate('Select Option')}}</option>
                                            @foreach($payment_methods as $payment_method)
                                            <option value="{{$payment_method->id}}">@if($payment_method->payment_type == 1){{$payment_method->bank_name.' - '.$payment_method->bank_ac_number}}@elseif($payment_method->payment_type == 2){{$payment_method->mobile_banking_name.' - '.$payment_method->mobile_banking_number}} @else {{'Paypal - '.$payment_method->paypal_email}} @endif</option>
                                            @endforeach
                                        </select>
                                        @error('payment_method')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="button-group mt-15 text-center">
                            <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ translate('Send') }}">
                            <button type="button" class="eg-btn btn--red cancel-btn" onClick="window.location.reload()">{{ translate('Cancel') }}</button>
                        </div>
                    </form>
                </div>
 @endsection