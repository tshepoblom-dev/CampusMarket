@extends('frontend.template-'.$templateId.'.partials.master')
@section('content')
    @include('frontend.template-'.$templateId.'.breadcrumb.breadcrumb')

    <div class="blog-details-section pt-120">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-top">
        <img alt="image" src="{{ asset('frontend/images/bg/section-bg.png') }}" class="img-fluid section-bg-bottom">
        <div class="container">
            <div class="row gy-5">
                <div class="col-lg-8">
                    <div class="blog-details-single">

                        <div class="blog-img">
                            @if (fileExists('uploads/blog/', $blog_details->image) != false && $blog_details->image != null)
                                <img alt="image" src="{{ asset('uploads/blog/' . $blog_details->image) }}"
                                    class="img-fluid wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            @else
                                <img alt="image" src="{{ asset('uploads/author-cover-placeholder.webp') }}"
                                    class="img-fluid wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                            @endif
                        </div>
                        <ul class="blog-meta gap-2">
                            <li><a href="#"><img alt="image"
                                        src="{{ asset('frontend/images/icons/calendar.svg') }}">{{ translate('Date') }}:
                                    {{ dateFormat($blog_details->created_at) }}</a></li>
                            <li><a href="#"><img alt="image"
                                        src="{{ asset('frontend/images/icons/tags.svg') }}">{{ $blog_details->blog_categories->name }}</a>
                            </li>
                            <li><a href="#"><img
                                        alt="image"src="{{ asset('frontend/images/icons/admin.svg') }}">{{ translate('Posted by') }}
                                    {{ $blog_details->users->username }}</a></li>
                        </ul>
                        <h3 class="blog-title mb-3">{{ $blog_details->getTranslation('title') }}</h3>

                        <div class="blog-content">
                            @php
                                $description= prelaceScript(html_entity_decode($blog_details->getTranslation('description')))
                            @endphp
                            {!! clean($description) !!}
                        </div>
                        @php
                            $tags = explode(',', $blog_details->tags);
                        @endphp

                        <div class="blog-tag">
                            <div class="row g-3">
                                @if ($tags)
                                    <div
                                        class="col-md-8 d-flex justify-content-md-start justify-content-center align-items-center">
                                        <h6>{{ translate('Post Tag') }}:</h6>
                                        <ul class="tag-list">
                                            @foreach ($tags as $tag)
                                                <li><a href="{{ url('blog/tag/' . $tag) }}">{{ $tag }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div
                                    class="col-md-4 d-flex justify-content-md-end justify-content-center align-items-center">
                                    <ul class="share-social gap-3">
                                        <li><a target="_blank"
                                                href="https://www.facebook.com/sharer.php?u={{ url('blog/' . $blog_details->slug) }}"><i
                                                    class="bx bxl-facebook"></i></a></li>
                                        <li><a target="_blank"
                                                href="https://twitter.com/intent/tweet?url={{ url('blog/' . $blog_details->slug) }}&text={{ $blog_details->title }}"><i
                                                    class="bx bxl-twitter"></i></a></li>
                                        <li><a target="_blank"
                                                href="https://www.linkedin.com/shareArticle?url={{ url('blog/' . $blog_details->slug) }}&title={{ $blog_details->title }}"><i
                                                    class="bx bxl-linkedin"></i></a></li>
                                        <li><a target="_blank"
                                                href="https://www.pinterest.com/pin/create/bookmarklet/?url=={{ url('blog/' . $blog_details->slug) }}"><i
                                                    class="bx bxl-pinterest"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="blog-comment">
                            <div class="blog-widget-title">
                                <h4>{{ $comments->count() > 1 ? 'Comments' : 'Comment' }}
                                    ({{ $comments->count() < 9 ? '0' . $comments->count() : $comments->count() }})</h4>
                                <span></span>
                            </div>
                            <ul class="comment-list mb-50">
                                @if ($comments->count() > 0)
                                    @foreach ($comments as $comment)
                                        <li>
                                            <div class="comment-box">
                                                <div
                                                    class="comment-header d-flex justify-content-between align-items-center">
                                                    <div class="author d-flex flex-wrap">
                                                        @if (fileExists('uploads/users', $comment?->users?->image) != false && $comment?->users?->image != null)
                                                            <img alt="image"
                                                                src="{{ asset('uploads/users/' . $comment->users->image) }}">
                                                        @else
                                                            <img alt="image"
                                                                src="{{ asset('uploads/users/user.png') }}">
                                                        @endif
                                                        <h5><a href="#">
                                                                @if ($comment?->users && $comment?->users?->fname)
                                                                    {{ $comment?->users?->fname . ' ' . $comment?->users?->lname }}
                                                                @elseif($comment?->users && $comment->users?->username)
                                                                    {{ $comment?->users?->username }}
                                                                @else
                                                                    {{ $comment?->user_name }}
                                                                @endif
                                                            </a></h5><span class="commnt-date">
                                                            {{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <a href="#" class="commnt-reply"
                                                        data-comment_id="{{ $comment->id }}"><i
                                                            class="bi bi-reply"></i></a>
                                                </div>
                                                <div class="comment-body">
                                                    <p class="para">{{ $comment->comment }}</p>
                                                </div>
                                            </div>
                                            @if (count($comment->replies) > 0)
                                                <ul class="comment-reply">
                                                    @foreach ($comment->replies as $reply)
                                                        <li>
                                                            <div class="comment-box">
                                                                <div
                                                                    class="comment-header d-flex justify-content-between align-items-center">
                                                                    <div class="author d-flex flex-wrap">
                                                                        @if (fileExists('uploads/users', $reply?->users?->image) != false && $reply?->users?->image != null)
                                                                            <img alt="image"
                                                                                src="{{ asset('uploads/users/' . $reply->users->image) }}">
                                                                        @else
                                                                            <img alt="image"
                                                                                src="{{ asset('uploads/users/user.png') }}">
                                                                        @endif
                                                                        <h5><a href="#">
                                                                                @if ($reply->users && $reply->users->fname)
                                                                                    {{ $reply->users->fname . ' ' . $reply->users->lname }}
                                                                                @elseif($reply->users && $reply->users->username)
                                                                                    {{ $reply->users->username }}
                                                                                @else
                                                                                    {{ $reply->user_name }}
                                                                                @endif
                                                                            </a>
                                                                        </h5><span class="commnt-date">
                                                                            {{ $reply->created_at->diffForHumans() }}</span>
                                                                    </div>
                                                                    <a href="#" class="commnt-reply"
                                                                        data-comment_id="{{ $reply->id }}"><i
                                                                            class="bi bi-reply"></i></a>
                                                                </div>
                                                                <div class="comment-body">
                                                                    <p class="para">{{ $reply->comment }}</p>
                                                                </div>
                                                            </div>
                                                            @if (count($reply->replies) > 0)
                                                                <ul class="comment-reply">
                                                                    @foreach ($reply->replies as $reply2)
                                                                        <li>
                                                                            <div class="comment-box">
                                                                                <div
                                                                                    class="comment-header d-flex justify-content-between align-items-center">
                                                                                    <div class="author d-flex flex-wrap">
                                                                                        @if (fileExists('uploads/users', $reply2?->users?->image) != false && $reply2?->users?->image != null)
                                                                                            <img alt="image"
                                                                                                src="{{ asset('uploads/users/' . $reply2->users->image) }}">
                                                                                        @else
                                                                                            <img alt="image"
                                                                                                src="{{ asset('uploads/users/user.png') }}">
                                                                                        @endif
                                                                                        <h5><a href="#">
                                                                                                @if ($reply2->users && $reply2->users->fname)
                                                                                                    {{ $reply2->users->fname . ' ' . $reply2->users->lname }}
                                                                                                @elseif($reply2->users && $reply2->users->username)
                                                                                                    {{ $reply2->users->username }}
                                                                                                @else
                                                                                                    {{ $reply2->user_name }}
                                                                                                @endif
                                                                                            </a></h5><span
                                                                                            class="commnt-date">
                                                                                            {{ $reply2->created_at->diffForHumans() }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="comment-body">
                                                                                    <p class="para">
                                                                                        {{ $reply2->comment }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div class="comment-form">
                            <div class="blog-widget-title style2">
                                <h4>{{ translate('Leave A Comment') }}</h4>
                                <p class="para">{{ translate('Your email address will not be published') }}.</p>
                                <span></span>
                            </div>
                            <form action="{{ route('blog.comment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{ $blog_details->id }}">
                                <div class="row">
                                    @if (Auth::guest())
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="form-inner">
                                                <input type="text" name="user_name"
                                                    placeholder="{{ translate('Your Name') }} :" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-12 col-md-6">
                                            <div class="form-inner">
                                                <input type="email" name="user_email"
                                                    placeholder="{{ translate('Your Email') }} :" required>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <textarea name="comment" placeholder="{{ translate('Your Comment') }} :" rows="6" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="eg-btn btn--primary btn--md form--btn">Submit
                                            Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">

                    <!-- blog-sidebar -->
                    <div class="blog-sidebar">
                        <div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="search-area">
                                <div class="sidebar-widget-title">
                                    <h4>{{ translate('Search From Blog') }}</h4>
                                    <span></span>
                                </div>
                                <div class="blog-widget-body">
                                    <form action="{{ route('blog.page') }}" method="GET">
                                        <div class="form-inner">
                                            <input type="text" name="search"
                                                placeholder="{{ translate('Search Here') }}">
                                            <button class="search--btn"><i class='bx bx-search-alt-2'></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".4s">
                            <div class="blog-category">
                                <div class="sidebar-widget-title">
                                    <h4>{{ translate('Recent Post') }}</h4>
                                    <span></span>
                                </div>
                                <div class="blog-widget-body">
                                    <ul class="recent-post">
                                        @foreach ($recentBlogs as $recentBlog)
                                            <li class="single-post">
                                                <div class="post-img">
                                                    <a href="{{ url('blog/' . $recentBlog->slug) }}">
                                                        @if ($recentBlog->image)
                                                            <img alt="{{ $recentBlog->title }}"
                                                                src="{{ asset('uploads/blog/' . $recentBlog->image) }}">
                                                        @else
                                                            <img alt="{{ $recentBlog->title }}"
                                                                src="{{ asset('uploads/placeholder.jpg') }}">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="post-content">
                                                    <span>{{ date('F d, Y', strtotime($recentBlog->created_at)) }}</span>
                                                    <h6><a
                                                            href="{{ url('blog/' . $recentBlog->slug) }}">{{ $recentBlog->getTranslation('title', $lang) }}</a>
                                                    </h6>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if ($categories->count() > 0)
                            <div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".4s">
                                <div class="top-blog">
                                    <div class="sidebar-widget-title">
                                        <h4>{{ translate('Post Categories') }}</h4>
                                        <span></span>
                                    </div>
                                    <div class="blog-widget-body">
                                        <ul class="category-list">
                                            @foreach ($categories as $category)
                                                <li><a
                                                        href="{{ url('blog/category/' . $category->slug) }}"><span>{{ $category->getTranslation('name') }}</span><span>{{ $category->blogs->count() ?? 0 }}</span></a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="blog-widget-item wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".8s">
                            <div class="tag-area">
                                <div class="sidebar-widget-title">
                                    <h4>{{ translate('Follow Social') }}</h4>
                                    <span></span>
                                </div>
                                <div class="blog-widget-body">
                                    <ul class="sidebar-social-list gap-4">
                                        @if (get_setting('facebook_link'))
                                            <li><a href="{{ get_setting('facebook_link') }}"><i
                                                        class='bx bxl-facebook'></i></a></li>
                                        @endif
                                        @if (get_setting('twitter_link'))
                                            <li><a href="{{ get_setting('twitter_link') }}"><i
                                                        class='bx bxl-twitter'></i></a></li>
                                        @endif
                                        @if (get_setting('linkedin_link'))
                                            <li><a href="{{ get_setting('linkedin_link') }}"><i
                                                        class='bx bxl-linkedin'></i></a></li>
                                        @endif
                                        @if (get_setting('youtube_link'))
                                            <li><a href="{{ get_setting('youtube_link') }}"><i
                                                        class='bx bxl-youtube'></i></a></li>
                                        @endif
                                        @if (get_setting('instagram_link'))
                                            <li><a href="{{ get_setting('instagram_link') }}"><i
                                                        class='bx bxl-instagram'></i></a></li>
                                        @endif
                                        @if (get_setting('pinterest_link'))
                                            <li><a href="{{ get_setting('pinterest_link') }}"><i
                                                        class='bx bxl-pinterest-alt'></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @if ($randomBlog)
                            <div class="sidebar-banner wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="1s"
                                style="background-image: linear-gradient(90deg, rgba(31, 34, 48, 0.75), rgba(31, 34, 48, 0.75)), url(/uploads/blog/{{ $randomBlog->image }});">
                                <div class="banner-content">
                                    <span>{{ $randomBlog->blog_categories->getTranslation('name', $lang) }}</span>
                                    <h3>{{ $randomBlog->getTranslation('title', $lang) }}</h3>
                                    <a href="{{ url('blog/' . $randomBlog->slug) }}"
                                        class="eg-btn btn--primary card--btn">{{ translate('Details') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.template-1.partials.reply-modal')
@endsection
