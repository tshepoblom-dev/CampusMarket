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
                        <button type="button" class="eg-btn add-new-btn border-0" data-bs-toggle="modal"
                            data-bs-target="#paymentModal"><i class="bi bi-wallet2"></i>
                            {{ translate('Add Fund') }}</button>

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
                                    <th>{{ translate('Method') }}</th>
                                    <th>{{ translate('Transaction ID') }}</th>
                                    <th>{{ translate('Currency') }}</th>
                                    <th>{{ translate('Amount') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($deposits->count() > 0)
                                    @foreach ($deposits as $deposit)
                                        <tr>
                                            <td data-label="Date">{{ dateFormat($deposit->created_at) }}</td>
                                            <td data-label="Method">{{ Ucfirst($deposit->payment_method) }}</td>
                                            <td data-label="Transaction ID">{{ $deposit->transaction_id }}</td>
                                            <td class="text-uppercase" data-label="Currency">{{ $deposit->currency }}</td>
                                            <td data-label="Amount">{{ currency_symbol() . $deposit->amount }}</td>
                                            <td data-label="Status">
                                                @if ($deposit->status == 1)
                                                    <span class="text-warning">{{ translate('Processing') }}</span>
                                                @elseif($deposit->status == 2)
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
                        <p>{{ translate('Showing') }} {{ $deposits->firstItem() }} {{ translate('to') }}
                            {{ $deposits->lastItem() }} {{ translate('of total') }}
                            {{ $deposits->total() }} {{ translate('entries') }}</p>
                        {!! $deposits->links('vendor.pagination.custom') !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="balance-content order-details">
        @include('frontend.template-'.selectedTheme().'.partials.payment_modal')
    </div>
@endsection
