@extends('backend.layouts.master')
@section('content')

    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">

            <p></p>
            <a href="{{ route('page.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="wrap_menu">
            <div class="col-lg-12">
                <div class="eg-card product-card">
                    <form class="form" data-action="{{ route('page.update', $page->id) }}" enctype="multipart/form-data">
                        @method('patch')
                        @csrf
                        <input type="hidden" name="lang" id="lang" value="{{ $lang }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-inner mb-25">
                                    <label> {{ translate('Menu Name') }} <span class="text-danger"><b>*</b></span></label>
                                    <input type="text" class="username-input" placeholder="Enter Your Name"
                                        name="page_name" value="{{ $page->getTranslation('page_name' ,$lang) }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-inner mb-25">
                                    <label> {{ translate('Slug Name') }} <span class="text-danger"><b>*</b></span> </label>
                                    <input type="text" class="username-input" placeholder="Enter Your Name"
                                        name="page_slug" value="{{ $page->getTranslation('page_slug' ,$lang) }}">
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-check">
                                    <label class="form-check-label" for="seoPage">
                                        <input class="form-check-input seo-page-checkbox" name="enable_seo"
                                            {{ $page->enable_seo ? 'checked' : '' }} type="checkbox" id="seoPage">
                                        <b>{{ translate('Allow Page SEO') }}</b>
                                    </label>
                                </div>
                            </div>

                            <div class="row mt-3 seo-content">
                                <div class="col-xl-6">
                                    <div class="form-inner mb-35">
                                        <label> {{ translate('Meta Title') }} <span
                                                class="text-danger"><b>*</b></span></label>
                                        <input type="text" class="username-input" name="meta_title"
                                            value="{{ $page->getTranslation('meta_title' ,$lang) }}" />
                                    </div>
                                </div>




                                <div class="col-xl-6">
                                    <div class="form-inner mb-35">
                                        <label> {{ translate('Meta Keyward') }}</label>
                                        <select class="username-input meta-keyward" name="meta_keyward[]"
                                            multiple="multiple">
                                            @if (isset($page->meta_keyward) && count($page?->meta_keyward) > 0)

                                                @foreach ($page->getTranslation('meta_keyward', $lang) as $key => $keyward)
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
                                        <textarea class="summernote" name="meta_description"> {{ clean( $page->getTranslation('meta_description', $lang)) }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="form-check">
                                <label class="form-check-label" for="is_bread_crumb">
                                    <input class="form-check-input is_bread_crumb" name="is_bread_crumb"
                                        {{ $page->is_bread_crumb ? 'checked' : '' }} type="checkbox" id="is_bread_crumb">
                                    <b>{{ translate('Bread Crumb Enable') }}</b>
                                </label>
                            </div>
                        </div>

                        <div class="form-inner mb-35 mt-3">

                            <button type="submit"
                                class="eg-btn btn--green btn shadow  me-3">{{ translate('Published') }}</button>
                            <a class="eg-btn btn--primary btn shadow  me-3"
                                href="{{ $page->page_slug == 'home' ? url('/') : url($page->page_slug) }}">{{translate('View Page')}}</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-sm-3 widget-item widget-item-list ">
            <div class="row">
                @foreach ($widgetList as $item)
                    <div class="col-sm-6">
                        <div class="widget-name add-element text-center" data-slug="{{ $item->widget_slug }}"
                            data-page-id="{{ $page->id }}" data-widget-name="{{ $item->widget_name }}">
                            <div class="icon mb-3"> {!! $item->icon !!} </div>
                            <div class="section-name">
                                <p>{{ $item->widget_name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-sm-9 dragSortableItems">
            <div class="eg-card product-card">
                <div name="active_widget_list" class="sortable-list active_widget_list  accordion sortable-widget-item">
                    @if ($page->widgetContents->count() > 0)
                        @foreach ($page->widgetContents as $widgetContent)
                            @include('backend.pages.widgets.' . $widgetContent->widget_slug, [
                                'widgetContent' => $widgetContent,
                            ])
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('backend/js/sweetalert2.js') }}"></script>
    @include('js.admin.widget-js')
@endpush
