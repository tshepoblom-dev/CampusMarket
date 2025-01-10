@if($funFactsDataItem)

<div class="about-us-counter pt-120">
    <div class="container">
        <div class="row g-4 d-flex justify-content-center">
            @foreach($funFactsDataItem['fun_facts'] as $key=>$funFactItem)
                <div class="col-lg-3 col-md-6 col-sm-10">
                    <div class="counter-single text-center d-flex flex-row hover-border1">
                        @if($funFactItem['img'])
                            <div class="counter-icon"> <img src="{{asset('uploads/fun_facts/'.$funFactItem['img'])}}"> </div>
                        @endif
                        <div class="coundown d-flex flex-column">
                            <h3 class="odometer" data-odometer-final="{{$funFactItem['number_count']}}"></h3>
                            <p>{{$funFactItem['title']}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif
