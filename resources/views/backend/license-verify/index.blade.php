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

                <form action="{{ route('update.theme') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-inner mb-35 row">
                         <div class="text-center mb-35">
                            <h4>Theme Update</h4>
                         </div>
                        <div class="col-12 mb-35">
                            <input type="text" name="purchase_code" class="username-input"
                                placeholder="{{ translate('Enter Purchase Code') }}">
                            @error('purchase_code')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="com">

                             <code>{!! Session()->has('updateContent')? \Session::get('updateContent') :  "" !!}</code>
                        </div>
                    </div>


                    <div class="button-group mt-15 text-center">
                        <input type="submit" class="eg-btn btn--green back-btn me-3" value="{{ translate('Update') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
