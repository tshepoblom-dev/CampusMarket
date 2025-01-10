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
            <form action="" method="get">
                <div class="input-with-btn d-flex jusify-content-start align-items-strech">
                    <input type="text" name="search" placeholder="Contact Name & Email...">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table customer-table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Email') }}</th>
                            <th>{{ translate('Phone') }}</th>
                            <th>{{ translate('Subject') }}</th>
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($contacts->count() > 0)
                            @foreach ($contacts as $key => $contact)
                                <tr @if ($contact->status == 2) style="background-color: #eaebf1!important;" @endif>
                                    <td data-label="S.N">
                                        {{ ($contacts->currentpage() - 1) * $contacts->perpage() + $key + 1 }}</td>
                                    <td data-label="Name">{{ $contact->name }}</td>
                                    <td data-label="Email">{{ $contact->email }}</td>
                                    <td data-label="Phone">{{ $contact->phone }}</td>
                                    <td data-label="Subject">{{ $contact->subject }}</td>
                                    <td data-label="Action">
                                        <div
                                            class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                            <a class="eg-btn account--btn"
                                                href="{{ route('contact.view', $contact->id) }}"><i
                                                    class="bi bi-eye"></i></a>
                                            <form method="POST" action="{{ route('contact.delete', $contact->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="eg-btn delete--btn show_confirm"
                                                    data-toggle="tooltip" title="{{ translate('Delete') }}"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" data-label="Not Found">
                                    <h5 class="data-not-found">{{ translate('No Data Found') }}</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $contacts->links() !!}
        </div>
    @endpush
@endsection
