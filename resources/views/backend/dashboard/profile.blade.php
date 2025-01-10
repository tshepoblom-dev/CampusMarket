@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35 g-4">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <a href="{{ route('backend.dashboard') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Dashboard') }}">
                {{ translate('Go Dashboard') }}</a>
        </div>
    </div>

    <div class="eg-card product-card">
        <div class="eg-card-title">
            <h4>{{ $userSingle->fname . ' ' . $userSingle->lname }}</h4>
        </div>
        <form action="{{ route('backend.profile.update', $userSingle->id) }}" method="post" enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
            
            @csrf
            <h4 class="form-box-title">{{ translate('Profile Details') }}</h4>
            <div class="form-box mb-35">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('First Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="fname" value="{{ old('fname', $userSingle->fname) }}"
                                class="username-input" placeholder="{{ translate('Enter First Name') }}">
                            @error('fname')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('Last Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="lname" value="{{ old('lname', $userSingle->lname) }}"
                                class="username-input" placeholder="{{ translate('Enter Last Name') }}">
                            @error('lname')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('Email') }} <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $userSingle->email) }}"
                                class="username-input" placeholder="{{ translate('Enter Email') }}" readonly>
                            @error('email')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('Mobile Number') }} <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $userSingle->phone) }}"
                                class="username-input" placeholder="{{ translate('Enter Mobile Number') }}">
                            @error('phone')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner mb-35">
                            <label>{{ translate('Address') }} <span class="text-danger">*</span></label>
                            <input type="text" name="address" value="{{ old('address', $userSingle->address) }}"
                                class="username-input" placeholder="{{ translate('Enter Address') }}">
                            @error('address')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('Country') }} <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single country_id" name="country_id">
                                <option value="">{{ translate('Select Option') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old('country_id', $userSingle->country_id) == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('State') }} <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single state_id" name="state_id">
                                <option value="">{{ translate('Select Option') }}</option>
                                @if ($userSingle->state_id)
                                    <option value="{{ $userSingle->state_id }}" selected>{{ $userSingle->states->name }}
                                    </option>
                                @endif
                            </select>
                            @error('state_id')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('City') }} <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single city_id" name="city_id">
                                <option value="">{{ translate('Select Option') }}</option>
                                @if ($userSingle->city_id)
                                    <option value="{{ $userSingle->city_id }}" selected>{{ $userSingle->cities->name }}
                                    </option>
                                @endif
                            </select>
                            @error('city_id')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6">
                        <div class="form-inner mb-35">
                            <label>{{ translate('Zip/Postal') }} <span class="text-danger">*</span></label>
                            <input type="text" name="zip_code" value="{{ old('zip_code', $userSingle->zip_code) }}"
                                class="username-input" placeholder="{{ translate('Zip/Postal') }}">
                            @error('zip_code')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <h4 class="form-box-title">{{ translate('Password') }}</h4>
            <div class="form-box mb-35">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="form-inner">
                            <label>{{ translate('Username') }} <span class="text-danger">*</span></label>
                            <input type="text" name="username" value="{{ old('username', $userSingle->username) }}"
                                class="username-input" placeholder="{{ translate('Enter Username') }}" readonly>
                            @error('username')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-inner">
                            <label>{{ translate('Password') }} <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="username-input" placeholder="**********"
                                autocomplete="new-password">
                            @error('password')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-inner">
                            <label>{{ translate('Confirm Password') }} <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="username-input"
                                placeholder="**********" autocomplete="new-password">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-inner file-upload">
                            <label>{{ translate('Profile Photo') }}</label>
                            <div class="dropzone-wrapper">
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <p>{{ translate('Choose an image file or drag it here') }}</p>
                                </div>
                                <input type="file" name="image" class="dropzone featues_image">
                                @error('image')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="preview-zone hidden">
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-danger btn-xs remove-preview"
                                                style="display:none;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        @if ($userSingle->image)
                                            <img src="{{ asset('uploads/users/' . $userSingle->image) }}"
                                                alt="{{ $userSingle->username }}" width="100">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @merchant
                <h4 class="form-box-title">{{ translate('Payment Details') }}</h4>
                <div class="form-box mb-35 text-center">
                    <div class="g-4" id="bankDetailsMainContent">
                        @if ($merchant_payment)
                            @foreach ($merchant_payment as $marchantPayment)
                                <div class="row payment_info">
                                    <div class="col-lg-6">
                                        <div class="form-inner">
                                            <input type="hidden" name="merchant_payment_id[]"
                                                value="{{ $marchantPayment->id }}">
                                            <label>{{ translate('Type') }} <span class="text-danger">*</span></label>
                                            <select class="js-example-basic-single payment_type" name="payment_type[]">
                                                <option value="">{{ translate('Select Option') }}</option>
                                                <option value="1"
                                                    {{ $marchantPayment->payment_type == 1 ? 'selected' : '' }}>
                                                    {{ translate('Bank') }}</option>
                                                <option value="2"
                                                    {{ $marchantPayment->payment_type == 2 ? 'selected' : '' }}>
                                                    {{ translate('Mobile Banking') }}</option>
                                                <option value="3"
                                                    {{ $marchantPayment->payment_type == 3 ? 'selected' : '' }}>
                                                    {{ translate('Paypal') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_bank"
                                        @if ($marchantPayment->bank_name == null) style="display:none;" @endif>
                                        <div class="form-inner">
                                            <label>{{ translate('Bank Name') }}</label>
                                            <input type="text" class="bank_name"
                                                value="{{ $marchantPayment->bank_name ?? '' }}" name="bank_name[]"
                                                placeholder="{{ translate('Enter Bank Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_bank"
                                        @if ($marchantPayment->branch_name == null) style="display:none;" @endif>
                                        <div class="form-inner">
                                            <label>{{ translate('Branch Name') }}</label>
                                            <input type="text" class="branch_name"
                                                value="{{ $marchantPayment->branch_name ?? '' }}" name="branch_name[]"
                                                placeholder="{{ translate('Enter Branch Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_bank"
                                        @if ($marchantPayment->bank_ac_name == null) style="display:none;" @endif>
                                        <div class="form-inner">
                                            <label>{{ translate('Bank Account Name') }}</label>
                                            <input type="text" class="bank_ac_name"
                                                value="{{ $marchantPayment->bank_ac_name ?? '' }}" name="bank_ac_name[]"
                                                placeholder="{{ translate('Enter Bank Account Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_bank"
                                        @if ($marchantPayment->bank_ac_number == null) style="display:none;" @endif>
                                        <div class="form-inner">
                                            <label>{{ translate('Bank Account Number') }}</label>
                                            <input type="text" name="bank_ac_number[]"
                                                value="{{ $marchantPayment->bank_ac_number ?? '' }}"
                                                class="bank_ac_number username-input"
                                                placeholder="{{ translate('Enter Bank Account Number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_bank"
                                        @if ($marchantPayment->bank_routing_number == null) style="display:none;" @endif>
                                        <div class="form-inner mb-35 ">
                                            <label>{{ translate('Bank Routing Number') }}</label>
                                            <input type="text" class="bank_routing_number"
                                                value="{{ $marchantPayment->bank_routing_number ?? '' }}"
                                                name="bank_routing_number[]"
                                                placeholder="{{ translate('Enter Bank Routing Number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_mobile"
                                        @if ($marchantPayment->mobile_banking_name == null) style="display:none;" @endif>
                                        <div class="form-inner mb-35 ">
                                            <label>{{ translate('Mobile Banking Name') }}</label>
                                            <input type="text" class="mobile_banking_name"
                                                value="{{ $marchantPayment->mobile_banking_name ?? '' }}"
                                                name="mobile_banking_name[]"
                                                placeholder="{{ translate('Enter Mobile Banking Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_mobile"
                                        @if ($marchantPayment->mobile_banking_number == null) style="display:none;" @endif>
                                        <div class="form-inner mb-35 ">
                                            <label>{{ translate('Mobile Number') }}</label>
                                            <input type="text" class="mobile_banking_number"
                                                value="{{ $marchantPayment->mobile_banking_number ?? '' }}"
                                                name="mobile_banking_number[]"
                                                placeholder="{{ translate('Enter Mobile Number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_paypal"
                                        @if ($marchantPayment->paypal_name == null) style="display:none;" @endif>
                                        <div class="form-inner mb-35 ">
                                            <label>{{ translate('Paypal Name') }}</label>
                                            <input type="text" class="paypal_name"
                                                value="{{ $marchantPayment->paypal_name ?? '' }}" name="paypal_name[]"
                                                placeholder="{{ translate('Enter Paypal Name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_paypal"
                                        @if ($marchantPayment->paypal_username == null) style="display:none;" @endif>
                                        <div class="form-inner mb-35 ">
                                            <label>{{ translate('Paypal Username') }}</label>
                                            <input type="text" class="paypal_username"
                                                value="{{ $marchantPayment->paypal_username ?? '' }}"
                                                name="paypal_username[]"
                                                placeholder="{{ translate('Enter Paypal Username') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_paypal"
                                        @if ($marchantPayment->paypal_email == null) style="display:none;" @endif>
                                        <div class="form-inner mb-35 ">
                                            <label>{{ translate('Paypal Email') }}</label>
                                            <input type="email" class="paypal_email"
                                                value="{{ $marchantPayment->paypal_email ?? '' }}" name="paypal_email[]"
                                                placeholder="{{ translate('Enter Paypal Email') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 select_paypal"
                                        @if ($marchantPayment->paypal_mobile_number == null) style="display:none;" @endif>
                                        <div class="form-inner mb-35 ">
                                            <label>{{ translate('Paypal Mobile Number') }}</label>
                                            <input type="text" class="paypal_mobile_number"
                                                value="{{ $marchantPayment->paypal_mobile_number ?? '' }}"
                                                name="paypal_mobile_number[]"
                                                placeholder="{{ translate('Enter Paypal Mobile Number') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button style="float: right;" type="button"
                                            class="removeRow eg-btn btn--red rounded px-3">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="row payment_info">
                            <div class="col-lg-6">
                                <div class="form-inner">
                                    <input type="hidden" name="merchant_payment_id[]" value="">
                                    <label>{{ translate('Type') }} <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single payment_type" name="payment_type[]">
                                        <option value="">{{ translate('Select Option') }}</option>
                                        <option value="1">{{ translate('Bank') }}</option>
                                        <option value="2">{{ translate('Mobile Banking') }}</option>
                                        <option value="3">{{ translate('Paypal') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 select_bank" style="display:none;">
                                <div class="form-inner">
                                    <label>{{ translate('Bank Name') }}</label>
                                    <input type="text" class="bank_name" name="bank_name[]"
                                        placeholder="{{ translate('Enter Bank Name') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_bank" style="display:none;">
                                <div class="form-inner">
                                    <label>{{ translate('Branch Name') }}</label>
                                    <input type="text" class="branch_name" name="branch_name[]"
                                        placeholder="{{ translate('Enter Branch Name') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_bank" style="display:none;">
                                <div class="form-inner">
                                    <label>{{ translate('Bank Account Name') }}</label>
                                    <input type="text" class="bank_ac_name" name="bank_ac_name[]"
                                        placeholder="{{ translate('Enter Bank Account Name') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_bank" style="display:none;">
                                <div class="form-inner">
                                    <label>{{ translate('Bank Account Number') }}</label>
                                    <input type="text" name="bank_ac_number[]" class="bank_ac_number username-input"
                                        placeholder="{{ translate('Enter Bank Account Number') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_bank" style="display:none;">
                                <div class="form-inner mb-35 ">
                                    <label>{{ translate('Bank Routing Number') }}</label>
                                    <input type="text" class="bank_routing_number" name="bank_routing_number[]"
                                        placeholder="{{ translate('Enter Bank Routing Number') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_mobile" style="display:none;">
                                <div class="form-inner mb-35 ">
                                    <label>{{ translate('Mobile Banking Name') }}</label>
                                    <input type="text" class="mobile_banking_name" name="mobile_banking_name[]"
                                        placeholder="{{ translate('Enter Mobile Banking Name') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_mobile" style="display:none;">
                                <div class="form-inner mb-35 ">
                                    <label>{{ translate('Mobile Number') }}</label>
                                    <input type="text" class="mobile_banking_number" name="mobile_banking_number[]"
                                        placeholder="{{ translate('Enter Mobile Number') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_paypal" style="display:none;">
                                <div class="form-inner mb-35 ">
                                    <label>{{ translate('Paypal Name') }}</label>
                                    <input type="text" class="paypal_name" name="paypal_name[]"
                                        placeholder="{{ translate('Enter Paypal Name') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_paypal" style="display:none;">
                                <div class="form-inner mb-35 ">
                                    <label>{{ translate('Paypal Username') }}</label>
                                    <input type="text" class="paypal_username" name="paypal_username[]"
                                        placeholder="{{ translate('Enter Paypal Username') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_paypal" style="display:none;">
                                <div class="form-inner mb-35 ">
                                    <label>{{ translate('Paypal Email') }}</label>
                                    <input type="email" class="paypal_email" name="paypal_email[]"
                                        placeholder="{{ translate('Enter Paypal Email') }}">
                                </div>
                            </div>
                            <div class="col-lg-6 select_paypal" style="display:none;">
                                <div class="form-inner mb-35 ">
                                    <label>{{ translate('Paypal Mobile Number') }}</label>
                                    <input type="text" class="paypal_mobile_number" name="paypal_mobile_number[]"
                                        placeholder="{{ translate('Enter Paypal Mobile Number') }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button style="float: right;" type="button" class="removeRow eg-btn btn--red rounded px-3">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <input type="button" value="{{ translate('Add Another Account') }}"
                        class="eg-btn btn--primary submit--btn mt-15 addRow">
                </div>
            @endmerchant
            <div class="button-group mt-15 text-end">
                <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ translate('Update') }}">
                <button type="button" class="eg-btn btn--red cancel-btn"
                    onClick="window.location.reload()">{{ translate('Cancel') }}</button>
            </div>
        </form>
    </div>
@endsection
