@extends('backend.layouts.master')
              @section('content')
                <div class="row mb-35 g-4">
                    <div class="col-md-9">
                        <div class="page-title text-md-start text-center">
                            <h4>{{$page_title ?? ''}}</h4>
                        </div>    
                    </div>
                    <div class="col-md-3 text-md-end text-center d-flex justify-content-md-end justify-content-center flex-row align-items-center flex-wrap gap-4">
                        <a href="{{route('products.list')}}" class="eg-btn btn--primary back-btn"> <img src="{{asset('backend/images/icons/back.svg')}}" alt="{{ translate('Go Back') }}"> {{ translate('Go Back') }}</a>
                    </div>   
                </div>
                <div class="row">
                   <div class="col-12">
                    <div class="table-wrapper">
                        <table class="eg-table table customer-table">
                            <thead>
                                <tr>
                                    <th>{{ translate('S.N') }}</th>
                                    <th>{{ translate('Customer') }}</th>
                                    <th>{{ translate('Email / Phone') }}</th>
                                    <th>{{ translate('Rate') }}</th>
                                    <th>{{ translate('Review') }}</th>
                                    <th>{{ translate('Status') }}</th>
                                    <th>{{ translate('Date') }}</th>
                                    <th>{{ translate('Reply') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($productReviews->count() > 0)
                            @foreach($productReviews as $key => $productReview)
                                <tr>
                                    <td data-label="S.N">{{ ($productReviews->currentpage()-1) * $productReviews->perpage() + $key + 1 }}</td>
                                    <td data-label="Customer" class="text-start"><a href="{{route('customer.view', $productReview->users->id )}}">{{$productReview->users->fname.' '.$productReview->users->lname}}<br><span class="text-purple">{{'@'.$productReview->users->username}}</span></a></td>
                                    <td data-label="Email / Phone"> <a href="mailto:{{$productReview->users->email}}">{{$productReview->users->email}}</a> <br><a href="tel:{{$productReview->users->phone}}" class="phone">{{$productReview->users->phone}}</a></td>
                                    <td data-label="Rate">
                                        <ul class="rating-star">
                                    @switch($productReview->rate)
                                                                    @case(1)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        @break
                                                                
                                                                    @case(1.5)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-half"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        @break
                                                                    
                                                                    @case(2)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        @break
                                                                    
                                                                    @case(2.5)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-half"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        @break
                                                                
                                                                    @case(3)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        @break

                                                                    @case(3.5)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-half"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        @break

                                                                    @case(4)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star"></i></li>
                                                                        @break

                                                                    @case(4.5)
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-half"></i></li>
                                                                        @break
                                                                
                                                                    @default
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                        <li><i class="bi bi-star-fill"></i></li>
                                                                @endswitch
                                                                </ul>
                                    </td> 
                                    <td data-label="Review">{{$productReview->comments}}</td>
                                    <td data-label="Status">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input flexSwitchCheckProductReview" type="checkbox" data-activations-status="{{$productReview->status}}" data-product-review-id="{{$productReview->id}}" id="flexSwitchCheckProductReview{{$productReview->id}}" {{($productReview->status==1)?'checked':''}}>
                                        </div>
                                    </td>

                                    <td data-label="Date">
                                        <p class="mb-0">{{date('d.m.Y', strtotime($productReview->created_at))}}</p>
                                        <span class="time">{{date('h.i A', strtotime($productReview->created_at))}}</span>
                                    </td>
                                    <td data-label="Reply">
                                        @if($productReview->replies->count() > 0)
                                        <button type="button" class="eg-btn account--btn"><i class="bi bi-hand-thumbs-up"></i></button>
                                        @else
                                        <button type="button"  data-review_id="{{$productReview->id}}" data-product_id="{{$productReview->product_id}}" class="staticBackdropReview eg-btn add--btn" data-bs-toggle="modal" data-bs-target="#staticBackdropReview"><i class="bi bi-reply-all"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="10" data-label="Not Found"><h4>{{translate('No Data Found')}}</h4></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                   </div>
                </div>
                @include('backend.products.modal')
@push('footer')
<div class="d-flex justify-content-center custom-pagination">
    {!! $productReviews->links() !!}
</div>
@endpush
@endsection