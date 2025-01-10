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
                        <h3>{{ $title ?? '' }}</h3>
                        <form action="" method="get">
                            <select id="order-category" name="filter" onchange="this.form.submit()">
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
                                    <th>{{ translate('Order ID') }}</th>
                                    <th>{{ translate('Product Name') }}</th>
                                    <th>{{ translate('Quantity') }}</th>
                                    <th>{{ translate('Price') }}</th>
                                    <th>{{ translate('Order Date') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th>{{ translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($purchases->count() > 0)
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td data-label="Order ID">{{ $purchase->id }}</td>
                                            <td data-label="Product Name">{{ $purchase->products->getTranslation('name') }}
                                            </td>
                                            <td data-label="Quantity">{{ $purchase->quantity }}</td>
                                            <td data-label="Price">{{ currency_symbol() . $purchase->amount }}</td>
                                            <td data-label="Order Date">{{ dateFormat($purchase->created_at) }}</td>
                                            <td data-label="Status">
                                                <span
                                                    class="@if ($purchase->status == 1) text-primary @elseif($purchase->status == 3 || $purchase->status == 7) text-red @elseif($purchase->status == 4 || $purchase->status == 6) text-green @elseif($purchase->status == 5) text-warning @endif">
                                                    @if ($purchase->status == 1)
                                                        {{ translate('Processing') }}
                                                    @elseif($purchase->status == 3)
                                                        {{ translate('Cancelled') }}
                                                    @elseif($purchase->status == 4)
                                                        {{ translate('Completed') }}
                                                    @elseif($purchase->status == 5)
                                                        {{ translate('On hold') }}
                                                    @elseif($purchase->status == 6)
                                                        {{ translate('Delivered') }}
                                                    @elseif($purchase->status == 7)
                                                        {{ translate('Refunded') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-label="Action">
                                                <button
                                                    class="eg-btn action-btn @if ($purchase->status == 1) blue @elseif($purchase->status == 4 || $purchase->status == 6) green @elseif($purchase->status == 3 || $purchase->status == 7) red @elseif($purchase->status == 5) orange @endif"><a
                                                        href="{{ route('customer.order.details', $purchase->id) }}"><img
                                                            alt="image"
                                                            src="{{ asset('frontend/images/icons/aiction-icon.svg') }}"></a></button>
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
                        <p> {{ translate('Showing') }} {{ $purchases->firstItem() }} to {{ $purchases->lastItem() }}
                            {{ translate('of total') }}
                            {{ $purchases->total() }} {{ translate('entries') }}</p>
                        {!! $purchases->links('vendor.pagination.custom') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
