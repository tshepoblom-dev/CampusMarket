@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <a href="{{ route('languages.create') }}" class="eg-btn btn--primary back-btn float-end mb-3" title="Create"><img
                    src="{{ asset('backend/images/icons/add-icon.svg') }}" alt="Add New"> {{ translate('Add New') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table category-table language-table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Code') }}</th>
                            <th>{{ translate('RTL') }}</th>
                            <th>{{ translate('Default') }}</th>
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($languages as $key => $lang)
                            <tr>
                                <td data-label="S.N">{{ ($languages->currentpage() - 1) * $languages->perpage() + $key + 1 }}
                                </td>
                                <td data-label="Language Name">{{ $lang->name }}</td>
                                <td data-label="Language Code">
                                    <img src="{{ asset('assets/img/flags/' . $lang->code . '.png') }}" alt="">
                                    {{ $lang->code }}
                                </td>
                                <td data-label="Rtl">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input languageSwitchChange"
                                            data-activations-status="{{ $lang->rtl }}"
                                            data-language-id="{{ $lang->id }}" type="checkbox"
                                            id="languageSwitchChange{{ $lang->id }}"
                                            {{ $lang->rtl === 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td data-label="Default">
                                    <form action="{{ route('backend.settings.store') }}" method="post">
                                        @csrf
                                        <div class="form-check form-switch">
                                            <input onChange="this.form.submit()"
                                                class="form-check-input languageSwitchDefault" name="DEFAULT_LANGUAGE"
                                                value="{{ $lang->code }}" type="checkbox"
                                                id="languageSwitchDefault{{ $lang->id }}"
                                                {{ $lang->code === get_setting('DEFAULT_LANGUAGE', 'en') ? 'checked' : '' }}>
                                        </div>
                                    </form>
                                </td>
                                <td data-label="Option">
                                    <div
                                        class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                        <a href="{{ route('languages.translations', $lang->id) }}"
                                            class="eg-btn account--btn"><i class="bi bi-info-lg"></i></i></a>
                                        <a href="{{ route('languages.edit', $lang->id) }}" class="eg-btn add--btn"
                                            title="Edit"><i class="bi bi-pencil-square"></i></a>
                                        <form method="POST" action="{{ route('languages.delete', $lang->id) }}">
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
    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $languages->links() !!}
        </div>
    @endpush
@endsection
