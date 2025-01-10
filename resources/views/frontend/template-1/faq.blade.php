<?php
$faqList = [];
$title = 'Demo Title';
if (isset($singelWidgetData->widget_content)) {
    $faqList = $singelWidgetData->getTranslation("widget_content");
    $title = isset($singelWidgetData->widget_content['main_title']) ? $singelWidgetData->widget_content['main_title'] : 'Demo Title';
}



?>
<div class="faq-section pt-120 ">
    <div class="container">
        <div class="row d-flex justify-content-center gy-5">
            <div class="col-lg-4 col-md-12 order-lg-1 order-2">
                <div class="faq-form-area wow fadeInDown" data-wow-duration="1.5s" data-wow-delay=".2s">
                    <h5>{{ translate('Ask Any Question') }}?</h5>
                    <p class="para">
                        {{ translate('Your email address will not be published. Required fields are marked') }} *</p>
                    <form class="faq-form" action="{{ route('contact.save') }}" method="POST">
                        @csrf
                        <div class="form-inner">
                            <label>{{ translate('Your Full Name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="@error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ translate('Enter your name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-inner">
                            <label>{{ translate('Your Email') }} <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="@error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="{{ translate('Enter your email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-inner">
                            <label>{{ translate('Subject') }} <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="@error('subject') is-invalid @enderror"
                                value="{{ old('subject') }}" placeholder="{{ translate('Subject') }}">
                            @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-inner">
                            <label>{{ translate('Your Message') }} <span class="text-danger">*</span></label>
                            <textarea name="message" class="@error('message') is-invalid @enderror" placeholder="{{ translate('Your message') }}"
                                rows="5">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit"
                            class="eg-btn btn--primary btn--md mt-1 border-0">{{ translate('Send Now') }}</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 text-center order-lg-2 order-1">
                <h2 class="section-title3">{{ $title }}</h2>
                <div class="faq-wrap wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                    @if (isset($faqList['faqs']))
                        <div class="accordion" id="accordionFaq">
                            @foreach ($faqList['faqs'] as $key => $faqItem)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $key }}">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}"
                                            aria-expanded="true" aria-controls="collapse{{ $key }}">
                                            {{ isset($faqItem['title']) ? $faqItem['title'] : '' }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $key }}" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">
                                            @php
                                            $contentDescript= isset($faqItem['description']) ?   $faqItem['description']  : '';
                                            $contentDescript=  html_entity_decode($contentDescript);
                                            $contentDescript=  prelaceScript($contentDescript);
                                            @endphp
                                            <p>
                                                {!! clean( $contentDescript )!!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <h5 class="text-center">{{ translate('Data not found') }}</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
