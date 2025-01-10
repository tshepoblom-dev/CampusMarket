@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35 g-4">
        <div class="col-md-6">
            <div class="page-title text-md-start text-center">
                <h4>{{ $page_title ?? '' }}</h4>
            </div>
        </div>
        <div
            class="col-md-6 text-md-end text-center d-flex justify-content-md-end justify-content-center flex-row align-items-center flex-wrap gap-4">
            <a href="{{ route('contact.list') }}" class="eg-btn btn--primary back-btn"><img
                    src="{{ asset('backend/images/icons/add-icon.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-12">
            <div class="eg-card product-card">
                <div class="profile-area d-block">
                    <div class="profile-content">
                        <div class="small-hints">
                            <h4>{{ $contactSingle->name }}</h4>
                            <span class="date">{{ translate('Send At') }}
                                {{ date('d F, Y', strtotime($contactSingle->created_at)) }}</span>
                        </div>
                        <div class="row g-4">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 ">
                                <div class="single-infobox">
                                    <h6>{{ translate('Email') }}</h6>
                                    <a href="#">{{ $contactSingle->email }}</a>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 ">
                                <div class="single-infobox">
                                    <h6>{{ translate('Phone') }}</h6>
                                    <p>{{ $contactSingle->phone }}</p>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-12 col-lg-12 ">
                                <div class="single-infobox text-start">
                                    <h6>{{ translate('Subject') }}</h6>
                                    <p>{{ $contactSingle->subject }}</p>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-xl-12 col-lg-12 ">
                                <div class="single-infobox text-start">
                                    <h6>{{ translate('Message') }}</h6>
                                    <p>{{ prelaceScript(html_entity_decode( $contactSingle->message)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
