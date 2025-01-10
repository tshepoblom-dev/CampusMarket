@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35 g-4">
        <div class=" col-md-3">
            <div class="page-title text-md-start text-center">
                <h4>{{ $page_title ?? '' }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table customer-table prod-details-table">
                    <thead>
                        <tr>
                            @admin
                                <th>{{ translate('Customer Name') }}</th>
                            @endadmin
                            <th>{{ translate('Details') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            @admin
                                <th>{{ translate('Commission') }}</th>
                            @endadmin
                            @merchant
                                <th>{{ translate('Admin Commission') }}</th>
                            @endmerchant
                            <th>{{ translate('Transaction Date') }}</th>
                            <th>{{ translate('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($transactions->count() > 0)
                            @foreach ($transactions as $key => $transaction)
                                <tr>
                                    <td data-label="User">
                                        <a href="{{ route('customer.view', $transaction->user_id) }}" target="_blank">
                                            {{ $transaction->users->fname ? $transaction->users->fname . ' ' . $transaction->users->lname : '' }}

                                        </a>
                                    </td>

                                    <td data-label="Details">{{ $transaction->payment_details }}</td>
                                    <td data-label="Amount">{{ currency_symbol() . $transaction->amount }}</td>
                                    <td data-label="Admin Commission">
                                        {{ $transaction->admin_commission ? currency_symbol() . $transaction->admin_commission : '' }}
                                    </td>
                                    <td data-label="Date">
                                        <p>{{ dateFormat($transaction->created_at) }}</p>

                                    </td>
                                    <td data-label="Status">
                                        @if ($transaction->status == 1)
                                            <button
                                                class="eg-btn primary-light--btn">{{ translate('Processing') }}</button>
                                        @elseif($transaction->status == 2)
                                            <button
                                            class="eg-btn green-light--btn">{{ translate('Completed') }}</button>@else<button
                                                class="eg-btn red-light--btn">{{ translate('Cancel') }}</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" data-label="Not Found">
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
            {!! $transactions->links() !!}
        </div>
    @endpush
@endsection
