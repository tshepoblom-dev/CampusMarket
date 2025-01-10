@extends('frontend.template-'.selectedTheme().'.partials.master')
@section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')
    <div class="dashboard-section pt-120">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    @include('frontend.template-'.selectedTheme().'.customer.sidenav')
                </div>
                <div class="col-lg-9">
                    <!-- table title-->
                    <div class="table-title-area">

                        <form action="" method="get">
                            <select id="order-category" class="paginate_filter" name="search">
                                <option value="5">{{ translate('Show: Last 05 Order') }}</option>
                                <option value="10">{{ translate('Show: Last 10 Order') }}</option>
                                <option value="15">{{ translate('Show: Last 15 Order') }}</option>
                                <option value="20">{{ translate('Show: Last 20 Order') }}</option>
                            </select>
                        </form>
                    </div>

                    <!-- table -->
                    <div class="table-wrapper">
                        <table class="eg-table order-table table mb-0">
                            <thead>
                                <tr>
                                    <th>{{ translate('Date') }}</th>
                                    <th>{{ translate('Details') }}</th>
                                    <th>{{ translate('Amount') }}</th>
                                    <th>{{ translate('Wallet') }}</th>
                                    <th>{{ translate('Tax') }}</th>
                                    <th>{{ translate('Method') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($transactions->count() > 0)
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td data-label="Date">{{ dateFormat($transaction->created_at) }}</td>
                                            <td data-label="Details">{{ $transaction->payment_details }}</td>
                                            <td class="text-uppercase" data-label="Amount">
                                                {{ $transaction->currency . ' ' . $transaction->gateway_amount }}</td>
                                            <td data-label="Wallet">{{ currency_symbol() . $transaction->amount }}</td>
                                            <td data-label="Wallet">{{ currency_symbol() . $transaction->tax_amount }}</td>
                                            <td data-label="Method">{{ Ucfirst($transaction->payment_method) }}</td>
                                            <td data-label="Status">
                                                @if ($transaction->status == 1)
                                                    <span class="text-warning">{{ translate('Processing') }}</span>
                                                @elseif($transaction->status == 2)
                                                <span class="text-green">{{ translate('Completed') }}</span>@else<span
                                                        class="text-red">{{ translate('Cancel') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <h5 class="data-not-found">{{ translate('No Data Found') }}</h5>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination area -->
                    <div class="table-pagination">
                        <p> {{ translate('Showing') }} {{ $transactions->firstItem() }} {{ translate('to') }}
                            {{ $transactions->lastItem() }} {{ translate('of total') }}
                            {{ $transactions->total() }} {{ translate('entries') }}</p>
                        {!! $transactions->links('vendor.pagination.custom') !!}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
