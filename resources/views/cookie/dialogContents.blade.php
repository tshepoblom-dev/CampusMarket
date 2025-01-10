<div class="js-cookie-consent cookie-consent">
    <div class="js-cookie-consent-area d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="cookie-content">
            <h4> {{ get_setting('gdpr_title' . '_' . active_language()) }} </h4>
            {!! clean( get_setting('gdpr_description' . '_' . active_language()))  !!}
        </div>
        <div class="cookie-btn-grp">
            <button class="js-cookie-consent-agree cookie-consent__agree d-block mb-15">
                {{ translate('Accept All') }}
            </button>
            <button class="js-cookie-consent-reject">
                {{ translate('Reject All') }}
            </button>
        </div>
    </div>
</div>
