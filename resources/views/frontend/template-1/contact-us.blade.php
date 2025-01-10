@php

    if (isset($singelWidgetData->widget_content)) {
        $singelWidgetData = $singelWidgetData->getTranslation("widget_content");

    }


@endphp



<div class="contact-section pt-120">
    <img alt="image" src="{{ asset('frontend/images/section-bg.png') }}" class="img-fluid section-bg-top">
    <img alt="image" src="{{ asset('frontend/images/section-bg.png') }}" class="img-fluid section-bg-bottom">
    <div class="container">
        <div class="row pb-120 mb-70 g-4 d-flex justify-content-center">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="contact-signle hover-border1 d-flex flex-row align-items-center wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".2s"
                    style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.2s; animation-name: fadeInDown;">
                    <div class="icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="text">
                        <h4>{{ translate('Location') }}</h4>
                        <p> {{ isset($singelWidgetData['location']) ? $singelWidgetData['location'] : '' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="contact-signle hover-border1 d-flex flex-row align-items-center wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".4s"
                    style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.4s; animation-name: fadeInDown;">
                    <div class="icon">
                        <i class="bx bx-phone-call"></i>
                    </div>
                    <div class="text">
                        <h4>{{ translate('Phone') }}</h4>
                        @if (isset($singelWidgetData['phone']))
                            @foreach ($singelWidgetData['phone'] as $key => $phone)
                                <a
                                    href="tel:{{ isset($phone['phone_number']) ? $phone['phone_number'] : '' }}">{{ isset($phone['phone_number']) ? $phone['phone_number'] : '' }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="contact-signle hover-border1 d-flex flex-row align-items-center wow fadeInDown"
                    data-wow-duration="1.5s" data-wow-delay=".6s"
                    style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.6s; animation-name: fadeInDown;">
                    <div class="icon">
                        <i class="bx bx-envelope"></i>
                    </div>
                    <div class="text">
                        <h4>{{ translate('Email') }}</h4>

                        @if (isset($singelWidgetData['email']))
                            @foreach ($singelWidgetData['email'] as $key => $email)
                                <a
                                    href="tel:{{ isset($email['email_name']) ? $email['email_name'] : '' }}">{{ isset($email['email_name']) ? $email['email_name'] : '' }}</a>
                            @endforeach
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="form-wrapper wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s"
                    style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.2s; animation-name: fadeInDown;">
                    <div class="form-title2">
                        <h3>{{ isset($singelWidgetData['main_title']) ? $singelWidgetData['main_title'] : '' }}
                        </h3>
                        <p class="para">
                            {{ isset($singelWidgetData['sub_title']) ? $singelWidgetData['sub_title'] : '' }}
                        </p>
                    </div>
                    <form action="{{ route('contact.save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <input type="text" name="name" class="@error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="{{translate('Your Name')}}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <input type="email" name="email" class="@error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="{{translate('Your Email')}}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <input type="text" name="phone" class="@error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}" placeholder="{{translate('Your Phone')}}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-6">
                                <div class="form-inner">
                                    <input type="text" value="{{ old('subject') }}"
                                        class="@error('subject') is-invalid @enderror" name="subject"
                                        placeholder="{{translate('Subject')}}">
                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <textarea name="message" class="@error('message') is-invalid @enderror" name="message" placeholder="{{translate('Write Message')}}"
                                    rows="12">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            @if (get_setting('google_recapcha_check') == 1)
                                 <div class="g-recaptcha mt-3" data-sitekey="{{ get_setting('recaptcha_key') }}"></div>
                                @if (Session::has('g-recaptcha-response'))
                                    <p class="text-danger"> {{ Session::get('g-recaptcha-response') }}</p>
                                @endif
                            @endif

                            <div class="col-12">
                                <button type="submit"
                                    class="eg-btn btn--primary btn--md form--btn">{{ translate('Send Message') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="map-area wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".4s"
                    style="visibility: visible; animation-duration: 1.5s; animation-delay: 0.4s; animation-name: fadeInUp;">
                    {{-- {!! isset($singelWidgetData['irame_link']) ?  htmlspecialchars( prelaceScript(html_entity_decode( $singelWidgetData['irame_link'])))  : '' !!}--}}

<!--                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6255252.31904332!2d-106.08810052683293!3d40.04590513383155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sbd!4v1650355365902!5m2!1sen!2sbd" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3485.4662951725104!2d26.220347674351277!3d-29.121433889088973!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1e8fc56418398815%3A0x29aea08fbc973fda!2s46%20St%20Georges%20St%2C%20Bloemfontein%20Central%2C%20Bloemfontein%2C%209301!5e0!3m2!1sen!2sza!4v1729078241878!5m2!1sen!2sza" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>
            </div>
        </div>
    </div>
</div>
