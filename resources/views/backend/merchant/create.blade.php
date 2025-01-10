@extends('backend.layouts.master')
              @section('content')
                <div class="row mb-35 g-4">
                        <div class="page-title d-flex justify-content-between align-items-center">
                            <h4>{{$page_title ?? ''}}</h4>
                            <a href="{{route('merchant.list')}}" class="eg-btn btn--primary back-btn"> <img src="{{asset('backend/images/icons/back.svg')}}" alt="{{ translate('Go Back') }}"> {{ translate('Go Back') }}</a>
                        </div>    
                </div>
                <div class="eg-card product-card">
                    <form action="{{route('merchant.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <h4 class="form-box-title">{{translate('Profile Details')}}</h4>
                        <div class="form-box mb-35">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('First Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="fname" value="{{old('fname')}}" class="username-input" placeholder="{{translate('Enter First Name')}}">
                                        @error('fname')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Last Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="lname" value="{{old('lname')}}" class="username-input" placeholder="{{translate('Enter Last Name')}}">
                                        @error('lname')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Email')}} <span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{old('email')}}" class="username-input" placeholder="{{translate('Enter Email')}}">
                                        @error('email')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Mobile Number')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" value="{{old('phone')}}" class="username-input" placeholder="{{translate('Enter Mobile Number')}}">
                                        @error('phone')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Address')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="address" value="{{old('address')}}" class="username-input" placeholder="{{translate('Enter Address')}}">
                                        @error('address')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="form-inner mb-35">
                                    <label>{{translate('Country')}} <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single country_id" name="country_id">
                                            <option value="">{{translate('Select Option')}}</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('State')}} <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single state_id" name="state_id">
                                            <option value="">{{('Select Option')}}</option>
                                        </select>
                                        @error('state_id')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('City')}} <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single city_id" name="city_id">
                                            <option value="">{{('Select Option')}}</option>
                                        </select>
                                        @error('city_id')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Zip/Postal')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="zip_code" value="{{old('zip_code')}}" class="username-input" placeholder="{{translate('Zip/Postal')}}">
                                        @error('zip_code')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Admin Commission')}}</label>
                                        <input type="text" name="admin_commission" value="{{old('admin_commission')}}" placeholder="{{translate('Enter Admin Commission')}}" aria-label="Enter Admin Commission" aria-describedby="admin_commission">
                                        <span class="form-inner-text" id="admin_commission">%</span>
                                        @error('admin_commission')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="form-box-title">{{translate('Shop Info')}}</h4>
                        <div class="form-box mb-35">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Shop Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" id="shop_name" name="shop_name" value="{{old('shop_name')}}" class="username-input" placeholder="{{translate('Enter Shop Name')}}">
                                        @error('shop_name')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                        <span id="error_shop_name"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Shop Email')}}</label>
                                        <input type="text" name="shop_email" value="{{old('shop_email')}}" class="username-input" placeholder="{{translate('Enter Shop Email')}}">
                                        @error('shop_email')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Shop Phone')}}</label>
                                        <input type="text" name="shop_phone" value="{{old('shop_phone')}}" class="username-input" placeholder="{{translate('Enter Shop Phone')}}">
                                        @error('shop_phone')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Shop Address')}}</label>
                                        <input type="text" name="shop_address" value="{{old('shop_address')}}" class="username-input" placeholder="{{translate('Enter Shop Address')}}">
                                        @error('shop_address')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Shop Logo')}}</label>
                                        <input type="file" name="shop_logo" class="shop_logo">
                                            @error('shop_logo')
                                            <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Cover Photo')}}</label>
                                        <input type="file" name="cover_img" class="cover_img">
                                            @error('cover_img')
                                            <div class="error text-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Facebook Link')}}</label>
                                        <input type="text" name="facebook_link" value="{{old('facebook_link')}}" class="username-input" placeholder="{{translate('Enter Facebook Link')}}">
                                        @error('facebook_link')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Twitter Link')}}</label>
                                        <input type="text" name="twitter_link" value="{{old('twitter_link')}}" class="username-input" placeholder="{{translate('Enter Twitter Link')}}">
                                        @error('twitter_link')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Linkedin Link')}}</label>
                                        <input type="text" name="linkedin_link" value="{{old('linkedin_link')}}" class="username-input" placeholder="{{translate('Enter Linkedin Link')}}">
                                        @error('linkedin_link')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Instagram Link')}}</label>
                                        <input type="text" name="instagram_link" value="{{old('instagram_link')}}" class="username-input" placeholder="{{translate('Enter Instagram Link')}}">
                                        @error('instagram_link')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Pinterest Link')}}</label>
                                        <input type="text" name="pinterest_link" value="{{old('pinterest_link')}}" class="username-input" placeholder="{{translate('Enter Pinterest Link')}}">
                                        @error('pinterest_link')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Youtube Link')}}</label>
                                        <input type="text" name="youtube_link" value="{{old('youtube_link')}}" class="username-input" placeholder="{{translate('Enter Youtube Link')}}">
                                        @error('youtube_link')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="form-box-title">{{translate('Password')}}</h4>
                        <div class="form-box mb-35">
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <div class="form-inner">
                                        <label>{{translate('Username')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="username" value="{{old('username')}}" class="username-input" placeholder="{{translate('Enter Username')}}">
                                        @error('username')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-inner">
                                        <label>{{translate('Password')}} <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="username-input" placeholder="**********">
                                        @error('password')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-inner">
                                        <label>{{translate('Confirm Password')}} <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" class="username-input" placeholder="**********">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-inner file-upload">
                                        <label>{{translate('Profile Photo')}}</label>
                                        <div class="dropzone-wrapper">
                                        <div class="dropzone-desc">
                                            <i class="glyphicon glyphicon-download-alt"></i>
                                            <p>{{translate('Choose an image file or drag it here')}}</p>
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
                                                <button type="button" class="btn btn-danger btn-xs remove-preview" style="display:none;">
                                                <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                            </div>
                                            <div class="box-body"></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="form-box-title">{{translate('Bank Details')}}</h4>
                        <div class="form-box mb-35 text-center">
                            <div class="g-4" id="bankDetailsMainContent">
                            <div class="row payment_info">
                                <div class="col-lg-6">
                                    <div class="form-inner">
                                        <label>{{translate('Type')}} <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single payment_type" name="payment_type[]">
                                            <option value="">{{translate('Select Option')}}</option>
                                            <option value="1">{{translate('Bank')}}</option>
                                            <option value="2">{{translate('Mobile Banking')}}</option>
                                            <option value="3">{{translate('Paypal')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 select_bank" style="display:none;">
                                    <div class="form-inner">
                                        <label>{{translate('Bank Name')}}</label>
                                        <input type="text" class="bank_name" name="bank_name[]" placeholder="{{translate('Enter Bank Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_bank" style="display:none;">
                                    <div class="form-inner">
                                        <label>{{translate('Branch Name')}}</label>
                                        <input type="text" class="branch_name" name="branch_name[]" placeholder="{{translate('Enter Branch Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_bank" style="display:none;">
                                    <div class="form-inner">
                                        <label>{{translate('Bank Account Name')}}</label>
                                        <input type="text" class="bank_ac_name" name="bank_ac_name[]" placeholder="{{translate('Enter Bank Account Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_bank" style="display:none;">
                                    <div class="form-inner">
                                        <label>{{translate('Bank Account Number')}}</label>
                                        <input type="text" name="bank_ac_number[]" class="bank_ac_number username-input" placeholder="{{translate('Enter Bank Account Number')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_bank" style="display:none;">
                                    <div class="form-inner mb-35 ">
                                        <label>{{translate('Bank Routing Number')}}</label>
                                        <input type="text" class="bank_routing_number" name="bank_routing_number[]" placeholder="{{translate('Enter Bank Routing Number')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_mobile" style="display:none;">
                                    <div class="form-inner mb-35 ">
                                        <label>{{translate('Mobile Banking Name')}}</label>
                                        <input type="text" class="mobile_banking_name" name="mobile_banking_name[]" placeholder="{{translate('Enter Mobile Banking Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_mobile" style="display:none;">
                                    <div class="form-inner mb-35 ">
                                        <label>{{translate('Mobile Number')}}</label>
                                        <input type="text" class="mobile_banking_number" name="mobile_banking_number[]" placeholder="{{translate('Enter Mobile Number')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_paypal" style="display:none;">
                                    <div class="form-inner mb-35 ">
                                        <label>{{translate('Paypal Name')}}</label>
                                        <input type="text" class="paypal_name" name="paypal_name[]" placeholder="{{translate('Enter Paypal Name')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_paypal" style="display:none;">
                                    <div class="form-inner mb-35 ">
                                        <label>{{translate('Paypal Username')}}</label>
                                        <input type="text" class="paypal_username" name="paypal_username[]" placeholder="{{translate('Enter Paypal Username')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_paypal" style="display:none;">
                                    <div class="form-inner mb-35 ">
                                        <label>{{translate('Paypal Email')}}</label>
                                        <input type="email" class="paypal_email" name="paypal_email[]" placeholder="{{translate('Enter Paypal Email')}}">
                                    </div>
                                </div>
                                <div class="col-lg-6 select_paypal" style="display:none;">
                                    <div class="form-inner mb-35 ">
                                        <label>{{translate('Paypal Mobile Number')}}</label>
                                        <input type="text" class="paypal_mobile_number" name="paypal_mobile_number[]" placeholder="{{translate('Enter Paypal Mobile Number')}}">
                                    </div>
                                </div>
                            </div>
                            </div>
                            <input type="button" value="{{translate('Add Another Account')}}" class="eg-btn btn--primary submit--btn mt-15 addRow">
                        </div>
                        <div class="button-group mt-15 text-end">
                            <input type="submit" class="eg-btn btn--green medium-btn me-3" id="saveBtn" value="{{ translate('Save') }}">
                            <button type="button" class="eg-btn btn--red cancel-btn" onClick="window.location.reload()">{{ translate('Cancel') }}</button>
                        </div>
                    </form>
                </div>
 @endsection