@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35 g-4">
        <div class=" col-md-3">
            <div class="page-title text-md-start text-center">
                <h4>{{ $page_title ?? '' }}</h4>
            </div>
        </div>
        <div
            class=" col-md-9 text-md-end text-center d-flex justify-content-md-end justify-content-center flex-row align-items-center flex-wrap gap-4">
            <form class="" id="sort_keys" action="" method="GET">
                <div class="input-with-btn d-flex jusify-content-start align-items-strech">
                    <input type="text" id="search"
                        name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset
                        placeholder="{{ translate('Type key & Enter') }}">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <a href="{{ route('languages.list') }}" class="eg-btn btn--primary back-btn"><img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="Back Button"> {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('languages.key_value_store', $language->id) }}" method="POST">
                @csrf
                <div class="table-wrapper">
                    <table class="eg-table table customer-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ translate('Key') }}</th>
                                <th>{{ translate('Value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lang_keys as $key => $translation)
                                <tr>
                                    <td data-label="Serial">
                                        {{ ($lang_keys->currentpage() - 1) * $lang_keys->perpage() + $key + 1 }}</td>
                                    <td data-label="Lang_Key" class="text-start">{{ $translation->lang_value }}</td>
                                    <td data-label="Value"><input type="text" class="form-control value"
                                            style="width:100%" name="values[{{ $translation->lang_key }}]"
                                            @if (($traslate_lang = \App\Models\Translation::where('lang', $language->code)->where('lang_key', $translation->lang_key)->latest()->first()) != null) value="{{ $traslate_lang->lang_value }}" @endif>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center custom-pagination">
                        {!! $lang_keys->links() !!}
                    </div>


                </div>
                <div class="form-group mb-0 text-end">
                    <button type="submit" class="eg-btn btn--primary back-btn"><img
                            src="{{ asset('backend/images/icons/add-new.svg') }}" alt="">
                        {{ translate('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
