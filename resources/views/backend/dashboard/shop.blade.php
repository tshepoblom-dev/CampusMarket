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
            <h4>{{ $shopSingle?->name }}</h4>
        </div>
        <form action="{{ route('backend.shop.update') }}" method="post" enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="shop_id" value="{{ $shopSingle?->id}}">

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Shop Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('shop_name', $shopSingle?->name) }}"
                            class="username-input" placeholder="{{ translate('Enter Shop Name') }}" {{$shopSingle? "readonly" :""}} >
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Shop Email') }}</label>
                        <input type="text" name="shop_email" value="{{ old('shop_email', $shopSingle?->email) }}"
                            class="username-input" placeholder="{{ translate('Enter Shop Email') }}">
                        @error('shop_email')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Shop Phone') }}</label>
                        <input type="text" name="shop_phone" value="{{ old('shop_phone', $shopSingle?->phone) }}"
                            class="username-input" placeholder="{{ translate('Enter Shop Phone') }}">
                        @error('shop_phone')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Shop Address') }}</label>
                        <input type="text" name="shop_address" value="{{ old('shop_address', $shopSingle?->address) }}"
                            class="username-input" placeholder="{{ translate('Enter Shop Address') }}">
                        @error('shop_address')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Shop Logo') }}</label>
                        <input type="file" name="shop_logo" class="shop_logo">
                        @error('shop_logo')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($shopSingle?->logo)
                        <img class="mt-3" src="{{ asset('uploads/shop/' . $shopSingle?->logo) }}"
                            alt="{{ $shopSingle?->name }}" width="100">
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Cover Photo') }}</label>
                        <input type="file" name="cover_img" class="cover_img">
                        @error('cover_img')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if ($shopSingle?->cover_img)
                        <img class="mt-3" src="{{ asset('uploads/shop/' . $shopSingle->cover_img) }}"
                            alt="{{ $shopSingle->name }}" width="100">
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Facebook Link') }}</label>
                        <input type="text" name="facebook_link" value="{{ old('facebook_link', $shopSingle?->facebook) }}"
                            class="username-input" placeholder="{{ translate('Enter Facebook Link') }}">
                        @error('facebook_link')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Twitter Link') }}</label>
                        <input type="text" name="twitter_link" value="{{ old('twitter_link', $shopSingle?->twitter) }}"
                            class="username-input" placeholder="{{ translate('Enter Twitter Link') }}">
                        @error('twitter_link')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Linkedin Link') }}</label>
                        <input type="text" name="linkedin_link" value="{{ old('linkedin_link', $shopSingle?->linkedin) }}"
                            class="username-input" placeholder="{{ translate('Enter Linkedin Link') }}">
                        @error('linkedin_link')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Instagram Link') }}</label>
                        <input type="text" name="instagram_link"
                            value="{{ old('instagram_link', $shopSingle?->instagram) }}" class="username-input"
                            placeholder="{{ translate('Enter Instagram Link') }}">
                        @error('instagram_link')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Pinterest Link') }}</label>
                        <input type="text" name="pinterest_link"
                            value="{{ old('pinterest_link', $shopSingle?->pinterest) }}" class="username-input"
                            placeholder="{{ translate('Enter Pinterest Link') }}">
                        @error('pinterest_link')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner">
                        <label>{{ translate('Youtube Link') }}</label>
                        <input type="text" name="youtube_link" value="{{ old('youtube_link', $shopSingle?->youtube) }}"
                            class="username-input" placeholder="{{ translate('Enter Youtube Link') }}">
                        @error('youtube_link')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="button-group mt-15 text-end">
                <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ translate('Update') }}">
                <button type="button" class="eg-btn btn--red cancel-btn"
                    onClick="window.location.reload()">{{ translate('Cancel') }}</button>
            </div>
        </form>
    </div>
@endsection
