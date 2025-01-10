@extends('backend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/css/codemirror.css') }}">
    <script src="{{ asset('backend/js/codemirror.js') }}"></script>
    <script src="{{ asset('backend/js/codemirror_javascript.js') }}"></script>
@endpush

@section('content')
    <div class="page-title2">
        <img src="{{ asset('backend/images/bg/title-loog.png') }}" class="title-logo" alt="logo">
        <h5>{{ translate('Frontend Settings') }}</h5>
        <a class="clear-cache" href="{{ route('backend.cache-clear') }}"><i class="bi bi-eraser"></i>
            {{ translate('Clear Cache') }}</a>
    </div>
    <form action="{{ route('frontend.settings.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="tab-area settings-area">
            <div class="nav flex-row jusify-content-start nav-pills" id="v-pills-tab" role="tablist"
                aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general"
                    aria-selected="true">{{ translate('General') }}</button>

                <button class="nav-link" id="v-pills-theme-color-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-theme-color" type="button" role="tab" aria-controls="v-pills-theme-color"
                    aria-selected="true">{{ translate('Theme Color') }}</button>
                <button class="nav-link" id="v-pills-header-setting-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-header-setting" type="button" role="tab"
                    aria-controls="v-pills-header-setting" aria-selected="true">{{ translate('Header') }}</button>

                <button class="nav-link" id="v-pills-footer-bottom-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-footer-bottom" type="button" role="tab"
                    aria-controls="v-pills-footer-bottom" aria-selected="true">{{ translate('Footer') }}</button>
                <button class="nav-link" id="v-pills-breadcamp-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-breadcamp" type="button" role="tab" aria-controls="v-pills-breadcamp"
                    aria-selected="true">{{ translate('Breadcrumbs') }}</button>
                <button class="nav-link" id="v-pills-basic-seo-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-basic-seo" type="button" role="tab" aria-controls="v-pills-basic-seo"
                    aria-selected="true">{{ translate('SEO') }}</button>
                <button class="nav-link" id="v-pills-google-analytics-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-google-analytics" type="button" role="tab"
                    aria-controls="v-pills-google-analytics"
                    aria-selected="true">{{ translate('Google Analytics') }}</button>

                <button class="nav-link" id="v-pills-gdpr-tab" data-bs-toggle="pill" data-bs-target="#v-pills-gdpr"
                    type="button" role="tab" aria-controls="v-pills-gdpr"
                    aria-selected="true">{{ translate('GDPR Cookie') }}</button>


                {{-- <button class="nav-link" id="v-pills-css-js-tab" data-bs-toggle="pill" data-bs-target="#v-pills-css-js"
                    type="button" role="tab" aria-controls="v-pills-css-js"
                    aria-selected="true">{{ translate('Custom CSS/JS') }}</button> --}}
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel"
                    aria-labelledby="v-pills-general-tab">
                    <!-- temparory content -->
                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Header Logo') }}</label>
                                    <input type="file" class="form-control" name="header_logo"
                                        placeholder="{{ translate('Header Logo') }}">
                                    @if (get_setting('header_logo'))
                                        <img class="mt-2"
                                            src="{{ asset('assets/logo/' . get_setting('header_logo')) }}"
                                            alt="Header Logo" width="100">
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Favicon') }}</label>
                                    <input type="file" class="form-control" name="front_favicon"
                                        placeholder="{{ translate('Favicon') }}">
                                    @if (get_setting('front_favicon'))
                                        <img class="mt-2"
                                            src="{{ asset('assets/logo/' . get_setting('front_favicon')) }}"
                                            alt="Favicon" width="50">
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Term & Conditions Page Link') }}</label>
                                    <input type="text" class="form-control" name="term_conditions_link"  value="{{get_setting('term_conditions_link')}}">

                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Privacy & Policy Page Link') }}</label>
                                    <input type="text" class="form-control" name="privacy_policy_link" value="{{get_setting('privacy_policy_link')}}">

                                </div>
                            </div>

                        </div>
                        <div class="form-inner mb-35 d-flex justify-content-between flex-wrap position-relative">
                            <div class="form-group">
                                <input type="checkbox" name="show_preloader" id="show_preloader" value="1"
                                    {{ old('show_preloader', get_setting('show_preloader')) == 1 ? 'checked' : '' }}>
                                <label for="show_preloader">{{ translate('Show Preloader') }}</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-theme-color" role="tabpanel"
                    aria-labelledby="v-pills-theme-color-tab">

                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Primary Color') }}</label>
                                    <div class="input-group primary-color">
                                        <input type="text" class="form-control" name="primary_color"
                                            value="{{ old('primary_color', get_setting('primary_color')) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"
                                                    style="color: {{ get_setting('primary_color') ?? '#32c36c' }};"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Secondary Color') }}</label>
                                    <div class="input-group secondary-color">
                                        <input type="text" class="form-control" name="secondary_color"
                                            value="{{ old('secondary_color', get_setting('secondary_color')) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"
                                                    style="color: {{ get_setting('secondary_color') ?? '#1F2230' }};"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-header-setting" role="tabpanel"
                    aria-labelledby="v-pills-header-setting-tab">
                    <div class="eg-card product-card">
                        <div class="row">

                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Facebook Link') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('facebook_link', get_setting('facebook_link')) }}"
                                        name="facebook_link" placeholder="{{ translate('Facebook Link') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Twitter Link') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('twitter_link', get_setting('twitter_link')) }}"
                                        name="twitter_link" placeholder="{{ translate('Twitter Link') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Linkedin Link') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('linkedin_link', get_setting('linkedin_link')) }}"
                                        name="linkedin_link" placeholder="{{ translate('Linkedin Link') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Youtube Link') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('youtube_link', get_setting('youtube_link')) }}"
                                        name="youtube_link" placeholder="{{ translate('Youtube Link') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Instagram Link') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('instagram_link', get_setting('instagram_link')) }}"
                                        name="instagram_link" placeholder="{{ translate('Instagram Link') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Pinterest Link') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('pinterest_link', get_setting('pinterest_link')) }}"
                                        name="pinterest_link" placeholder="{{ translate('Pinterest Link') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Marchant Signup Button Name') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('marchant_btn', get_setting('marchant_btn')) }}"
                                        name="marchant_btn" placeholder="{{ translate('Marchant Signup Button Name') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Customer Signup Button Name') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('customer_btn', get_setting('customer_btn')) }}"
                                        name="customer_btn" placeholder="{{ translate('Customer Signup Button Name') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Sigin Button Name') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('login_btn', get_setting('login_btn')) }}" name="login_btn"
                                        placeholder="{{ translate('Sigin Button Name') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Email Address') }}</label>
                                    <input type="email" class="form-control"
                                        value="{{ old('email_address', get_setting('email_address')) }}"
                                        name="email_address" placeholder="{{ translate('Email Address') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Hotline Text') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('hotline_text', get_setting('hotline_text')) }}"
                                        name="hotline_text" placeholder="{{ translate('Hotline Text') }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Hotline Phone Number') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('hotline_phone', get_setting('hotline_phone')) }}"
                                        name="hotline_phone" placeholder="{{ translate('Hotline Phone Number') }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-footer-bottom" role="tabpanel"
                    aria-labelledby="v-pills-footer-bottom-tab">
                    <div class="eg-card product-card">
                        <div class="card-header mb-3">
                            <h6>{{ translate('Footer Top') }}</h6>
                        </div>
                        <div class="row">

                            <div class="col-xl-6 mb-3">
                                <h6><b>{{ translate('Footer Description') }}</b></h6>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="col-xl-12">
                                            <div class="form-inner mb-35">
                                                <label>{{ translate('Footer Logo') }}</label>
                                                <input type="file" class="form-control" name="footer_logo"
                                                    placeholder="{{ translate('Footer Logo') }}">
                                                @if (get_setting('footer_logo'))
                                                    <img class="mt-2"
                                                        src="{{ asset('assets/logo/' . get_setting('footer_logo')) }}"
                                                        alt="Footer Logo" width="100">
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-inner mb-35">
                                            <label>{{ translate('Description') }}
                                                {{ strtoupper(active_language()) }}</label>
                                            <textarea class="form-control" rows="5" name="footer_desc_{{ active_language() }}"
                                                placeholder="{{ translate('Footer Description') }}">{{ get_setting('footer_desc_' . active_language()) }}</textarea>
                                        </div>


                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-inner mb-35">
                                                    <label>{{ translate('Mailchimp API Key') }}</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('MAILCHIMP_API_KEY', get_setting('MAILCHIMP_API_KEY')) }}"
                                                        name="MAILCHIMP_API_KEY"
                                                        placeholder="{{ translate('Mailchimp API Key') }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-inner mb-35">
                                                    <label>{{ translate('Mailchimp List ID') }}</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('MAILCHIMP_LIST_ID', get_setting('MAILCHIMP_LIST_ID')) }}"
                                                        name="MAILCHIMP_LIST_ID"
                                                        placeholder="{{ translate('Mailchimp List ID') }}">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-4"><b>
                                                        {{ translate('Mailchimp Enabled/Disabled') }}</b></label>
                                                <div class="form-check form-switch col-sm-4">
                                                    <input class="form-check-input" value="1"
                                                        name="footer_mailchimp_status"
                                                        {{ get_setting('footer_mailchimp_status') == 1 ? 'checked' : '' }}
                                                        type="checkbox">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row mt-3">
                                            <label class="col-sm-4"><b>{{ translate('Enabled/Disabled') }}</b></label>
                                            <div class="form-check form-switch col-sm-4">
                                                <input class="form-check-input" value="1" name="footer1_status"
                                                    {{ get_setting('footer1_status') == 1 ? 'checked' : '' }}
                                                    type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-6 mb-3">
                                <h6><b>{{ translate('Footer Menu 1') }}</b></h6>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="form-inner mb-35">
                                            <label>{{ translate('Title') }}</label>
                                            <input type="text" name="footer1_title"
                                                value="{{ old('footer1_title', get_setting('footer1_title')) }}">
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4"><b> {{ translate('Enabled/Disabled') }}</b></label>
                                            <div class="form-check form-switch col-sm-4">
                                                <input class="form-check-input" value="1"
                                                    {{ get_setting('footer2_status') == 1 ? 'checked' : '' }}
                                                    name="footer2_status" type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mt-3"><b>{{ translate('Footer Menu 2') }}</b></h6>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="form-inner mb-35">
                                            <label>{{ translate('Title') }}</label>
                                            <input type="text" name="footer2_title"
                                                value="{{ old('footer2_title', get_setting('footer2_title')) }}">
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4"><b>{{ translate('Enabled/Disabled') }}</b></label>
                                            <div class="form-check form-switch col-sm-4">
                                                <input class="form-check-input" value="1"
                                                    {{ get_setting('footer3_status') == 1 ? 'checked' : '' }}
                                                    name="footer3_status" type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mt-3"><b>{{ translate('Footer Lasted Blog') }}</b></h6>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="form-inner mb-35">
                                            <label>{{ translate('Title') }}</label>
                                            <input type="text" name="footer_latest_title"
                                                value="{{ old('footer_latest_title', get_setting('footer_latest_title')) }}">
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4"><b> {{ translate('Enabled/Disabled') }}</b></label>
                                            <div class="form-check form-switch col-sm-4">
                                                <input class="form-check-input" value="1" name="footer4_status"
                                                    {{ get_setting('footer4_status') == 1 ? 'checked' : '' }}
                                                    type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header mt-3">
                            <h6>{{ translate('Footer Bottom') }}</h6>
                        </div>
                        <div class="row mt-4">
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Payment Method Image') }}</label>
                                    <input type="file" class="form-control" name="payment_method_img"
                                        placeholder="{{ translate('Payment Method') }}">
                                    @if (get_setting('payment_method_img'))
                                        <img class="mt-2"src="{{ asset('assets/logo/' . get_setting('payment_method_img')) }}"
                                            width="250">
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-inner mb-35">
                                            <label>{{ translate('Footer Copyright') }}
                                                {{ strtoupper(active_language()) }} </label>
                                            <textarea class="form-control summernote" name="front_copyright_{{ active_language() }}">{{ clean(get_setting('front_copyright_' . active_language())) }}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>




                            <div class="row mb-3">
                                <label class="col-sm-3"><b>{{ translate('Footer Bottom Enabled/Disabled') }}</b></label>
                                <div class="form-check form-switch col-sm-1">
                                    <input class="form-check-input" value="1"
                                        {{ get_setting('hide_footer_bottom') == 1 ? 'checked' : '' }}
                                        name="hide_footer_bottom" type="checkbox">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-breadcamp" role="tabpanel"
                    aria-labelledby="v-pills-breadcamp-tab">
                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Breadcrumb Image') }}</label>
                                    <input type="file" class="form-control" name="breadcamp_img"
                                        placeholder="{{ translate('Upload BreadCamp') }}">
                                    @if (get_setting('breadcamp_img'))
                                        <img class="mt-2"
                                            src="{{ asset('assets/logo/' . get_setting('breadcamp_img')) }}"
                                            alt="breadcamp image" width="200">
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Breadcrumb Color') }}</label>
                                    <div class="input-group primary-color">
                                        <input type="text" class="form-control" name="breadcrumb_color"
                                            value="{{ old('breadcrumb_color', get_setting('breadcrumb_color')) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-square"
                                                    style="color: {{ get_setting('breadcrumb_color') ?? '' }};"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-basic-seo" role="tabpanel"
                    aria-labelledby="v-pills-basic-seo-tab">

                    <div class="eg-card product-card">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Meta Image') }}</label>
                                    <input type="file" class="form-control" name="meta_img"
                                        placeholder="{{ translate('Upload Meta Image') }}">
                                    @if (get_setting('meta_img'))
                                        <img class="mt-2" src="{{ asset('assets/logo/' . get_setting('meta_img')) }}"
                                            alt="meta image" width="200">
                                    @endif
                                </div>

                            </div>
                            <div class="col-sm-4">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Meta Title') }}</label>
                                    <input type="text" class="form-control" name="meta_title"
                                        value="{{ old('meta_title', get_setting('meta_title')) }}"
                                        placeholder="{{ translate('Meta Title') }}">
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Meta Keywords') }}</label>
                                    <select class="username-input meta-keyward" name="meta_keyward[]"
                                        multiple="multiple">
                                        @if (get_setting('meta_keyward') && count(explode(',', get_setting('meta_keyward'))) > 0)
                                            @foreach (explode(',', get_setting('meta_keyward')) as $key => $keyward)
                                                <option value="{{ $keyward }}" selected>{{ $keyward }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-inner mb-35">
                                <label>{{ translate('Meta Description') }}</label>
                                <textarea class="form-control summernote" rows="5" name="meta_description"
                                    placeholder="{{ translate('Meta Description') }}">{{  clean(get_setting('meta_description'))  }}</textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-gdpr" role="tabpanel" aria-labelledby="v-pills-gdpr-tab">

                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-4 mb-35">
                                <div class="row">
                                    <label class="col-sm-2"><b>{{ translate('Enabled/Disabled') }}</b></label>
                                    <div class="form-check form-switch col-sm-10">
                                        <input class="form-check-input" value="1" name="gdpr_cookie_enabled"
                                            {{ get_setting('gdpr_cookie_enabled') == 1 ? 'checked' : '' }}
                                            type="checkbox">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-inner mb-35">
                                            <label>{{ translate('Cookie Title') }}
                                                {{ strtoupper(active_language()) }}</label>
                                            <input type="text" class="form-control"
                                                name="gdpr_title_{{ active_language() }}"
                                                value="{{ get_setting('gdpr_title_' . active_language()) }}"
                                                placeholder="{{ translate('Cookie Title') }}">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-inner mb-35">
                                            <label>{{ translate('Description') }} {{ strtoupper(active_language()) }}
                                            </label>
                                            <textarea name="gdpr_description_{{ active_language() }}" class="summernote">{{ clean(get_setting('gdpr_description_' . active_language()))}}</textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-google-analytics" role="tabpanel"
                    aria-labelledby="v-pills-google-analytics-tab">

                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Measurement ID / Tracking ID') }}</label>
                                    <input type="text" class="form-control" name="analytics_id"
                                        value="{{ old('analytics_id', get_setting('analytics_id')) }}"
                                        placeholder="{{ translate('Measurement ID / Tracking ID') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="v-pills-css-js" role="tabpanel" aria-labelledby="v-pills-css-js-tab">

                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('CSS') }}</label>
                                    <textarea class="form-control editorContainer" rows="10" name="custom_css"
                                        placeholder="{{ translate('Custom CSS') }}">{{ old('custom_css', get_setting('custom_css')) }}</textarea>
                                </div>
                                <div class="form-inner mb-35">
                                    <label>{{ translate('JS') }}</label>
                                    <textarea class="form-control editorContainer" rows="10" name="custom_js"
                                        placeholder="{{ translate('Custom JS') }}">{{ old('custom_js', get_setting('custom_js')) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <div class="button-group mt-15">
                    <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ 'Update' }}">
                </div>
            </div>
        </div>
    </form>

    @include('backend.backend_setting.modal')
@endsection
