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
                        <a href="{{ route('blog.edit', ['id' => $blogSingle->id, 'lang' => $language->code]) }}"><img
                                src="{{ asset('assets/img/flags/' . $language->code . '.png') }}" class="mr-3"
                                height="16"></a>
                    @endif
                @endforeach
            </div>
            <a href="{{ route('blog.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <form action="{{ route('blog.update', $blogSingle->id) }}" method="post" enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PATCH">
        <input type="hidden" name="lang" value="{{ $lang }}">
        @csrf
        <div class="row">

            <div class="col-lg-7">
                <div class="eg-card product-card">

                    <div class="form-inner mb-35">
                        <label>{{ translate('Title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="username-input"
                            value="{{ old('title', $blogSingle->getTranslation('title', $lang)) }}" name="title"
                            placeholder="{{ translate('Enter Title') }}">
                        @error('title')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <label>{{ translate('Long Descriptions') }} <span class="text-danger">*</span></label>
                        <textarea id="summernote" name="description">{{ clean($blogSingle->getTranslation('description', $lang)) }}</textarea>
                        @error('description')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-25">
                        <label>{{ translate('Tags') }}</label>
                        <input type="text" name="tags"
                            value="{{ old('tags', $blogSingle->getTranslation('tags', $lang)) }}" data-role="tagsinput"
                            placeholder="{{ translate('Enter Tags') }}">
                        @error('tags')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mt-3">
                        <div class="col-xl-12">
                            <div class="form-check">

                                <label class="form-check-label" for="seoBlog">
                                    <input class="form-check-input seo-page-checkbox" name="enable_seo"
                                        {{ $blogSingle->enable_seo ? 'checked' : '' }} type="checkbox"
                                        id="seoBlog">
                                    <b>{{ translate('Allow SEO') }}</b>
                                </label>
                            </div>
                        </div>

                        <div class="row mt-3 seo-content">
                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Title') }} <span>*</span></label>
                                    <input type="text" class="username-input" name="meta_title"
                                        value="{{ $blogSingle->meta_title }}" />
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="form-inner mb-35">
                                    <label> {{ translate('Meta Keyward') }}</label>
                                    <select class="username-input meta-keyward" name="meta_keyward[]" multiple="multiple">
                                        @if (isset($blogSingle->meta_keyward) && count($blogSingle?->meta_keyward) > 0)
                                            @foreach ($blogSingle->meta_keyward as $key => $keyward)
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
                                    <textarea name="meta_description"> {{ strip_tags($blogSingle->meta_description) }}</textarea>
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
                                    <input type="file" name="image" class="dropzone featues_image">
                                    @error('image')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
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
                                        <div class="box-body">
                                            @if ($blogSingle->image)
                                                <img src="{{ asset('uploads/blog/' . $blogSingle->image) }}"
                                                    alt="{{ $blogSingle->title }}" width="100">
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-12">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Category') }} <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single" name="category_id">
                                        <option value="">{{ translate('Select Option') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $blogSingle->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>

                    </div>
                </div>





            </div>
        </div>


        <div class="col-12 text-center">
            <div class="button-group mt-15">
                <button class="eg-btn btn--green medium-btn me-3" type="submit">{{ translate('Update') }}</button>
            </div>
        </div>
        </div>

        </div>
        </div>

        </div>
    </form>
@endsection
