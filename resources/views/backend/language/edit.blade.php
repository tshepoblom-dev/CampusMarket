@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <a href="{{ route('languages.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt=""> {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="eg-card product-card">
                <form action="{{ route('languages.update', $languageSingle->id) }}" method="POST">

                    @csrf
                    <div class="form-inner mb-35">
                        <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" value="{{ old('name', $languageSingle->name) }}" name="name"
                            class="username-input" placeholder="{{ translate('Enter Name') }}">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-35">
                        <label>{{ translate('Code') }} *</label>
                        <select id="language_code" class="form-control js-example-basic-single mb-2 mb-md-0" name="code">
                            <option value="">{{ translate('Select Option') }}</option>
                            @foreach (\File::files(public_path('assets/img/flags')) as $path)
                                <option value="{{ pathinfo($path)['filename'] }}"
                                    {{ old('code', $languageSingle->code) == pathinfo($path)['filename'] ? 'selected' : '' }}>
                                    {{ strtoupper(pathinfo($path)['filename']) }}</option>
                            @endforeach
                        </select>
                        @error('code')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="button-group mt-15 text-center  ">
                        <input type="submit" class="eg-btn btn--green back-btn me-3" value="{{ translate('Update') }}">
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection
