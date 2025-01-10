@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table category-table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Template Name') }}</th>
                            <th>{{ translate('Subject') }}</th>
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($email_templates->count() > 0)
                            @foreach ($email_templates as $key => $email_template)
                                <tr>
                                    <td data-label="S.N">
                                        {{ $key + 1 }}
                                    </td>
                                    <td data-label="Template Name"><b>{{ $email_template->name }}</b></td>
                                    <td data-label="Subject"><b>{{ $email_template->subject }}</b></td>
                                    <td data-label="Option">
                                        <div
                                            class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                            <a href="{{ route('email.template.edit', $email_template->id) }}"
                                                class="eg-btn add--btn"><i class="bi bi-pencil-square"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" data-label="Not Found">
                                    <h5 class="data-not-found">{{ translate('No Data Found') }}</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
