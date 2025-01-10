@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <a href="{{ route('support.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="eg-card product-card">
        <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Username') }}</label>
                        <input type="text" class="username-input" value="{{ Auth::user()->username }}"
                            placeholder="Enter Your Name" readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Email Address') }}</label>
                        <input type="text" class="username-input" value="{{ Auth::user()->email }}"
                            placeholder="Enter Your Email" readonly>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Subject') }} <span class="text-danger">*</span></label>
                        <input type="text" name="subject" class="username-input" placeholder="Enter Your Subject">
                        @error('subject')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Department') }} <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="department">
                            <option value="2"> {{translate('General Support')}}</option>
                            <option value="1"> {{translate('Technical Support')}}</option>
                            <option value="3">{{translate('Payment Issue')}}</option>
                            <option value="4"> {{translate('Other Issue')}}</option>
                        </select>
                        @error('department')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Priority') }} <span class="text-danger">*</span></label>
                        <select class="js-example-basic-single" name="priority">
                            <option value="1">High</option>
                            <option value="2" selected>Medium</option>
                            <option value="3">Low</option>
                        </select>
                        @error('priority')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Message') }}</label>
                        <textarea id="summernote" name="description"></textarea>
                        @error('description')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">

                    <!-- add input with click start-->
                    <div class="form-inner">
                        <div id="inputTypeFile">
                            <div class=" mb-3 row g-3">
                                <div class="col-12">
                                    <input type="file" name="attachment[]" placeholder="No File Choosen">
                                    <!-- <button id="removeRow2" type="button" class="eg-btn btn--red rounded px-3"><i class="bi bi-x"></i></button> -->
                                </div>
                                <div class="input-group-append"></div>
                            </div>
                        </div>
                        <div id="newInputFile"></div>
                        <div class="add-btn-area pt-1 text-end">
                            <button id="addRow2" type="button" class="eg-btn btn--red medium-btn"><i
                                    class="bi bi-plus-lg"></i> {{ translate('Add More') }}</button>
                        </div>
                    </div>
                    <!-- add input with click end -->
                </div>
                <div class="button-group mt-15 text-center  ">
                    <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ translate('Save') }}">
                </div>
            </div>

        </form>
    </div>
@endsection
