@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>

            <a href="{{ route('category.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="eg-card product-card">



                @if (purchaseCode())
                    <form action="{{ route('license.purcahase.remove') }}" method="POST" enctype="multipart/form-data">
                        @csrf



                        <div class="form-inner mb-35 row">
                            <div class="text-center mb-35">
                                <h4>Purchase Code Remove</h4>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" readonly name="purchase_code" class="username-input"
                                    placeholder="{{ translate('Enter Purchase Code') }}"
                                    value="{{ purchaseCode()->purchase_code }}">
                                @error('purchase_code')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        <div class="button-group mt-15 text-center">
                            <input type="submit" class="eg-btn delete--btn  back-btn me-3"
                                value="{{ translate('Remove') }}">
                        </div>
                    </form>
                @else
                    <form action="{{ route('license.verify.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="license_type" value="envato">


                        <div class="form-inner mb-35 row">
                            <div class="text-center mb-35">
                                <h4>License Verify</h4>
                            </div>
                            <div class="col-12 mb-3">
                                <input type="text" value="{{ old('purchase_code') }}" name="purchase_code"
                                    class="username-input" placeholder="{{ translate('Enter Purchase Code') }}">
                                @error('purchase_code')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-35">
                                <input type="text" value="{{ old('email') }}" name="email" class="username-input"
                                    placeholder="{{ translate('Enter Your Email') }}">
                                @error('email')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="button-group mt-15 text-center">
                            <input type="submit" class="eg-btn btn--green back-btn me-3"
                                value="{{ translate('Verify') }}">
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
