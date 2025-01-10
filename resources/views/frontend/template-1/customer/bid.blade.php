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
                            <select name="filter" onchange="this.form.submit()">
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
                                    <th>{{ translate('Image') }}</th>
                                    <th>{{ translate('Bidding Product') }}</th>
                                    <th>{{ translate('Bid Amount') }}</th>
                                    <th>{{ translate('Highest Bid') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th>{{ translate('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bidding->count() > 0)
                                    @foreach ($bidding as $bids)
                                        <tr>
                                            <td data-label="Image"><img alt="image"
                                                    src="{{ asset('uploads/products/features/' . $bids->products->features_image) }}"
                                                    class="img-fluid"></td>
                                            <td data-label="Bidding Product"> <a target="__blank"
                                                href="{{ url('product/' . $bids->products->slug) }}">{{ $bids->products->getTranslation('name') }}
                                            </a>
                                            </td>
                                            <td data-label="Bid Amount">{{ currency_symbol() . $bids->bid_amount }}</td>
                                            <td data-label="Highest Bid">
                                                {{ currency_symbol() . highest_bid($bids->product_id) }}</td>
                                            <td data-label="Status">
                                                <span
                                                    class="@if ($bids->status == 1) text-primary @elseif($bids->status == 2 || $bids->status == 4 || $bids->status == 6 || $bids->status == 8) text-green @elseif($bids->status == 7) text-red @endif">
                                                    @if ($bids->status == 1)
                                                        {{ translate('Processing') }}
                                                    @elseif($bids->status == 2)
                                                        {{ translate('Win') }}
                                                    @elseif($bids->status == 7)
                                                        {{ translate('Refunded') }}
                                                    @elseif($bids->status == 4)
                                                        {{ translate('Completed') }}
                                                    @elseif($bids->status == 8)
                                                        {{ translate('Shipped') }}
                                                    @elseif($bids->status == 6)
                                                        {{ translate('Delivered') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-label="Action">
                                                <button
                                                    class="eg-btn action-btn @if ($bids->status == 1) blue @elseif($bids->status == 2 || $bids->status == 4 || $bids->status == 6 || $bids->status == 8) green @elseif($bids->status == 7) red @endif"><a
                                                        href="{{ route('customer.order.details', $bids->id) }}"><img
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
                        <p> {{ translate('Showing') }} {{ $bidding->firstItem() }} to {{ $bidding->lastItem() }}
                            {{ translate('of total') }}
                            {{ $bidding->total() }} {{ translate('entries') }}</p>
                        {!! $bidding->links('vendor.pagination.custom') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
