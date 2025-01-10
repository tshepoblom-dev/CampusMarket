<?php
$limit = 3;
$orderBy = 'asc';
if (isset($singelWidgetData->widget_content)) {
    $widgetContent = $singelWidgetData->getTranslation('widget_content');
    $limit = isset($widgetContent['display_per_page']) ? $widgetContent['display_per_page'] : 9;
    $orderBy = isset($widgetContent['order_by_blogs']) ? $widgetContent['order_by_blogs'] : 'asc';
}
$merchants = merchants('', $perPage = $limit, $orderBy);
?>

<!-- ========== inner-page-banner end ============= -->
<div class="blog-section pt-120">

    <div class="container">
        @if ($merchants->count() > 0)
            <div class="row d-flex justify-content-center g-4">
                @foreach ($merchants as $key => $merchant)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10">
                        <div class="single-blog-style1 wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="single-shop-card">
                                <div class="cover-img">
                                    @if (fileExists('uploads/shop/', $merchant?->shop?->cover_img) != false && $merchant->shop?->cover_img != null)
                                        <img src="{{ asset('uploads/shop/' . $merchant->shop->cover_img) }}"
                                            alt="Shop Logo">
                                    @else
                                        <img src="{{ asset('uploads/author-cover-placeholder.webp') }}" alt="Shop Logo">
                                    @endif

                                </div>
                                <div class="single-shop-content">
                                    <div class="card-action  justify-content-sm-between">
                                        <h4>{{ $merchant->shop->name }}</h4>
                                        <p><span>{{ translate('Email') }}:</span>{{ $merchant->email }}</p>
                                        <p><span>{{ translate('Total Product') }}:</span>
                                            {{ $merchant->active_products_count }}</p>

                                        @if ($merchant->address)
                                            <p><span>{{ translate('Address') }}:</span> {{ $merchant->address }}</p>
                                        @endif

                                    </div>
                                    <a class="profile-img" href="{{ url('shop/' . $merchant->shop->slug) }}"
                                        target="_blank">
                                        @if (fileExists('uploads/users', $merchant->image) != false && $merchant->image != null)
                                            <img alt="image" src="{{ asset('uploads/users/' . $merchant->image) }}">
                                        @else
                                            <img alt="image" src="{{ asset('uploads/users/user.png') }}">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="details-btn">
                                <a href="{{ url('shop/' . $merchant->shop->slug) }}" target="_blank"><i
                                        class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                {!! $merchants->links('vendor.pagination.custom') !!}
            </div>
        @else
            <h2 class="text-center">{{ translate('No Data Found') }}</h2>
        @endif
    </div>
</div>
