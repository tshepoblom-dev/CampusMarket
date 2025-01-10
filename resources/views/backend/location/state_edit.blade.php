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
                    <input type="text" name="search" placeholder="State Name...">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <a href="{{ url()->previous() }}" class="eg-btn btn--primary back-btn"><img src="http://127.0.0.1:8000/backend/images/icons/back.svg" alt="Go Back">Go Back</a>
        </div>
    </div>

    <form action="{{ route('state.update', $stateSingle->id) }}" method="post">
        <input name="_method" type="hidden" value="PATCH">
        @csrf
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="eg-card product-card">
                    <div class="form-inner mb-35">
                        <label>{{ translate('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="username-input" value="{{ old('name', $stateSingle->name) }}"
                            name="name" placeholder="{{ translate('Enter Name') }}">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="button-group mt-15 text-center  ">
                        <input type="submit" class="eg-btn btn--green back-btn me-3" value="{{ translate('Update') }}">
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
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $key => $state)
                            <tr>
                                <td data-label="S.N">{{ ($states->currentpage() - 1) * $states->perpage() + $key + 1 }}</td>
                                <td data-label="Name">{{ $state->name }}</td>
                                <td data-label="Action">
                                    <div
                                        class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                        <a href="{{ route('city.create', $state->id) }}" title="{{ translate('City') }}"
                                            class="eg-btn account--btn"><i class="bi bi-info-lg"></i></i></a>
                                        <a href="{{ route('state.edit', $state->id) }}" title="{{ translate('Edit') }}"
                                            class="eg-btn add--btn"><i class="bi bi-pencil-square"></i></a>
                                        <form method="POST" action="{{ route('state.delete', $state->id) }}">
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
            {!! $states->links() !!}
        </div>
    @endpush
@endsection
