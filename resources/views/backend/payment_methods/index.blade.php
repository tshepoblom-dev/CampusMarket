@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Image') }}</th>
                            <th>{{ translate('Method') }}</th>
                            <th>{{ translate('Mode') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payment_methods as $key => $payment_method)
                            <tr>
                                <td data-label="S.N">
                                    {{ ($payment_methods->currentpage() - 1) * $payment_methods->perpage() + $key + 1 }}</td>
                                <td data-label="Logo">
                                    @if (!empty($payment_method->logo))
                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->logo) }}"
                                            alt="{{ $payment_method->method_name }}" height="40">
                                    @else
                                        <img src="{{ asset('uploads/payment_methods/' . $payment_method->default_logo) }}"
                                            alt="{{ $payment_method->method_name }}" height="40">
                                    @endif
                                </td>
                                <td data-label="Method" class="text-capitalize">{{ $payment_method->method_name }}</td>
                                <td data-label="Mode">
                                    @if ($payment_method->mode == 1)
                                    <button class="eg-btn orange-light--btn">Sandbox</button>@else<button
                                            class="eg-btn green-light--btn">Live</button>
                                    @endif
                                </td>
                                <td data-label="Status">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input flexSwitchCheckMethod" type="checkbox"
                                            data-activations-status="{{ $payment_method->status }}"
                                            data-method-id="{{ $payment_method->id }}"
                                            id="flexSwitchCheckMethod{{ $payment_method->id }}"
                                            @if ($key == 0) disabled @endif
                                            {{ $payment_method->status == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td data-label="Option">
                                    <div
                                        class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                        <a href="javascript:void(0)" data-toggle="tooltip"
                                            data-method_id="{{ $payment_method->id }}" data-original-title="Edit"
                                            class="eg-btn add--btn editPaymentMethods">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- <button class="eg-btn delete--btn"><i class="bi bi-trash"></i></button> -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('backend.payment_methods.modal')

    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $payment_methods->links() !!}
        </div>
    @endpush
@endsection
