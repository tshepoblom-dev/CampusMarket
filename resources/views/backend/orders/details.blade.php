@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35 g-4">
        <div class=" col-md-3">
            <div class="page-title text-md-start text-center">
                <h4>{{ $page_title }}</h4>
            </div>
        </div>
        <div
            class="col-md-9 d-flex justify-content-md-end justify-content-center flex-row align-items-center flex-wrap gap-4">
            @if ($order->type == 3)
                <form class="status-form" action="{{ route('order.change.status') }}" method="post">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="form-inner">
                        <select class="js-example-basic-single status_id" name="status_id">
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>
                                {{ translate('Processing') }}</option>
                            <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>{{ translate('On hold') }}
                            </option>
                            <option value="6" {{ $order->status == 6 ? 'selected' : '' }}>{{ translate('Delivered') }}
                            </option>
                            <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>
                                {{ translate('Completed') }}</option>
                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>
                                {{ translate('Cancelled') }}</option>
                            <option value="7" {{ $order->status == 7 ? 'selected' : '' }}>
                                {{ translate('Refunded') }}</option>
                        </select>
                    </div>
                </form>
            @endif
            <a href="{{ $order->type == 2 ? route('bidding.list') : route('order.list') }}"
                class="eg-btn btn--primary back-btn"> <img src="{{ asset('backend/images/icons/back.svg') }}"
                    alt="{{ translate('Go Back') }}"> {{ translate('Go Back') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="eg-card product-card printArea" id="printArea">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="logo-and-invoice-info">
                            <div class="company-logo">
                                @if (fileExists('assets/logo/', get_setting('invoice_logo')) != false)
                                    <img src="{{ asset('assets/logo/' . get_setting('invoice_logo')) }}" alt="Invoice Logo"
                                        height="100">
                                @else
                                    <img src="{{ asset('assets/logo/invoice-logo.png') }}" alt="Invoice Logo"
                                        height="100">
                                @endif
                            </div>
                            <div class="invoice-info">
                                <b>{{ translate('Invoice Number') }} {{ '#' . $order->order_number }}</b><br>
                                <b>{{ translate('Date') }}:</b> {{ dateFormat($order->created_at) }}<br>
                                <b>{{ translate('Payment Method') }}:</b>
                                {{ ucfirst($order->wallets[0]->payment_method ?? '') }}<br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bill-info">
                            <div class="invoice-col">
                                <span>{{ translate('From') }}</span>
                                <address>
                                    <h5><strong class="company-name">{{ get_setting('company_name') }}</strong></h5>
                                    <p>{{ get_setting('company_address') }}</p>
                                    <p><span>{{ translate('Phone') }}:</span>
                                        {{ get_setting('company_phone1') ?? get_setting('company_phone2') }}</p>
                                    <p> <span>{{ translate('Email') }}:</span>
                                        {{ get_setting('company_email1') ?? get_setting('company_email2') }}</p>
                                </address>
                            </div>

                            <div class="invoice-col">
                                <span>{{ translate('Billing To') }}</span>
                                <address>
                                    <p><strong
                                            class="company-name">{{ $order->billing_first_name . ' ' . $order->billing_last_name }}</strong>
                                    </p>
                                    <p>{{ $order->billing_address ?? '' }}{{ ', ' . $order->billing_cities->name ?? '' }}{{ ', ' . $order->billing_states->name ?? '' }}{{ ', ' . $order->billing_post_code ?? '' }}{{ ', ' . $order->billing_countries->name ?? '' }}
                                    </p>
                                    <p><span>{{ translate('Phone') }}:</span> {{ $order->billing_phone ?? '' }}</p>
                                    <p><span>{{ translate('Email') }}:</span> {{ $order->billing_email ?? '' }}</p>
                                </address>
                            </div>
                            @if ($order->shipping_first_name && $order->shipping_last_name && $order->shipping_address)
                                <div class="invoice-col">
                                    <span>{{ translate('Shipping To') }}</span>
                                    <address>
                                        <p><strong
                                                class="company-name">{{ $order->shipping_first_name . ' ' . $order->shipping_last_name }}</strong>
                                        </p>
                                        <p> {{ $order->shipping_address ?? '' }}{{ ', ' . $order->shipping_cities->name ?? '' }}{{ ', ' . $order->shipping_states->name ?? '' }}{{ ', ' . $order->shipping_post_code ?? '' }}{{ ', ' . $order->shipping_countries->name ?? '' }}
                                        </p>
                                        <p><span>{{ translate('Phone') }}:</span> {{ $order->shipping_phone ?? '' }}</p>
                                        <p><span>{{ translate('Email') }}:</span> {{ $order->shipping_email ?? '' }}</p>
                                    </address>
                                </div>
                            @endif
                        </div>


                    </div>
                    <div class="row mt-3">
                        <div class="col-12 table-responsive">
                            <table class="eg-table table table-striped invoice-table">
                                <thead>
                                    <tr>
                                        <th width="50%">{{ translate('Product') }}</th>
                                        <th width="10%">{{ translate('Qty') }}</th>
                                        <th width="20%">
                                            {{ $order->type == 2 ? translate('Bid Price') : translate('Price') }}</th>
                                        <th width="20%">{{ translate('Subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-label="Product">{{ $order->products->getTranslation('name', $lang) }}</td>
                                        <td data-label="Qty">{{ $order->quantity }}</td>
                                        <td data-label="Price">
                                            {{ currency_symbol() }}{{ $order->type == 2 ? $order->bid_amount : $order->products->sale_price ?? $order->products->price }}
                                        </td>
                                        <td data-label="Subtotal">{{ currency_symbol() . $order->amount }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td rowspan="3" colspan="2"><strong>{{ translate('Note') }}:</strong>
                                            {{ $order->message }}</td>
                                        <td data-label="Subtotal">{{ translate('Subtotal') }}</td>
                                        <td data-label="Subtotal">{{ currency_symbol() . $order->amount }}</td>
                                    </tr>
                                    <tr>
                                        <td data-label="Tax">{{ translate('Tax') }} ({{ get_setting('tax_rate') }}%)</td>
                                        <td data-label="Tax">{{ currency_symbol() . $order->tax_amount }}</td>
                                    </tr>
                                    <tr class="total">
                                        <td data-label="Total">{{ translate('Total') }}</td>
                                        <td data-label="Total">
                                            {{ currency_symbol() }}{{ $order->amount + $order->tax_amount }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="row mb-25">
            <div class="col-12">
                <button class="eg-btn btn--green" onclick="printDiv()"><i class="bi bi-printer"></i>
                    {{ translate(' Print Invoice') }}</button>
                <button class="eg-btn btn--primary" onclick="createPDF('{{ $order->order_number }}')">
                    {{ translate(' Download Invoice') }}</button>
            </div>
        </div>
    @endsection
