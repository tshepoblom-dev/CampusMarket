<div class="inner-banner">
        <div class="container">
            <h2 class="inner-banner-title wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s">{{$page_title ?? ''}}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('/')}}">{{translate('Home')}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$page_title ?? ''}}</li>
                </ol>
              </nav>
        </div>
    </div>