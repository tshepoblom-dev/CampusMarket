@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <a href="{{ route('email.template.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="eg-card product-card">
        <form action="{{ route('email.template.update', $emailTemplateSingle->id) }}" method="post"
            enctype="multipart/form-data">
            <input name="_method" type="hidden" value="PATCH">
            @csrf
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $emailTemplateSingle->name) }}" class="username-input"
                            name="name" placeholder="Enter Name">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-inner mb-35">
                        <label>{{ translate('Subject') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('subject', $emailTemplateSingle->subject) }}"
                            class="username-input" name="subject" placeholder="Enter Subject">
                        @error('subject')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-inner mb-35">
                        <label>{{ translate('Body') }} <span class="text-danger">*</span></label>
                        <textarea class="summernote" name="body">{{ clean($emailTemplateSingle->body) }}</textarea>
                        @error('body')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="button-group mt-15 text-center">
                    <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ translate('Update') }}">
                </div>

            </div>

        </form>
    </div>

    <div class="eg-card shortcode pt-5">

        <div class="row">
            <div class="col-12">
                <div class="table-wrapper">
                    <table class="eg-table table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th colspan="4">{{ translate('Shortcode for Mail') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ translate('Company Name') }} :</td>
                                <td colspan="3"><strong>[company_name]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer First Name') }} :</td>
                                <td><strong>[customer_fname]</strong></td>
                                <td>{{ translate('Merchant First Name') }} :</td>
                                <td><strong>[merchant_fname]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Last Name') }} :</td>
                                <td><strong>[customer_lname]</strong></td>
                                <td>{{ translate('Merchant Last Name') }} :</td>
                                <td><strong>[merchant_lname]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Full Name') }} :</td>
                                <td><strong>[customer_full_name]</strong></td>
                                <td>{{ translate('Merchant Full Name') }} :</td>
                                <td><strong>[merchant_full_name]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Username') }} :</td>
                                <td><strong>[customer_username]</strong></td>
                                <td>{{ translate('Merchant Username') }} :</td>
                                <td><strong>[merchant_username]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Email') }} :</td>
                                <td><strong>[customer_email]</strong></td>
                                <td>{{ translate('Merchant Email') }} :</td>
                                <td><strong>[merchant_email]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Phone') }} :</td>
                                <td><strong>[customer_phone]</strong></td>
                                <td>{{ translate('Merchant Phone') }} :</td>
                                <td><strong>[merchant_phone]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Address') }} :</td>
                                <td><strong>[customer_address]</strong></td>
                                <td>{{ translate('Merchant Address') }} :</td>
                                <td><strong>[merchant_address]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Country') }} :</td>
                                <td><strong>[customer_country]</strong></td>
                                <td>{{ translate('Merchant Country') }} :</td>
                                <td><strong>[merchant_country]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer State') }} :</td>
                                <td><strong>[customer_state]</strong></td>
                                <td>{{ translate('Merchant State') }} :</td>
                                <td><strong>[merchant_state]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer City') }} :</td>
                                <td><strong>[customer_city]</strong></td>
                                <td>{{ translate('Merchant City') }} :</td>
                                <td><strong>[merchant_city]</strong></td>
                            </tr>
                            <tr>
                                <td>{{ translate('Customer Zip Code') }} :</td>
                                <td><strong>[customer_zip_code]</strong></td>
                                <td>{{ translate('Merchant Zip Code') }} :</td>
                                <td><strong>[merchant_zip_code]</strong></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
