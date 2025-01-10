@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35 g-4">
        <div class="col-md-4">
            <div class="page-title text-md-start text-center">
                <h4>{{ $page_title ?? '' }}</h4>
            </div>
        </div>
        <div class="col-md-8 text-end">
            @if ($productSingle->sale_type == 1 && $productSingle->status != 5)
                <form class="d-inline" method="POST" action="{{ route('bids.closed', $productSingle->id) }}">
                    @csrf
                    <button type="submit" class="eg-btn btn--green back-btn bids_close"> <img
                            src="{{ asset('backend/images/icons/power.svg') }}" alt="{{ translate('Bid Close') }}"
                            width="15"> {{ translate('Bid Close') }}</button>
                </form>
            @endif
            <a href="{{ route('products.list') }}" class="eg-btn btn--primary back-btn"> <img
                    src="{{ asset('backend/images/icons/back.svg') }}" alt="{{ translate('Go Back') }}">
                {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="eg-card prod-details-card">
                @if ($productSingle->status == 1)
                    <a href="#" class="eg-badge green live">{{ translate('Live') }}</a>
                @elseif($productSingle->status == 2)
                    <a href="#" class="eg-badge orange live">{{ translate('Draft') }}</a>
                @elseif($productSingle->status == 3)
                    <a href="#" class="eg-badge orange live">{{ translate('Pending') }}</a>
                @elseif($productSingle->status == 4)
                    <a href="#" class="eg-badge red live">{{ translate('Inactive') }}</a>
                @else
                    <a href="#" class="eg-badge red live">{{ translate('Closed') }}</a>
                @endif
                <a href="#" class="eg-badge orange vehicles">{{ $productSingle->categories->name ?? '' }}</a>
                <div class="prod-details-img p-3 mt-5">
                    <img src="{{ asset('uploads/products/features/' . $productSingle->features_image) }}" width="200"
                        alt="{{ translate('Product Image') }}">
                </div>
                <div class="prod-content">
                    <h4>{{ $productSingle->getTranslation('name', $lang) }}</h4>
                    <p>{{ translate('Product ID') }}: {{ $productSingle->id }}</p>
                </div>
                @if ($productSingle->sale_type == 1)
                    @if ($productSingle->status != 4 || $productSingle->status != 5)
                        <div class="prod-countdown">
                            <h4>{{ translate('Bid Ending Time') }}</h4>
                            <input type="hidden" id="bid_end_time"
                                value="{{ date('M d, Y H:i:s', strtotime($productSingle->end_date)) }}">
                            <div class="prod-details-timer gap-3" id="timer1">
                                <div class="countdown-single">
                                    <h3 id="days1">00</h3>
                                    <span>{{ translate('Days') }}</span>
                                </div>
                                <div class="countdown-single">
                                    <h3 id="hours1">00</h3>
                                    <span>{{ translate('Hours') }}</span>
                                </div>
                                <div class="countdown-single">
                                    <h3 id="minutes1">00</h3>
                                    <span>{{ translate('Mins') }}</span>
                                </div>
                                <div class="countdown-single">
                                    <h3 id="seconds1">00</h3>
                                    <span>{{ translate('Secs') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="prod-details-btn">
                        <a href="#" class="eg-btn btn--primary prod-details-btn">{{ translate('Total Bids') }} :
                            <span>{{ $productSingle->bids->count() }}</span></a>
                    </div>
                @endif
            </div>
            @if ($productSingle->sale_type == 1)
                @if ($productSingle->bid_winners->count() > 0)
                    <div class="winner-card">
                        <div class="winner-header">
                            <h4>{{ translate('Winner') }}</h4>
                        </div>
                        <div class="winner-body">
                            @foreach ($productSingle->bid_winners as $winners)
                                <div class="winner-details-list winner-border mb-3">
                                    <li><a href="{{ route('customer.view', $winners->user_id) }}"><span>{{ translate('User Name') }}
                                                :</span><span
                                                class="username">{{ '@' . $winners->users->username }}</span></a></li>
                                    <li><a href="{{ route('customer.view', $winners->user_id) }}"><span>{{ translate('Winning Date') }}
                                                :</span><span>{{ dateFormat($winners->updated_at) }}</span></a>
                                    </li>
                                    <li><a href="{{ route('customer.view', $winners->user_id) }}"><span>{{ translate('Bid Price') }}
                                                :</span><span>{{ currency_symbol() . $winners->bid_amount }}</span></a>
                                    </li>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="col-lg-8">


            @if ($productSingle->sale_type == 1)

                <table class="eg-table table prod-details-table">
                    <thead>
                        <tr>
                            <th>{{ translate('User') }}</th>
                            <th>{{ translate('Email / Phone') }}</th>
                            <th>{{ translate('Bidding Price') }}</th>
                            <th>{{ translate('Bid Place Time') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Winner') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $bid_list = $productSingle->bids()->paginate(10);

                        @endphp
                        @if ($productSingle->bids->count() > 0)
                            @foreach ($bid_list as $bids)
                                <tr>
                                    <td data-label="User"><a href="{{ route('customer.view', $bids->user_id) }}"
                                            class="username">{{ '@' . $bids->users->username }}</a></td>
                                    <td data-label="Email / Phone"> <a
                                            href="mailto:{{ $bids->users->email }}">{{ $bids->users->email }}</a> <br><a
                                            href="tel:{{ $bids->users->phone }}"
                                            class="phone">{{ $bids->users->phone }}</a></td>
                                    <td data-label="Bidding Price">{{ currency_symbol() . $bids->bid_amount }}</td>
                                    <td data-label="Bid Place Time">
                                        <p>{{ dateFormat($bids->created_at) }}</p>
                                        <span class="time">{{ date('h.i A', strtotime($bids->created_at)) }}</span>
                                    </td>
                                    <td data-label="Status">
                                        @if ($bids->status == 1)
                                            <button
                                                class="eg-btn primary-light--btn">{{ translate('Processing') }}</button>
                                        @elseif($bids->status == 7)
                                            <button
                                            class="eg-btn red-light--btn">{{ translate('Refuned') }}</button>@else<button
                                                class="eg-btn green-light--btn">{{ translate('Winner') }}</button>
                                        @endif
                                    </td>

                                    <td data-label="Winner">
                                        @if ($productSingle->status != 4 || $productSingle->status != 5)
                                            <form method="POST" action="{{ route('bids.winner', $bids->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                        @endif
                                        <button type="submit"
                                            class="@if ($productSingle->status != 5) winner_confirm @elseif($productSingle->status == 5) rejected_bids @endif winner_btn"
                                            data-status="{{ $bids->status }}" data-toggle="tooltip"
                                            title="{{ translate('Win') }}"> <svg
                                                @if ($bids->status == 2) style="fill: #F59E0B!important;" @endif
                                                width="24" height="16" viewBox="0 0 24 16"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M7.69687 0.682812C7.36406 0.842187 7.18125 1.01094 7.03125 1.31094C6.77344 1.82656 6.8625 2.38906 7.275 2.81562L7.50469 3.05469L7.35469 3.47656C6.96094 4.57812 6.4125 5.68906 5.90156 6.41094C5.17031 7.44219 4.5 7.76562 3.77812 7.42344C3.25781 7.17969 2.59219 6.39687 2.05781 5.40312L1.80937 4.93437L1.95 4.84062C2.39531 4.52656 2.55469 4.22656 2.55469 3.71094C2.55469 3.17187 2.36719 2.83437 1.92656 2.57187C1.65 2.4125 1.125 2.375 0.810937 2.49219C0.309375 2.68437 0 3.14375 0 3.71094C0 4.25 0.248437 4.65312 0.740625 4.90156L0.91875 4.99062L2.14687 8.57656L3.375 12.1625V13.6859V15.2141L3.49687 15.3078L3.62344 15.4062H12H20.3766L20.5031 15.3078L20.625 15.2141V13.6859V12.1578L21.8578 8.5625C23.0719 5.00937 23.0859 4.9625 23.2312 4.91094C23.3109 4.88281 23.4656 4.77969 23.5781 4.68594C24.1406 4.20312 24.15 3.24687 23.5922 2.74531C23.3109 2.49219 23.0391 2.40312 22.6219 2.43125C22.1062 2.46406 21.7922 2.67031 21.5531 3.125C21.4078 3.40625 21.3984 3.99219 21.5344 4.26406C21.6328 4.46094 21.8344 4.69062 22.0453 4.83594L22.1719 4.92969L21.8719 5.43125C21.2953 6.39219 20.7328 7.02969 20.1891 7.35781C19.9125 7.52187 19.8234 7.55 19.5187 7.56875C19.1906 7.5875 19.1484 7.58281 18.8297 7.42344C18.3187 7.17031 17.7797 6.59375 17.2781 5.76406C17.025 5.3375 16.4484 4.11406 16.2422 3.55625L16.0641 3.07812L16.2891 2.88125C16.5984 2.60937 16.7344 2.30469 16.7344 1.88281C16.7297 1.16094 16.2469 0.65 15.525 0.603125C14.5922 0.542187 13.9219 1.4375 14.2312 2.3375C14.3203 2.60469 14.5781 2.91406 14.8172 3.03594C14.9156 3.08281 15 3.14375 15 3.1625C15 3.24219 14.7234 4.01562 14.5078 4.53125C13.6828 6.53281 12.8437 7.53125 11.9953 7.53125C11.2453 7.53125 10.3828 6.69219 9.50625 5.11719C9.25312 4.6625 8.85469 3.82812 8.67187 3.36406L8.58281 3.13437L8.73281 3.07344C8.81719 3.04062 8.9625 2.9375 9.06562 2.84375C9.57656 2.38437 9.61406 1.54062 9.15 1.01094C8.82187 0.635937 8.13281 0.48125 7.69687 0.682812ZM8.5125 1.55C8.73281 1.77031 8.7375 2.02344 8.52656 2.22969C8.20781 2.55312 7.6875 2.32812 7.6875 1.86875C7.6875 1.71406 7.8375 1.49844 7.9875 1.4375C8.19375 1.35312 8.34844 1.38594 8.5125 1.55ZM15.7781 1.55C15.9984 1.77031 16.0031 2.02344 15.7922 2.22969C15.4734 2.55312 14.9531 2.32812 14.9531 1.86875C14.9531 1.71406 15.1031 1.49844 15.2531 1.4375C15.4594 1.35312 15.6141 1.38594 15.7781 1.55ZM1.62187 3.37812C1.84219 3.59844 1.84219 3.82344 1.62187 4.04375C1.29375 4.37187 0.801562 4.16562 0.796875 3.70156C0.796875 3.54688 0.825 3.47656 0.942187 3.36406C1.14844 3.15312 1.40156 3.15781 1.62187 3.37812ZM23.0578 3.36406C23.3812 3.6875 23.1516 4.20312 22.6875 4.20312C22.4672 4.20312 22.2187 3.94062 22.2187 3.71094C22.2187 3.575 22.2562 3.5 22.3781 3.37812C22.5984 3.15781 22.8516 3.15312 23.0578 3.36406ZM8.34844 4.625C9.31875 6.67812 10.3359 7.89219 11.3812 8.23906C11.625 8.31875 11.7609 8.3375 12.1125 8.31875C12.4734 8.30469 12.5859 8.27656 12.8625 8.14531C13.7297 7.72812 14.6812 6.36875 15.3562 4.59219C15.4594 4.325 15.5484 4.10938 15.5625 4.10938C15.5766 4.10938 15.6469 4.26406 15.7219 4.45156C16.1672 5.5625 16.9406 6.84687 17.5266 7.44219C18.1734 8.09375 18.75 8.375 19.4531 8.375C20.0672 8.375 20.55 8.17812 21.1266 7.68594L21.375 7.47969L20.7844 9.20469C20.4609 10.1516 20.1422 11.0844 20.0766 11.2672L19.9594 11.6094H12H4.04062L3.92344 11.2672C3.85781 11.0844 3.55312 10.1844 3.23906 9.275L2.67187 7.62031L2.88281 7.80312C3.15937 8.04687 3.60937 8.2625 3.99375 8.33281C4.39687 8.40781 4.82812 8.3375 5.25 8.13594C5.65312 7.93437 6.30469 7.2875 6.69844 6.6875C7.04531 6.15781 7.60312 5.06562 7.85156 4.42812C7.95 4.175 8.03437 3.97344 8.03906 3.98281C8.04375 3.9875 8.18437 4.27812 8.34844 4.625ZM19.875 13.5078V14.6094H12H4.125V13.5078V12.4062H12H19.875V13.5078Z" />
                                            </svg></button>
                                        @if ($productSingle->status != 4 || $productSingle->status != 5)
                                            </form>
                                        @endif
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
            @else
                <table class="eg-table table prod-details-table">
                    <thead>
                        <tr>
                            <th>{{ translate('User') }}</th>
                            <th>{{ translate('Email / Phone') }}</th>
                            <th>{{ translate('Amount') }}</th>
                            <th>{{ translate('Time') }}</th>
                            <th width="150">{{ translate('Status') }}</th>
                            <th>{{ translate('View') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $bid_list = $productSingle->direct_sales()->paginate(10);
                        @endphp
                        @if ($productSingle->direct_sales->count() > 0)
                            @foreach ($bid_list as $sales)
                                <tr>
                                    <td data-label="User"><a href="{{ route('customer.view', $sales->user_id) }}"
                                            class="username">{{ '@' . $sales->users->username }}</a></td>
                                    <td data-label="Email / Phone"> <a
                                            href="mailto:{{ $sales->users->email }}">{{ $sales->users->email }}</a>
                                        <br><a href="tel:{{ $sales->users->phone }}"
                                            class="phone">{{ $sales->users->phone }}</a>
                                    </td>
                                    <td data-label="Amount">{{ currency_symbol() . $sales->amount }}</td>
                                    <td data-label="Time">
                                        <p>{{ date('d.m.Y', strtotime($sales->created_at)) }}</p>
                                        <span class="time">{{ date('h.i A', strtotime($sales->created_at)) }}</span>
                                    </td>
                                    <td data-label="Status">
                                        <form action="{{ route('order.change.status') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $sales->id }}">
                                            <div class="form-inner">
                                                <select class="js-example-basic-single status_id" name="status_id">
                                                    <option value="1" {{ $sales->status == 1 ? 'selected' : '' }}>
                                                        {{ translate('Processing') }}</option>
                                                    <option value="5" {{ $sales->status == 5 ? 'selected' : '' }}>
                                                        {{ translate('On hold') }}</option>
                                                    <option value="6" {{ $sales->status == 6 ? 'selected' : '' }}>
                                                        {{ translate('Delivered') }}</option>
                                                    <option value="4" {{ $sales->status == 4 ? 'selected' : '' }}>
                                                        {{ translate('Completed') }}</option>
                                                    <option value="3" {{ $sales->status == 3 ? 'selected' : '' }}>
                                                        {{ translate('Cancelled') }}</option>
                                                    <option value="7" {{ $sales->status == 7 ? 'selected' : '' }}>
                                                        {{ translate('Refunded') }}</option>
                                                </select>
                                            </div>
                                        </form>
                                    </td>

                                    <td data-label="View">
                                        <a class="eg-btn account--btn" href="{{ route('order.details', $sales->id) }}"><i
                                                class="bi bi-eye"></i></a>
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
            @endif
        </div>
    </div>
    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $bid_list->links() !!}
        </div>
    @endpush
@endsection
