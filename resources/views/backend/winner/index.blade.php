@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="col-md-3">
            <div class="page-title text-md-start text-center">
                <h4>{{ $page_title ?? '' }}</h4>
            </div>
        </div>
        <div
            class="col-md-9 text-md-end text-center d-flex justify-content-md-end justify-content-center flex-row align-items-center flex-wrap gap-4">
            <form action="" method="get">
                <div class="input-with-btn d-flex jusify-content-start align-items-strech">
                    <input type="text" name="search" placeholder="Product Name...">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table category-table">
                    <thead>
                        <tr>
                            <th>{{ translate('Order Number') }}</th>
                            <th>{{ translate('Date') }}</th>
                            <th>{{ translate('Customer Name') }}</th>
                            <th>{{ translate('Email / Phone') }}</th>
                            <th>{{ translate('Product') }}</th>
                            <th>{{ translate('Bid Amount') }}</th>
                            <th>{{ translate('Payment Status') }}</th>
                            <th>{{ translate('Order Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($winners->count() > 0)
                            @foreach ($winners as $key => $winner)
                                <tr>
                                    <td data-label="Order Number">{{ $winner->order_number }}</td>
                                    <td data-label="Date"><b>{{ dateFormat($winner->created_at) }}</b></td>

                                    <td data-label="Bidding">
                                        <a href="{{ route('customer.view', $winner->user_id) }}" target="_blank">
                                            <b>
                                                {{ $winner->users->fname ? $winner->users->fname . ' ' . $winner->users->lname : '' }}</b></a>
                                    </td>
                                    <td data-label="Email / Phone">
                                        <a href="mailto:{{ $winner->users->email }}"> {{ $winner->users->email }}</a><br>
                                        <a href="tel:{{ $winner->users->phone }}"
                                            class="phone">{{ $winner->users->phone }}</a>
                                    </td>
                                    <td data-label="Product"><a
                                            href="{{ route('products.details', $winner->products->id) }}"
                                            target="_blank">{{ $winner->products->getTranslation('name') }}</a></td>
                                    <td data-label="Bid Amount">{{ currency_symbol() . $winner->bid_amount }}</td>

                                    <td data-label="Payment Status">
                                        @if ($winner->payment_status == 3)
                                            <button class="eg-btn green-light--btn">{{ translate('Paid') }}</button>
                                        @elseif($winner->payment_status == 2)
                                            <button class="eg-btn red-light--btn">{{ translate('Unpaid') }}</button>
                                        @elseif($winner->payment_status == 1)
                                            <button class="eg-btn orange-light--btn">{{ translate('Partials') }}</button>
                                        @endif
                                    </td>

                                    <td data-label="Action">
                                        <form action="{{ route('order.change.status') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $winner->id }}">
                                            @if ($winner->status == 2 || $winner->status == 4)
                                                <input type="hidden" name="status_id" value="8">
                                                <button type="submit" data-status="{{ $winner->status }}"
                                                    class="eg-btn orange-light--btn shipped_delivered_confirm">{{ translate('Mark as Shipped') }}</button>
                                            @elseif($winner->status == 8)
                                                <input type="hidden" name="status_id" value="6">
                                                <button type="submit" data-status="{{ $winner->status }}"
                                                    class="eg-btn primary-light--btn shipped_delivered_confirm">
                                                    {{ translate('Mark as Delivered') }}</button>
                                            @elseif($winner->status == 6)
                                                <button class="eg-btn green-light--btn"
                                                    disabled>{{ translate('Delivered') }}</button>
                                            @else
                                                <button class="eg-btn green-light--btn"
                                                    disabled>{{ translate('Delivered') }}</button>
                                            @endif

                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">
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
            {!! $winners->links() !!}
        </div>
    @endpush
@endsection
