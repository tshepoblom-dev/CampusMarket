@extends('backend.layouts.master')
              @section('content')
                <div class="row mb-35 g-4">
                        <div class="page-title d-flex justify-content-between align-items-center">
                            <h4>{{$page_title ?? ''}}</h4>
                            <a href="{{route('customer.list')}}" class="eg-btn btn--primary back-btn"> <img src="{{asset('backend/images/icons/back.svg')}}" alt="{{ translate('Go Back') }}"> {{ translate('Go Back') }}</a> 
                    </div>  
                </div>
                <div class="eg-card product-card">
                    <div class="eg-card-title">
                        <h4>{{$customerSingle->custom_id . ' - ' .$customerSingle->fname .' '. $customerSingle->lname}}</h4>
                    </div>
                    <form action="{{route('customer.update',$customerSingle->id)}}" method="post" enctype="multipart/form-data">
                        <input name="_method" type="hidden" value="PATCH"> 
                        @csrf
                        <h4 class="form-box-title">{{translate('Profile Details')}}</h4>
                        <div class="form-box mb-35">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('First Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="fname" value="{{old('fname',$customerSingle->fname)}}" class="username-input" placeholder="{{translate('Enter First Name')}}">
                                        @error('fname')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Last Name')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="lname" value="{{old('lname',$customerSingle->lname)}}" class="username-input" placeholder="{{translate('Enter Last Name')}}">
                                        @error('lname')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Email')}} <span class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{old('email',$customerSingle->email)}}" class="username-input" placeholder="{{translate('Enter Email')}}">
                                        @error('email')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Mobile Number')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" value="{{old('phone',$customerSingle->phone)}}" class="username-input" placeholder="{{translate('Enter Mobile Number')}}">
                                        @error('phone')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Address')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="address" value="{{old('address',$customerSingle->address)}}" class="username-input" placeholder="{{translate('Enter Address')}}">
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
                                            <option value="{{$country->id}}" {{ old('country_id', $customerSingle->country_id) == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
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
                                            <option value="">{{translate('Select Option')}}</option>
                                            @if($customerSingle->state_id)
                                            <option value="{{$customerSingle->state_id}}" selected>{{$customerSingle->states->name}}</option>
                                            @endif
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
                                            <option value="">{{translate('Select Option')}}</option>
                                            @if($customerSingle->city_id)
                                            <option value="{{$customerSingle->city_id}}" selected>{{$customerSingle->cities->name}}</option>
                                            @endif
                                        </select>
                                        @error('city_id')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6">
                                    <div class="form-inner mb-35">
                                        <label>{{translate('Zip/Postal')}} <span class="text-danger">*</span></label>
                                        <input type="text" name="zip_code" value="{{old('zip_code',$customerSingle->zip_code)}}" class="username-input" placeholder="{{translate('Zip/Postal')}}">
                                        @error('zip_code')
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
                                        <input type="text" name="username" value="{{old('username',$customerSingle->username)}}" class="username-input" placeholder="{{translate('Enter Username')}}" readonly>
                                        @error('username')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-inner">
                                        <label>{{translate('Password')}} <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="username-input" placeholder="**********" autocomplete="new-password">
                                        @error('password')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-inner">
                                        <label>{{translate('Confirm Password')}} <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" class="username-input" placeholder="**********" autocomplete="new-password">
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
                                            <div class="box-body">
                                                @if($customerSingle->image)
                                                    <img src="{{asset('uploads/users/'.$customerSingle->image)}}" alt="{{$customerSingle->username}}" width="100">
                                                @endif
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button-group mt-15 text-end">
                            <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ translate('Update') }}">
                            <button type="button" class="eg-btn btn--red cancel-btn" onClick="window.location.reload()">{{ translate('Cancel') }}</button>
                        </div>
                    </form>
                </div>
 @endsection