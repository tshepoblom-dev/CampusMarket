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
                    <input type="text" name="search" placeholder="Transaction ID Or Amount...">
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
                            <th>{{ translate('Customer') }}</th>
                            <th>{{ translate('Method') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th>{{ translate('Transaction ID') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Date') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if ($deposits->count() > 0)
                            @foreach ($deposits as $key => $deposit)
                                <tr>
                                    <td data-label="S.N">
                                        {{ ($deposits->currentpage() - 1) * $deposits->perpage() + $key + 1 }}</td>
                                    <td data-label="Customer"><a href="{{ route('customer.view', $deposit->users->id) }}"
                                            title="{{ $deposit->users->username }}">{{ $deposit->users->username . ' - ' . $deposit->users->custom_id }}</a>
                                    </td>
                                    <td data-label="Method">{{ ucfirst($deposit->payment_method) }}</td>
                                    <td data-label="Currency">
                                        {{ strtoupper($deposit->currency) . ' ' . number_format($deposit->amount, 2) }}
                                    </td>
                                    <td data-label="Transaction ID">{{ $deposit->transaction_id }}</td>
                                    <td data-label="Status">
                                        @if ($deposit->status == 2)
                                            <button
                                            class="eg-btn green-light--btn">{{ translate('Approved') }}</button>@else<button
                                                class="eg-btn red-light--btn">{{ translate('Rejected') }}</button>
                                        @endif
                                    </td>
                                    <td data-label="Date">{{ dateFormat($deposit->created_at) }}</td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" data-label="Not Found">
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
            {!! $deposits->links() !!}
        </div>
    @endpush
@endsection
