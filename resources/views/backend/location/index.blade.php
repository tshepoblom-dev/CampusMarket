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
                    <input type="text" name="search" placeholder="Country Name Or Code...">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <form action="{{ route('country.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="eg-card product-card">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="username-input" value="{{ old('name') }}" name="name"
                            placeholder="{{ translate('Enter Name') }}">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-inner mb-35">
                        <label>{{ translate('Code') }} <span class="text-danger">*</span></label>
                        @php
                            $languagesArray = \App\Models\Location::whereNull('country_id')
                                ->whereNull('state_id')
                                ->pluck('country_code')
                                ->toarray();
                        @endphp
                        <select id="language_code" class="form-control js-example-basic-single mb-2 mb-md-0"
                            name="country_code">
                            <option value="">{{ translate('Select Option') }}</option>
                            @foreach (\File::files(public_path('assets/img/flags')) as $path)
                                @if (!in_array(pathinfo($path)['filename'], $languagesArray))
                                    <option value="{{ pathinfo($path)['filename'] }}"
                                        {{ old('country_code') == pathinfo($path)['filename'] ? 'selected' : '' }}>
                                        {{ strtoupper(pathinfo($path)['filename']) }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('country_code')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="button-group mt-15 text-center  ">
                        <input type="submit" class="eg-btn btn--green back-btn me-3" value="{{ translate('Save') }}">
                    </div>
                </div>
            </div>


        </div>
    </form>
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Name') }}</th>
                            <th>{{ translate('Flag') }}</th>
                            <th>{{ translate('Code') }}</th>
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $key => $country)
                            <tr>
                                <td data-label="S.N">{{ ($countries->currentpage() - 1) * $countries->perpage() + $key + 1 }}
                                </td>
                                <td data-label="Name">{{ $country->name }}</td>
                                <td>
                                    @if ($country->country_code)
                                        <img src="{{ asset('assets/img/flags/' . $country->country_code . '.png') }}"
                                            alt="{{ $country->name }}" width="20">
                                    @endif
                                </td>
                                <td data-label="Country Code">{{ $country->country_code }}</td>
                                <td data-label="Action">
                                    <div
                                        class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                        <a href="{{ route('state.create', $country->id) }}"
                                            title="{{ translate('State') }}" class="eg-btn account--btn"><i
                                                class="bi bi-info-lg"></i></i></a>
                                        <a href="{{ route('country.edit', $country->id) }}"
                                            title="{{ translate('Edit') }}" class="eg-btn add--btn"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <form method="POST" action="{{ route('country.delete', $country->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="eg-btn delete--btn show_confirm"
                                                data-toggle="tooltip" title="{{ translate('Delete') }}"><i
                                                    class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $countries->links() !!}
        </div>
    @endpush
@endsection
