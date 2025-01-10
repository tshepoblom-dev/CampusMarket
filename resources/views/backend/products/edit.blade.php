@extends('backend.layouts.master')
@section('content')


    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <div class="language-changer">
                <span>{{ translate('Language Translation') }}: </span>
                @foreach (\App\Models\Language::all() as $key => $language)
                    @if ($lang == $language->code)
                        <img src="{{ asset('assets/img/flags/' . $language->code . '.png') }}" class="mr-3" height="16">
                    @else
                        <a href="{{ route('products.edit', ['id' => $productSingle->id, 'lang' => $language->code]) }}"><img
                                src="{{ asset('assets/img/flags/' . $language->code . '.png') }}" class="mr-3"
                                height="16"></a>
                    @endif
                @endforeach
            </div>
            <a href="{{ route('products.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <form action="{{ route('products.update', $productSingle->id) }}" method="post" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PATCH">
        <input type="hidden" name="lang" value="{{ $lang }}">
        @csrf
        <div class="row">


            <div class="col-lg-7">
                <div class="eg-card product-card">

                    <div class="form-inner mb-35">
                        <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="username-input"
                            value="{{ old('name', $productSingle->getTranslation('name', $lang)) }}" name="name"
                            placeholder="{{ translate('Enter Name') }}">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-35">
                        <label>{{ translate('SKU') }} <span class="text-danger">*</span></label>
                        <input type="text" class="username-input" value="{{ old('sku', $productSingle->sku) }}"
                            name="sku" placeholder="{{ translate('Enter SKU') }}">
                        @error('sku')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <label>{{ translate('Short Descriptions') }} <span class="text-danger">*</span></label>
                        <textarea rows="5" name="short_desc" placeholder="{{ translate('Enter Short Descriptions') }}">{{ old('short_desc', $productSingle->getTranslation('short_desc', $lang)) }}</textarea>
                        @error('short_desc')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <label>{{ translate('Long Descriptions') }} <span class="text-danger">*</span></label>
                        <textarea id="summernote" name="long_desc">{{ clean( $productSingle->getTranslation('long_desc', $lang))  }}</textarea>
                        @error('long_desc')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <div class="mb-3 row">
                            <div class="col-md-6">
                                <label>{{ translate('Specifications') }}</label>
                            </div>
                        </div>

                    </div>
                    @php
                        $locale = get_setting('DEFAULT_LANGUAGE', 'en');
                    @endphp
                    <div class="form-inner">
                        @if ($locale == $lang)
                            <div id="specifiction_product">
                                @foreach ($specifications as $key => $specification)
                                    <div class="mb-3 row g-3 inputFormRow">
                                        <div class="col-md-6">
                                            <input type="text" name="specifications[{{ $key }}][label]"
                                                class="m-input"
                                                value="{{ $specification->getTranslation('label', $lang) }}"
                                                autocomplete="off">
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center gap-2">
                                            <input type="text" name="specifications[{{ $key }}][value]"
                                                class="n-input"
                                                value="{{ $specification->getTranslation('value', $lang) }}"
                                                autocomplete="off">
                                            <button id="removeRow" type="button" class="eg-btn btn--red rounded px-3">
                                                <i class="bi bi-x"></i></button>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="add-btn-area d-flex jusify-content-center pt-4">
                                <button id="addRow" type="button" class="eg-btn btn--dark mx-auto"> <img
                                        src="{{ asset('backend/images/icons/add-icon.svg') }}"
                                        alt="{{ translate('Add New') }}"> {{ translate('Add New') }}</button>
                            </div>
                        @else
                            <div id="specifiction_product">
                                @foreach ($specifications as $key => $specification)
                                    <input type="hidden" name="specifications[{{ $key }}][specification_id]"
                                        class="m-input" value="{{ $specification->id }}" autocomplete="off">
                                    <div class="mb-3 row g-3 inputFormRow">
                                        <div class="col-md-6">
                                            <input type="text" name="specifications[{{ $key }}][label]"
                                                class="m-input"
                                                value="{{ $specification->getTranslation('label', $lang) }}"
                                                autocomplete="off">
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-center gap-2">
                                            <input type="text" name="specifications[{{ $key }}][value]"
                                                class="n-input"
                                                value="{{ $specification->getTranslation('value', $lang) }}"
                                                autocomplete="off">

                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="form-check">

                                <label class="form-check-label" for="seoProduct">
                                    <input class="form-check-input seo-page-checkbox" name="enable_seo"
                                        {{ $productSingle->enable_seo ? 'checked' : '' }} type="checkbox"
                                        id="seoProduct">
                                    <b>{{ translate('Allow SEO') }}</b>
                                </label>
                            </div>
                        </div>

                        <div class="row mt-3 seo-content">
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Title') }} <span>*</span></label>
                                    <input type="text" class="username-input" name="meta_title"
                                        value="{{ $productSingle->meta_title }}" />
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Keyward') }}</label>
                                    <select class="username-input meta-keyward" name="meta_keyward[]"
                                        multiple="multiple">
                                        @if (isset($productSingle->meta_keyward) && count($productSingle?->meta_keyward) > 0)
                                            @foreach ($productSingle->meta_keyward as $key => $keyward)
                                                <option value="{{ $keyward }}" selected>{{ $keyward }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Description') }}</label>
                                    <textarea name="meta_description"> {{ $productSingle->meta_description }}</textarea>
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
                                    <input type="file" name="features_image" class="dropzone features_image">
                                </div>

                                @error('features_image')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror

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
                                        <div class="box-body">
                                            @if ($productSingle->features_image)
                                                <img src="{{ asset('uploads/products/features/' . $productSingle->features_image) }}"
                                                    alt="{{ $productSingle->name }}" width="100">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    @error('image')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="gallery-preview-zone hidden">
                                    <div class="box box-solid">
                                        <div class="box-body">
                                            @if ($galleries->count() > 0)
                                                @foreach ($galleries as $gallery)
                                                    <div class="img-thumb-wrapper card shadow"
                                                        id="gallery{{ $gallery->id }}">
                                                        <span class="exist_remove"
                                                            data-gellery_id="{{ $gallery->id }}">X</span>
                                                        <img class="img-thumb"
                                                            src="{{ asset('uploads/products/gallery/' . $gallery->image) }}"
                                                            title="{{ $gallery->image }}">
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @admin
                            <div class="col-12">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Author') }} <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="author_id" required>
                                        <option value="">{{ translate('Select Option') }}</option>
                                        @foreach ($authors as $author)
                                            <option value="{{ $author->id }}"
                                                {{ $productSingle->author_id == $author->id ? 'selected' : '' }}>
                                                {{ $author->username }}</option>
                                        @endforeach
                                    </select>
                                    @error('author_id')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
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
                                            {{ old('category_id', $productSingle->category_id) == $category->id ? 'selected' : '' }}>
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
                                <input type="number" name="quantity"
                                    value="{{ old('quantity', $productSingle->quantity) }}">
                                @error('quantity')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" id="product_sale_type" value="{{ $productSingle->sale_type }}">
                        <div class="col-12">
                            <div class="form-inner mb-35">
                                <label>{{ translate('Type') }} <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single auction_type_select" name="sale_type">
                                    <option selected disabled>{{ translate('Select Option') }}</option>
                                    <option value="1"
                                        {{ old('sale_type', $productSingle->sale_type) == 1 ? 'selected' : '' }}>
                                        {{ 'Auction Sale' }}</option>
                                    <option value="2"
                                        {{ old('sale_type', $productSingle->sale_type) == 2 ? 'selected' : '' }}>
                                        {{ 'Direct Sale' }}</option>
                                </select>
                                @error('sale_type')
                                    <div class="error text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-12 pricing-area-schedule">
                            <div class="row">
                                <div class="col-xl-12 auction_type ">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Minimum Deposit') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" placeholder="0.00" name="min_deposit"
                                                value="{{ old('min_deposit', $productSingle->min_deposit) }}"
                                                @if ($productSingle->sale_type == 1) required @endif>
                                            <select class="js-example-basic-single" name="min_deposit_type"
                                                @if ($productSingle->sale_type == 1) required @endif>
                                                <option value="1"
                                                    {{ old('min_deposit_type', $productSingle->min_deposit_type) == 1 ? 'selected' : '' }}>
                                                    {{ 'Percent' }}</option>
                                                <option value="2"
                                                    {{ old('min_deposit_type', $productSingle->min_deposit_type) == 2 ? 'selected' : '' }}>
                                                    {{ 'Fixed' }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 direct_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Regular Price') }} </label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" class="price" placeholder="0.00" name="price"
                                                value="{{ old('price', $productSingle->price) }}">
                                            <button
                                                type="button">{{ currency_symbol(get_setting('default_currency')) }}</button>
                                        </div>
                                        @error('price')
                                            <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-6 direct_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Sale Price') }} </label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" placeholder="0.00" name="sale_price"
                                                value="{{ old('sale_price', $productSingle->sale_price) }}">
                                            <button
                                                type="button">{{ currency_symbol(get_setting('default_currency')) }}</button>
                                        </div>
                                        @error('sale_price')
                                            <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12 auction_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Minimum Bid Price') }} <span
                                                class="text-danger">*</span></label>
                                        <div class="input-with-btn style2 d-flex jusify-content-start align-items-strech">
                                            <input type="text" placeholder="0.00" name="min_bid_price"
                                                value="{{ old('min_bid_price', $productSingle->min_bid_price) }}"
                                                @if ($productSingle->sale_type == 1) required @endif>
                                            <button
                                                type="button">{{ currency_symbol(get_setting('default_currency')) }}</button>
                                        </div>
                                        @error('min_bid_price')
                                            <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xl-12 auction_type">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Schedule') }} <span class="text-danger">*</span></label>
                                        <select class="js-example-basic-single auction_schedule_type"
                                            name="schedule_type">
                                            <option value="1"
                                                {{ $productSingle->schedule_type == 1 ? 'selected' : '' }}>
                                                {{ 'Yes' }}</option>
                                            <option value="2"
                                                {{ $productSingle->schedule_type == 2 ? 'selected' : '' }}>
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
                                        <input id="datepicker3" name="start_date" placeholder="Select Date & Time"
                                            value="{{ old('start_date', date('m/d/Y H:i', strtotime($productSingle->start_date))) }}"
                                            @if ($productSingle->sale_type == 1 && $productSingle->schedule_type == 1) required @endif>
                                        <img src="{{ asset('backend/images/icons/calendar2.svg') }}"
                                            class="datepicker-icon" alt="Calender">
                                    </div>
                                    @error('start_date')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 auction_type">
                                    <div class="form-inner mb-35 position-relative">
                                        <label>{{ translate('End Date') }} <span class="text-danger">*</span></label>
                                        <input id="datepicker4" name="end_date" placeholder="Select Date & Time"
                                            value="{{ old('end_date', date('m/d/Y H:i', strtotime($productSingle->end_date))) }}"
                                            @if ($productSingle->sale_type == 1) required @endif>
                                        <img src="{{ asset('backend/images/icons/calendar2.svg') }}"
                                            class="datepicker-icon" alt="Calender">
                                    </div>
                                    @error('end_date')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="col-xl-12 text-center">
                            <div class="button-group mt-15">
                                @if ($productSingle->status == 1)
                                    <button class="eg-btn btn--green medium-btn"
                                        type="submit">{{ translate('Update') }}</button>
                                @else
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
