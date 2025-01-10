@php
    $limit = 10;
    $orderBy = 'asc';
    if (isset($singelWidgetData->widget_content)) {
        $widgetContent = $singelWidgetData->getTranslation('widget_content');
        $limit = isset($widgetContent['total_display_categories']) ? $widgetContent['total_display_categories'] : 10;
        $orderBy = isset($widgetContent['category_order_type']) ? $widgetContent['category_order_type'] : 'asc';
    }
    $categoryList = \App\Models\Category::getAllCategory($limit, $orderBy);
    $countCategory = count($categoryList);
    if ($countCategory > 6) {
        $countCategory = 3;
    }
@endphp
@if ($categoryList->count() > 0)
    <div class="category-section pt-120">
        <div class="container position-relative">
            <div class="row d-flex justify-content-center">
                <div class="swiper category1-slider">
                    <div class="swiper-wrapper">
                        @foreach ($categoryList as $category)
                            <div class="swiper-slide">
                                <div class="eg-card category-card1 wow animate fadeInDown" data-wow-duration="1500ms"
                                    data-wow-delay="200ms">
                                    <div class="cat-icon">
                                        <img src="{{ asset('uploads/category/' . $category->image) }}"
                                            alt="{{ $category->name }}" width="60" height="60">
                                    </div>
                                    <a href="{{ url('category/' . $category->slug) }}">
                                        <h5>{{ $category->getTranslation('name') }}</h5>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="slider-arrows text-center d-xl-flex d-none  justify-content-end">
                <div class="category-prev1 swiper-prev-arrow" tabindex="0" role="button" aria-label="Previous slide">
                    <i class='bx bx-chevron-left'></i>
                </div>
                <div class="category-next1 swiper-next-arrow" tabindex="0" role="button" aria-label="Next slide"> <i
                        class='bx bx-chevron-right'></i></div>
            </div>
        </div>
    </div>
@endif
