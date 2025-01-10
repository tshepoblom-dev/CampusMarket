@extends('frontend.template-'.$templateId.'.partials.master')
@section('content')
@include('frontend.template-'.$templateId.'.breadcrumb.breadcrumb')
<div class="live-auction-section pt-120">
        <img alt="image" src="{{asset('frontend/images/bg/section-bg.png')}}" class="img-fluid section-bg-top" >
        <img alt="image" src="{{asset('frontend/images/bg/section-bg.png')}}" class="img-fluid section-bg-bottom" >
        <div class="container">
            <div class="row gy-4 mb-60 d-flex justify-content-center">
                @if($live_auctions->count() > 0)
                <input type="hidden" id="live_limit" value="{{$live_auctions->count()}}">
                @foreach($live_auctions as $key=>$productItem)

                <div class="col-lg-4 col-md-6 col-sm-10 ">
                    @include('frontend.template-'.$templateId.'.partials.live_auction')
                </div>
                @endforeach
                @else
                <div class="col-lg-12 col-md-12 col-sm-12 ">
                    <h2 class="text-center">{{translate('No Data Found')}}</h2>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
