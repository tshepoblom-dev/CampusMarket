@extends('frontend.template-'.selectedTheme().'.partials.master')
@section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')
    <div class="dashboard-section pt-120">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    @include('frontend.template-'.selectedTheme().'.customer.sidenav')
                </div>
                <div class="col-lg-9">

                    <div class="dashboard-profile">
                        <form action="{{ route('customer.profile.update', $customerSingle->id) }}" method="post"
                            enctype="multipart/form-data">
                            <input name="_method" type="hidden" value="PATCH">
                            @csrf
                            <div class="owner">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type="file" name="image" id="imageUpload" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        @if ($customerSingle->image)
                                            <div id="imagePreview"
                                                style="background-image: url('/uploads/users/{{ $customerSingle->image }}');">
                                            @else
                                                <div id="imagePreview"
                                                    style="background-image: url('/uploads/user/user.png');">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <h3>{{ $customerSingle->fname ?? '' }} {{ $customerSingle->lname ?? '' }}</h3>
                                <p class="para">{{ '@' . $customerSingle->username }}</p>
                            </div>
                    </div>
                    <div class="form-wrapper">

                        <div class="row">
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('First Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="@error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name', $customerSingle->fname) }}" name="first_name"
                                        placeholder="{{ translate('First Name') }}">
                                    @error('first_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('Last Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="@error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name', $customerSingle->lname) }}" name="last_name"
                                        placeholder="{{ translate('Last Name') }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('Contact Number') }}</label>
                                    <input type="text" class="@error('contact_number') is-invalid @enderror"
                                        value="{{ old('contact_number', $customerSingle->phone) }}" name="contact_number"
                                        placeholder="+8801">
                                    @error('contact_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" class="@error('email') is-invalid @enderror"
                                        value="{{ old('email', $customerSingle->email) }}" name="email"
                                        placeholder="{{ translate('Email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner">
                                    <label>{{ translate('Address') }}</label>
                                    <input type="text" class="@error('address') is-invalid @enderror"
                                        value="{{ old('address', $customerSingle->address) }}" name="address"
                                        placeholder="{{ translate('Address') }}">
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('Country') }}</label>
                                    <select class="country_id @error('country_id') is-invalid @enderror" name="country_id"
                                        id="country_id">
                                        <option value="">{{ translate('Select Option') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ old('country_id', $customerSingle->country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('State') }}</label>
                                    <select class="state_id @error('state_id') is-invalid @enderror" name="state_id"
                                        id="state_id">
                                        <option value="">{{ translate('Select Option') }}</option>
                                        @if ($customerSingle->state_id)
                                            <option value="{{ $customerSingle->state_id }}" selected>
                                                {{ $customerSingle->states->name }}</option>
                                        @endif
                                    </select>
                                    @error('state_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('City') }}</label>
                                    <select class="city_id @error('city_id') is-invalid @enderror" name="city_id"
                                        id="city_id">
                                        <option value="">{{ translate('Select Option') }}</option>
                                        @if ($customerSingle->city_id)
                                            <option value="{{ $customerSingle->city_id }}" selected>
                                                {{ $customerSingle->cities->name }}</option>
                                        @endif
                                    </select>
                                    @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <label>{{ translate('Zip Code') }}</label>
                                    <input type="text" class="@error('zip_code') is-invalid @enderror"
                                        value="{{ old('zip_code', $customerSingle->zip_code) }}" name="zip_code"
                                        placeholder="{{ translate('Zip Code') }}">
                                    @error('zip_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-inner">
                                    <label>{{ translate('Password') }}</label>
                                    <input type="password" class="@error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="{{ translate('Password') }}"
                                        autocomplete="new-password" />
                                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-inner mb-0">
                                    <label>{{ translate('Confirm Password') }}</label>
                                    <input type="password" name="password_confirmation" id="password2"
                                        placeholder="{{ translate('Confirm Password') }}" autocomplete="new-password" />
                                    <i class="bi bi-eye-slash" id="togglePassword2"></i>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="button-group">
                                    <button type="submit"
                                        class="eg-btn profile-btn">{{ translate('Update Profile') }}</button>
                                    <button type="button" class="eg-btn cancel-btn"
                                        onClick="window.location.reload()">{{ translate('Cancel') }}</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
