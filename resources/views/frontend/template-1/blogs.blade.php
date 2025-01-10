<?php
$limit = 3;
$orderBy = 'asc';
if (isset($singelWidgetData->widget_content)) {
    $widgetContent = $singelWidgetData->getTranslation('widget_content');
    $limit = isset($widgetContent['display_per_page']) ? $widgetContent['display_per_page'] : 9;
    $orderBy = isset($widgetContent['order_by_blogs']) ? $widgetContent['order_by_blogs'] : 'asc';
}

$blogs = blog('', $perPage = $limit, $orderBy);

?>

<!-- ========== inner-page-banner end ============= -->
<div class="blog-section pt-120">
    <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
    <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
    <div class="container">
        @if ($blogs->count() > 0)
            <div class="row d-flex justify-content-center g-4">
                @foreach ($blogs as $key => $dataItem)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10">
                        <div class="single-blog-style1 wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="blog-img">
                                <a href="{{ url('blog/' . $dataItem->slug) }}" class="blog-date"><i
                                        class="bi bi-calendar-check"></i>{{ dateFormat($dataItem->created_at) }}</a>
                                <img alt="image" src="{{ asset('uploads/blog/' . $dataItem->image) }}">
                            </div>
                            <div class="blog-content">
                                <h5><a
                                        href="{{ url('blog/' . $dataItem->slug) }}">{{ $dataItem->getTranslation('title') }}</a>
                                </h5>
                                <div class="blog-meta">
                                    <div class="author">
                                        @if (fileExists('uploads/users', $dataItem->users?->image) != false && $dataItem->users?->image != null)
                                            <img alt="image"
                                                src="{{ asset('uploads/users/' . $dataItem->users->image) }}">
                                        @else
                                            <img alt="image" src="{{ asset('uploads/users/user.png') }}">
                                        @endif
                                        <a href="{{ url('blog/' . $dataItem->slug) }}"
                                            class="author-name">{{ $dataItem->users?->fname . ' ' . $dataItem->users?->lname }}</a>
                                    </div>
                                    <div class="comment">
                                        <img alt="image"
                                            src="{{ asset('frontend/images/icons/comment-icon.svg') }}">
                                        <a href="{{ url('blog/' . $dataItem->slug) }}"
                                            class="comment">{{ $dataItem->comments_count < 9 ? '0' . $dataItem->comments_count : $dataItem->comments_count }}
                                            {{ $dataItem->comments_count > 1 ? 'Comments' : 'Comment' }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="row">
                {!! prelaceScript( $blogs->links('vendor.pagination.custom')) !!}
            </div>
        @else
            <h2 class="text-center">{{ translate('No Data Found') }}</h2>
        @endif

    </div>
</div>
