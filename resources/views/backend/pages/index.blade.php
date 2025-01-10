@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <button type="button" class="eg-btn btn--primary back-btn" data-bs-toggle="modal" data-bs-target="#createPage"><img
                    src="{{ asset('backend/images/icons/add-icon.svg') }}" alt="{{ translate('Add New') }}">
                {{ translate('Add New') }}</button>
        </div>
    </div>
    @php
        $locale = get_setting('DEFAULT_LANGUAGE', 'en');
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table category-table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Published') }}</th>
                            <th>{{ translate('Created') }}</th>
                            <th>
                                @foreach (\App\Models\Language::all() as $key => $language)
                                    <img src="{{ asset('assets/img/flags/' . $language->code . '.png') }}" class="mr-2">
                                @endforeach
                            </th>
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $key => $page)
                            <tr>
                                <td data-label="S.N">{{ ($pages->currentpage() - 1) * $pages->perpage() + $key + 1 }}</td>
                                <td data-label="Name">{{ $page->getTranslation('page_name') }}</td>
                                <td data-label="Status">
                                    <span id="statusBlockPage{{ $page->id }}">
                                        @if ($page->status == 1)
                                            <button class="eg-btn green-light--btn">{{ translate('Active') }}</button>
                                        @else
                                            <button class="eg-btn red-light--btn">{{ translate('Inactive') }}</button>
                                        @endif
                                    </span>
                                </td>
                                <td data-label="Published">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input flexSwitchCheckPage" type="checkbox"
                                            data-activations-status="{{ $page->status }}"
                                            data-page-id="{{ $page->id }}" id="flexSwitchCheckPage{{ $page->id }}"
                                            {{ $page->status == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td data-label="Created">{{ dateFormat($page->created_at) }}</td>
                                <td data-label="Language">
                                    @foreach (\App\Models\Language::all() as $key => $language)
                                        @if ($locale == $language->code)
                                            <i class="text-success bi bi-check-lg"></i>
                                        @else
                                            <a
                                                href="{{ route('page.edit', ['id' => $page->id, 'lang' => $language->code]) }}"><i
                                                    class="text--primary bi bi-pencil-square"></i></a>
                                        @endif
                                    @endforeach
                                </td>
                                <td data-label="Option">
                                    <div
                                        class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                        <!-- <button class="eg-btn add--btn"><i class="bi bi-pencil-square"></i></button> -->
                                        <a target="_blank" class="eg-btn account--btn"
                                            href="{{ $page->page_slug == 'home' ? url('/') : url($page->page_slug) }}"><i
                                                class="bi bi-box-arrow-up-right"></i></a>
                                        <a class="eg-btn add--btn" href="{{ route('page.edit', $page->id) }}"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <form method="POST" action="{{ route('page.delete', $page->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="eg-btn delete--btn show_confirm"
                                                data-toggle="tooltip" title='Delete'><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('backend.pages.modal')

    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $pages->links() !!}
        </div>
    @endpush
@endsection
