@extends('frontend.template-'.selectedTheme().'.partials.master')
    @section('content')
    @include('frontend.template-'.selectedTheme().'.breadcrumb.breadcrumb')
    <div class="live-auction-section pt-120">
        <img alt="image" src="{{asset('frontend/images/bg/section-bg.png')}}" class="img-fluid section-bg-top" >
        <img alt="image" src="{{asset('frontend/images/bg/section-bg.png')}}" class="img-fluid section-bg-bottom" >
        <div class="container">
            <div class="row gy-4 mb-60 d-flex justify-content-center">
                @if($live_auctions->count() > 0)
                <input type="hidden" id="live_limit" value="{{$live_auctions->count()}}">
                @foreach($live_auctions as $key=>$productItem)
                <div class="col-lg-4 col-md-6 col-sm-10 ">
                    @include('frontend.template-'.selectedTheme().'.partials.live_auction')
                </div>
                @endforeach
                @else
                <h2 class="text-center">{{translate('No Data Found')}}</h2>
                @endif

            </div>
            <div class="row g-4">
            {!! $live_auctions->links('vendor.pagination.custom') !!}
            </div>
        </div>
    </div>
    @include('frontend.template-'.selectedTheme().'.partials.fun_facts_section')
    @endsection
