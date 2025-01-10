<div class="topbar">
    <div class="topbar-left d-flex flex-row align-items-center">
        <h6>{{ translate('Follow Us') }}</h6>
        <ul class="topbar-social-list gap-2">
            @if (get_setting('facebook_link'))
                <li><a href="{{ get_setting('facebook_link') }}"><i class='bx bxl-facebook'></i></a></li>
            @endif
            @if (get_setting('twitter_link'))
                <li><a href="{{ get_setting('twitter_link') }}"><i class='bx bxl-twitter'></i></a></li>
            @endif
            @if (get_setting('linkedin_link'))
                <li><a href="{{ get_setting('linkedin_link') }}"><i class='bx bxl-linkedin'></i></a></li>
            @endif
            @if (get_setting('youtube_link'))
                <li><a href="{{ get_setting('youtube_link') }}"><i class='bx bxl-youtube'></i></a></li>
            @endif
            @if (get_setting('instagram_link'))
                <li><a href="{{ get_setting('instagram_link') }}"><i class='bx bxl-instagram'></i></a></li>
            @endif
            @if (get_setting('pinterest_link'))
                <li><a href="{{ get_setting('pinterest_link') }}"><i class='bx bxl-pinterest-alt'></i></a></li>
            @endif
        </ul>
    </div>
    @if (get_setting('email_address'))
        <div class="email-area">
            <h6>{{ translate('Email') }}: <a
                    href="mailto:{{ get_setting('email_address') }}">{{ get_setting('email_address') }}</a></h6>
        </div>
    @endif
    @if (Auth::check() && Auth::user()->role == 1)
        <div class="available-balance">
            <strong>{{ translate('Available Balance') }}:</strong>
            {{ currency_symbol() . number_format(Auth::user()->wallet_balance, 2) }}
        </div>
    @endif


    <div class="topbar-right">
        <ul class="topbar-right-list">
            @php
                if (Session::has('locale')) {
                    $locale = Session::get('locale', Config::get('app.locale'));
                } else {
                    $locale = get_setting('DEFAULT_LANGUAGE', 'en');
                }
            @endphp
            <li><span class="langName">{{ $locale }}</span><img
                    src="{{ asset('assets/img/flags/' . $locale . '.png') }}" alt="{{ translate('Language') }}">
                <ul class="topbar-sublist" id="change-lang">
                    @foreach (\App\Models\Language::all() as $key => $language)
                        <li><a class="dropdown-item" href="javascript:void(0)" data-flag="{{ $language->code }}"
                                class="dropdown-item @if ($locale == $language->code) active @endif"><span>{{ $language->name }}</span><img
                                    src="{{ asset('assets/img/flags/' . $language->code . '.png') }}"
                                    alt="image"></a>
                        </li>
                    @endforeach
                </ul>
            </li>
            @if (Auth::guest())
                <li><a href="{{ route('merchant.register.show') }}">{{ translate(get_setting('marchant_btn')) }}</a>
                </li>
                <li><a href="{{ route('register') }}">{{ translate(get_setting('customer_btn')) }}</a></li>
            @else
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ translate('Logout') }}</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endif
        </ul>
    </div>
</div>
