@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <a href="{{ route('products.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-lg-7">
                <div class="eg-card product-card">

                    <div class="form-inner mb-35">
                        <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="username-input" value="{{ old('name') }}" name="name"
                            placeholder="{{ translate('Enter Name') }}">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-35">
                        <label>{{ translate('SKU') }} <span class="text-danger">*</span></label>
                        <input type="text" class="username-input" value="{{ old('sku') }}" name="sku"
                            placeholder="{{ translate('Enter SKU') }}">
                        @error('sku')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <label>{{ translate('Short Descriptions') }} <span class="text-danger">*</span></label>
                        <textarea rows="5" name="short_desc" placeholder="{{ translate('Enter Short Descriptions') }}">{{ old('short_desc') }}</textarea>
                        @error('short_desc')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <label>{{ translate('Long Descriptions') }} <span class="text-danger">*</span></label>
                        <textarea id="summernote" name="long_desc">{{ old('long_desc') }}</textarea>
                        @error('long_desc')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label> <b>{{ translate('Specifications') }}</b></label>
                            </div>
                        </div>

                    </div>
                    <div class="form-inner">
                        <div id="specifiction_product">

                        </div>
                        <div class="add-btn-area d-flex jusify-content-center pt-4">
                            <button id="addRow" type="button" class="eg-btn btn--dark mx-auto"> <img
                                    src="{{ asset('backend/images/icons/add-icon.svg') }}"
                                    alt="{{ translate('Add New') }}"> {{ translate('Add New') }}</button>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="form-check">
                                <label class="form-check-label" for="seoProduct">
                                    <input class="form-check-input seo-page-checkbox" name="enable_seo" type="checkbox"
                                        id="seoProduct">
                                    <b>{{ translate('Allow SEO') }}</b>
                                </label>
                            </div>
                        </div>

                        <div class="row mt-3 seo-content">
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Title') }} <span class="text-danger">*</span></label>
                                    <input type="text" class="username-input" name="meta_title">
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Keyward') }}</label>
                                    <select class="username-input meta-keyward" name="meta_keyward[]" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Description') }}</label>
                                    <textarea name="meta_description"> </textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="eg-card product-card">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-inner file-upload mb-35">
                                <div id="drag-drop-area">
                                    <h3 class="text-danger">NEED TO ADD IMAGE UPLOAD DRAG & DROP</h3>
                                </div>

                                <label class="control-label">{{ translate('Feature Image') }}</label>

                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>{{ translate('Choose an image file or drag it here') }}</p>
                                    </div>
                                    <input type="file" name="features_image" class="dropzone featues_image">

                                </div>


                                <div class="preview-zone hidden">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-danger btn-xs remove-preview"
                                                    style="display:none;">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body"></div>
                                    </div>
                                </div>
                            </div>
                            @error('features_image')
                            <div class="error text-danger">{{ $message }}</div>
                           @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-inner img-upload mb-35">

                                <label class="control-label">{{ translate('Image Gallery') }}</label>

                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="glyphicon glyphicon-download-alt"></i>
                                        <p>{{ translate('Choose image files or drag it here') }}</p>
                                    </div>
                                    <input type="file" id="files" name="image[]" class="dropzone image_gal"
                                        multiple>

                                </div>

                                <div class="gallery-preview-zone hidden">
                                    <div class="box box-solid">
                                        <div class="box-body"></div>
                                    </div>
                                </div>
                            </div>
                            @error('image')
                                <div class="error text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @admin
                            <div class="col-12">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Author') }} <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="author_id" required>
                                        <option value="">{{ translate('Select Option') }}</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}"
                                                {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                                {{ $author->username }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endadmin
                        <div class="col-12">
                            <div class="form-inner mb-35">
                                <label>{{ translate('Category') }} <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single" name="category_id">
                                    <option value="">{{ translate('Select Option') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-inner mb-35">
                                <label>{{ translate('Quantity') }} <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" value="{{ old('quantity', 1) }}">
                                @error('quantity')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" id="product_sale_type">
                        <div class="col-12">
                            <div class="form-inner mb-35">
                                <label>{{ translate('Type') }} <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single auction_type_select" name="sale_type">
                                    <option selected disabled>{{ translate('Select Option') }}</option>
                                    <option value="1"> {{ 'Auction Sale' }}</option>
                                    <option value="2"> {{ 'Direct Sale' }}</option>
                                </select>
                                @error('sale_type')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                        </div>
                        <div class="col-12 pricing-area-schedule">
                            <div class="row">
                                <div class="col-xl-12 auction_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Minimum Deposit') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" placeholder="0.00" name="min_deposit"
                                                value="{{ old('min_deposit', 0) }}">
                                            <select class="js-example-basic-single" name="min_deposit_type">
                                                <option value="1"
                                                    {{ old('min_deposit_type') == 1 ? 'selected' : '' }}>
                                                    {{ 'Percent' }}</option>
                                                <option value="2"
                                                    {{ old('min_deposit_type') == 2 ? 'selected' : '' }}>
                                                    {{ 'Fixed' }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 direct_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Regular Price') }} </label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" placeholder="0.00" class="price" name="price"
                                                value="{{ old('price') }}">
                                            <button
                                                type="button">{{ currency_symbol(get_setting('default_currency')) }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 direct_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Sale Price') }} </label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" placeholder="0.00" name="sale_price"
                                                value="{{ old('sale_price') }}">
                                            <button
                                                type="button">{{ currency_symbol(get_setting('default_currency')) }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 auction_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Minimum Bid Price') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" placeholder="0.00" name="min_bid_price"
                                                value="{{ old('min_bid_price') }}">
                                            <button
                                                type="button">{{ currency_symbol(get_setting('default_currency')) }}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 auction_schedule">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Schedule') }} <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single auction_schedule_type"
                                            name="schedule_type">
                                            <option value="">{{ translate('Select Option') }}</option>
                                            <option value="1" {{ old('schedule_type') == 1 ? 'selected' : '' }}
                                                selected>
                                                {{ 'Yes' }}</option>
                                            <option value="2" {{ old('schedule_type') == 2 ? 'selected' : '' }}>
                                                {{ 'No' }}</option>
                                        </select>
                                        @error('schedule_type')
                                            <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12 auction_type schedule_start_date">
                                    <div class="form-inner mb-35 position-relative">
                                        <label>{{ translate('Start Date') }} <span class="text-danger">*</span></label>
                                        <input id="datepicker" name="start_date" placeholder="Select Date & Time"
                                            value="{{ old('start_date') }}">
                                        <img src="{{ asset('backend/images/icons/calendar2.svg') }}"
                                            class="datepicker-icon" alt="Calender">
                                    </div>
                                </div>
                                <div class="col-xl-12 auction_type">
                                    <div class="form-inner mb-35 position-relative">
                                        <label>{{ translate('End Date') }} <span class="text-danger">*</span></label>
                                        <input id="datepicker2" name="end_date" placeholder="Select Date & Time"
                                            value="{{ old('end_date') }}">
                                        <img src="{{ asset('backend/images/icons/calendar2.svg') }}"
                                            class="datepicker-icon" alt="Calender">
                                    </div>
                                </div>
                            </div>



                        </div>





                        <div class="col-12 text-center">
                            <div class="button-group mt-15">

                                <button type="submit" class="radio-button">
                                    <input type="radio" id="status1" name="status" value="1" />
                                    <label class="eg-btn btn--green medium-btn"
                                        for="status1">{{ translate('Published') }}</label>
                                </button>
                                <button type="submit" class="radio-button">
                                    <input type="radio" id="status2" name="status" value="2" />
                                    <label class="eg-btn btn--primary medium-btn"
                                        for="status2">{{ translate('Draft') }}</label>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>

@endsection
