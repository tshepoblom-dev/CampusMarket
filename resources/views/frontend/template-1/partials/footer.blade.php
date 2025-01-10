<footer class="mt-120">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-5">
                @php

                    $col_count = 0;
                    $column = '';
                    if (get_setting('footer1_status') == 1) {
                        $col_count += 1;
                    }
                    if (get_setting('footer2_status') == 1) {
                        $col_count += 1;
                    }
                    if (get_setting('footer3_status') == 1) {
                        $col_count += 1;
                    }

                    if (get_setting('footer4_status') == 1) {
                        $col_count += 1;
                    }

                    if ($col_count == 4) {
                        $column = 'col-lg-3 col-md-6';
                    }
                    if ($col_count == 3) {
                        $column = 'col-lg-4 col-md-4';
                    }
                    if ($col_count == 2) {
                        $column = 'col-lg-6 col-md-6';
                    }
                    if ($col_count == 1) {
                        $column = 'col-lg-12 col-md-12';
                    }
                @endphp


                @if (get_setting('footer1_status') == 1)

                    <div class="{{ $column }}">
                        <div class="footer-item">
                            <a href="{{ url('/') }}">
                                @if (get_setting('footer_logo'))
                                    <img alt="Footer Logo" src="{{ asset('assets/logo/' . get_setting('footer_logo')) }}">
                                @else
                                    <img alt="Footer Logo" src="{{ asset('frontend/images/bg/footer-logo.png') }}">
                                @endif
                            </a>
                            @if (get_setting('footer_desc' . '_' . active_language()))
                                <p>{{ get_setting('footer_desc' . '_' . active_language()) }}</p>
                            @endif

                            @if (get_setting('footer_mailchimp_status') == 1)
                                <form action="{{ route('newsletter.subscribe') }}" method="POST">
                                    @csrf
                                    <div class="input-with-btn d-flex jusify-content-start align-items-strech">
                                        <input type="email" name="email" id="email"
                                            placeholder="Enter your email">
                                        <button type="submit"><img alt="image"
                                                src="{{ asset('frontend/images/icons/send-icon.svg') }}"></button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif


                @php
                    $footer_menu2 = \App\Models\MenuItem::with('page', 'category', 'blog')
                        ->where('menu_id', 2)
                        ->where('parent_id', null)
                        ->orderBy('order', 'asc')
                        ->get();
                @endphp

                @if (get_setting('footer2_status') == 1)
                    <div class="{{ $column }} d-flex justify-content-lg-center">
                        <div class="footer-item">
                            <h5>{{ translate(get_setting('footer1_title')) }}</h5>

                            @if ($footer_menu2->count() > 0)
                                <ul class="footer-list">
                                    @foreach ($footer_menu2 as $footerMenu2)
                                        <li><a target="{{ $footerMenu2->menu_type == 'custom' ? ($footerMenu2->new_tap == 1 ? '__blank' : '') : '' }}"
                                                href="@if ($footerMenu2->menu_type == 'page') {{ $footerMenu2->slug == 'home' ? url('/') : $footerMenu2->slug }} @elseif($footerMenu2->menu_type == 'custom'){{ $footerMenu2->target }} @elseif($footerMenu2->menu_type == 'category') {{ '/category/' . $footerMenu2->slug }} @else{{ '/blog/' . $footerMenu2->slug }} @endif">
                                                @if ($footerMenu2->menu_type == 'page')
                                                    {{ $footerMenu2?->page?->getTranslation('page_name') }}
                                                @elseif ($footerMenu2->menu_type == 'category')
                                                    {{ $footerMenu2->category->getTranslation('name') }}
                                                @elseif ($footerMenu2->menu_type == 'blog')
                                                    {{ $footerMenu2?->blog?->getTranslation('title') }}
                                                @else
                                                    {{ $footerMenu2->getTranslation('title') }}
                                                @endif

                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif

                @php
                    $footer_menu3 = \App\Models\MenuItem::with('page', 'category', 'blog')
                        ->where('menu_id', 3)
                        ->where('parent_id', null)
                        ->orderBy('order', 'asc')
                        ->get();
                @endphp

                @if (get_setting('footer3_status') == 1)
                    <div class="{{ $column }} d-flex justify-content-lg-center">
                        <div class="footer-item">

                            <h5>{{ translate(get_setting('footer2_title')) }}</h5>

                            @if ($footer_menu3->count() > 0)
                                <ul class="footer-list">
                                    @foreach ($footer_menu3 as $footerMenu3)
                                        <li><a target="{{ $footerMenu3->menu_type == 'custom' ? ($footerMenu3->new_tap == 1 ? '__blank' : '') : '' }}"
                                                href="@if ($footerMenu3->menu_type == 'page') {{ $footerMenu3->slug == 'home' ? url('/') : $footerMenu3->slug }}@elseif($footerMenu3->menu_type == 'custom'){{ $footerMenu3->target }}@elseif($footerMenu3->menu_type == 'category'){{ '/category/' . $footerMenu3->slug }}@else{{ '/blog/' . $footerMenu3->slug }} @endif">
                                                @if ($footerMenu3->menu_type == 'page')
                                                    {{ $footerMenu3?->page?->getTranslation('page_name') }}
                                                @elseif ($footerMenu3->menu_type == 'category')
                                                    {{ $footerMenu3->category->getTranslation('name') }}
                                                @elseif ($footerMenu3->menu_type == 'blog')
                                                    {{ $footerMenu3?->blog?->getTranslation('title') }}
                                                @else
                                                    {{ $footerMenu3->getTranslation('title') }}
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif

                @if (get_setting('footer4_status') == 1)
                    @php
                        $footer_feeds = App\Models\Blog::where('status', 1)
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            @php
                                $footer_lang = \Request::get('lang');
                            @endphp
                            <h5>{{ translate(get_setting('footer_latest_title')) }}</h5>
                            @if ($footer_feeds->count() > 0)
                                <ul class="recent-feed-list">
                                    @foreach ($footer_feeds as $footer_feed)
                                        <li class="single-feed">
                                            <div class="feed-img">
                                                <a href="{{ url('blog/' . $footer_feed->slug) }}">
                                                    @if ($footer_feed->image)
                                                        <img alt="{{ $footer_feed->title }}"
                                                            src="{{ asset('uploads/blog/' . $footer_feed->image) }}">
                                                    @else
                                                        <img alt="{{ $footer_feed->title }}"
                                                            src="{{ asset('uploads/placeholder.jpg') }}">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="feed-content">
                                                <span>{{ date('F d, Y', strtotime($footer_feed->created_at)) }}</span>
                                                <h6><a
                                                        href="{{ url('blog/' . $footer_feed->slug) }}">{{ $footer_feed->getTranslation('title', $footer_lang) }}</a>
                                                </h6>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if (get_setting('hide_footer_bottom') == 1)
        <div class="footer-bottom">
            <div class="container">
                <div class="row d-flex align-items-center g-4">
                    <div class="col-lg-6 d-flex justify-content-lg-start justify-content-center">

                        <p class="footer-copyright">{!! clean(get_setting('front_copyright' . '_' . active_language())) !!}</p>
                    </div>
                    <div
                        class="col-lg-6 d-flex justify-content-lg-end justify-content-center align-items-center flex-sm-nowrap flex-wrap">
                        <p class="d-sm-flex d-none">{{ translate('We Accepts') }}:</p>
                        <ul class="footer-logo-list">
                            <li><img alt="image"
                                    src="{{ asset('assets/logo/' . get_setting('payment_method_img')) }}"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

</footer>
