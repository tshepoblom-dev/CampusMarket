@extends('backend.layouts.master')
@section('content')
    <div class="page-title2">
        <img src="{{ asset('backend/images/bg/title-loog.png') }}" class="title-logo" alt="logo">
        <h5>{{ translate('Backend Settings') }}</h5>
        <a class="clear-cache" href="{{ route('backend.cache-clear') }}"><i class="bi bi-eraser"></i> Clear Cache</a>
    </div>
    <form action="{{ route('backend.settings.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="tab-area settings-area">
            <div class="nav flex-row jusify-content-start nav-pills" id="v-pills-tab" role="tablist"
                aria-orientation="vertical">
                <button class="nav-link active" id="v-pills-general-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-general" type="button" role="tab" aria-controls="v-pills-general"
                    aria-selected="true">{{ translate('General') }}</button>
                <button class="nav-link" id="v-pills-setting-tab" data-bs-toggle="pill" data-bs-target="#v-pills-setting"
                    type="button" role="tab" aria-controls="v-pills-setting"
                    aria-selected="true">{{ translate('Email Configuration') }}</button>
                <!-- <button class="nav-link" id="v-pills-pay-tab" data-bs-toggle="pill" data-bs-target="#v-pills-pay"
                            type="button" role="tab" aria-controls="v-pills-pay"
                            aria-selected="true">{{ translate('Payment Method') }}</button> -->
                <button class="nav-link" id="v-pills-recaptcha-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-recaptcha" type="button" role="tab" aria-controls="v-pills-recaptcha"
                    aria-selected="true">{{ translate('Google reCAPTCHA') }}</button>

                <button class="nav-link" id="v-pills-tawk-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tawk"
                    type="button" role="tab" aria-controls="v-pills-tawk"
                    aria-selected="true">{{ translate('Tawk Chat') }}</button>
                <button class="nav-link" id="v-pills-system-info-tab" data-bs-toggle="pill"
                    data-bs-target="#v-pills-system-info" type="button" role="tab" aria-controls="v-pills-system-info"
                    aria-selected="true">{{ translate('System Information') }}</button>
            </div>
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-general" role="tabpanel"
                    aria-labelledby="v-pills-general-tab">
                    <!-- temparory content -->
                    <div class="eg-card product-card">

                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Application Name') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('company_name', get_setting('company_name')) }}" name="company_name"
                                        placeholder="{{ translate('Application Name') }}">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Currency') }}</label>
                                    <select class="js-example-basic-single" name="default_currency">
                                        <option value="">{{ translate('Select Option') }}</option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}"
                                                {{ old('default_currency', get_setting('default_currency')) == $currency->id ? 'selected' : '' }}>
                                                {{ $currency->name . ' - ' . $currency->symbol }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('VAT/Tax Rate for Customer') }}</label>
                                    <input type="text" name="tax_rate"
                                        value="{{ old('tax_rate', get_setting('tax_rate')) }}"
                                        placeholder="{{ translate('TAX Rate') }}" aria-label="TAX Rate"
                                        aria-describedby="tax_rate">
                                    <span class="form-inner-text" id="tax_rate">%</span>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35 position-relative">
                                    <label>{{ translate('System Timezone') }}</label>
                                    <select class="js-example-basic-single" id="time_zone" name="time_zone">
                                        <option value="Etc/GMT+12">(GMT-12:00) Etc/GMT+12</option>
                                        <option value="Etc/GMT+11">(GMT-11:00) Etc/GMT+11</option>
                                        <option value="Pacific/Midway">(GMT-11:00) Pacific/Midway</option>
                                        <option value="Pacific/Niue">(GMT-11:00) Pacific/Niue</option>
                                        <option value="Pacific/Pago_Pago">(GMT-11:00) Pacific/Pago_Pago</option>
                                        <option value="Pacific/Samoa">(GMT-11:00) Pacific/Samoa</option>
                                        <option value="US/Samoa">(GMT-11:00) US/Samoa</option>
                                        <option value="America/Adak">(GMT-10:00) America/Adak</option>
                                        <option value="America/Atka">(GMT-10:00) America/Atka</option>
                                        <option value="Etc/GMT+10">(GMT-10:00) Etc/GMT+10</option>
                                        <option value="HST">(GMT-10:00) HST</option>
                                        <option value="Pacific/Honolulu">(GMT-10:00) Pacific/Honolulu</option>
                                        <option value="Pacific/Johnston">(GMT-10:00) Pacific/Johnston</option>
                                        <option value="Pacific/Rarotonga">(GMT-10:00) Pacific/Rarotonga</option>
                                        <option value="Pacific/Tahiti">(GMT-10:00) Pacific/Tahiti</option>
                                        <option value="US/Aleutian">(GMT-10:00) US/Aleutian</option>
                                        <option value="US/Hawaii">(GMT-10:00) US/Hawaii</option>
                                        <option value="Pacific/Marquesas">(GMT-09:30) Pacific/Marquesas</option>
                                        <option value="America/Anchorage">(GMT-09:00) America/Anchorage</option>
                                        <option value="America/Juneau">(GMT-09:00) America/Juneau</option>
                                        <option value="America/Metlakatla">(GMT-09:00) America/Metlakatla</option>
                                        <option value="America/Nome">(GMT-09:00) America/Nome</option>
                                        <option value="America/Sitka">(GMT-09:00) America/Sitka</option>
                                        <option value="America/Yakutat">(GMT-09:00) America/Yakutat</option>
                                        <option value="Etc/GMT+9">(GMT-09:00) Etc/GMT+9</option>
                                        <option value="Pacific/Gambier">(GMT-09:00) Pacific/Gambier</option>
                                        <option value="US/Alaska">(GMT-09:00) US/Alaska</option>
                                        <option value="America/Ensenada">(GMT-08:00) America/Ensenada</option>
                                        <option value="America/Los_Angeles">(GMT-08:00) America/Los_Angeles</option>
                                        <option value="America/Santa_Isabel">(GMT-08:00) America/Santa_Isabel</option>
                                        <option value="America/Tijuana">(GMT-08:00) America/Tijuana</option>
                                        <option value="America/Vancouver">(GMT-08:00) America/Vancouver</option>
                                        <option value="Canada/Pacific">(GMT-08:00) Canada/Pacific</option>
                                        <option value="Etc/GMT+8">(GMT-08:00) Etc/GMT+8</option>
                                        <option value="Mexico/BajaNorte">(GMT-08:00) Mexico/BajaNorte</option>
                                        <option value="PST8PDT">(GMT-08:00) PST8PDT</option>
                                        <option value="Pacific/Pitcairn">(GMT-08:00) Pacific/Pitcairn</option>
                                        <option value="US/Pacific">(GMT-08:00) US/Pacific</option>
                                        <option value="America/Boise">(GMT-07:00) America/Boise</option>
                                        <option value="America/Cambridge_Bay">(GMT-07:00) America/Cambridge_Bay</option>
                                        <option value="America/Ciudad_Juarez">(GMT-07:00) America/Ciudad_Juarez</option>
                                        <option value="America/Creston">(GMT-07:00) America/Creston</option>
                                        <option value="America/Dawson">(GMT-07:00) America/Dawson</option>
                                        <option value="America/Dawson_Creek">(GMT-07:00) America/Dawson_Creek</option>
                                        <option value="America/Denver">(GMT-07:00) America/Denver</option>
                                        <option value="America/Edmonton">(GMT-07:00) America/Edmonton</option>
                                        <option value="America/Fort_Nelson">(GMT-07:00) America/Fort_Nelson</option>
                                        <option value="America/Hermosillo">(GMT-07:00) America/Hermosillo</option>
                                        <option value="America/Inuvik">(GMT-07:00) America/Inuvik</option>
                                        <option value="America/Mazatlan">(GMT-07:00) America/Mazatlan</option>
                                        <option value="America/Phoenix">(GMT-07:00) America/Phoenix</option>
                                        <option value="America/Shiprock">(GMT-07:00) America/Shiprock</option>
                                        <option value="America/Whitehorse">(GMT-07:00) America/Whitehorse</option>
                                        <option value="America/Yellowknife">(GMT-07:00) America/Yellowknife</option>
                                        <option value="Canada/Mountain">(GMT-07:00) Canada/Mountain</option>
                                        <option value="Canada/Yukon">(GMT-07:00) Canada/Yukon</option>
                                        <option value="Etc/GMT+7">(GMT-07:00) Etc/GMT+7</option>
                                        <option value="MST">(GMT-07:00) MST</option>
                                        <option value="MST7MDT">(GMT-07:00) MST7MDT</option>
                                        <option value="Mexico/BajaSur">(GMT-07:00) Mexico/BajaSur</option>
                                        <option value="Navajo">(GMT-07:00) Navajo</option>
                                        <option value="US/Arizona">(GMT-07:00) US/Arizona</option>
                                        <option value="US/Mountain">(GMT-07:00) US/Mountain</option>
                                        <option value="America/Bahia_Banderas">(GMT-06:00) America/Bahia_Banderas</option>
                                        <option value="America/Belize">(GMT-06:00) America/Belize</option>
                                        <option value="America/Chicago">(GMT-06:00) America/Chicago</option>
                                        <option value="America/Chihuahua">(GMT-06:00) America/Chihuahua</option>
                                        <option value="America/Costa_Rica">(GMT-06:00) America/Costa_Rica</option>
                                        <option value="America/El_Salvador">(GMT-06:00) America/El_Salvador</option>
                                        <option value="America/Guatemala">(GMT-06:00) America/Guatemala</option>
                                        <option value="America/Indiana/Knox">(GMT-06:00) America/Indiana/Knox</option>
                                        <option value="America/Indiana/Tell_City">(GMT-06:00) America/Indiana/Tell_City
                                        </option>
                                        <option value="America/Knox_IN">(GMT-06:00) America/Knox_IN</option>
                                        <option value="America/Managua">(GMT-06:00) America/Managua</option>
                                        <option value="America/Matamoros">(GMT-06:00) America/Matamoros</option>
                                        <option value="America/Menominee">(GMT-06:00) America/Menominee</option>
                                        <option value="America/Merida">(GMT-06:00) America/Merida</option>
                                        <option value="America/Mexico_City">(GMT-06:00) America/Mexico_City</option>
                                        <option value="America/Monterrey">(GMT-06:00) America/Monterrey</option>
                                        <option value="America/North_Dakota/Beulah">(GMT-06:00) America/North_Dakota/Beulah
                                        </option>
                                        <option value="America/North_Dakota/Center">(GMT-06:00) America/North_Dakota/Center
                                        </option>
                                        <option value="America/North_Dakota/New_Salem">(GMT-06:00)
                                            America/North_Dakota/New_Salem</option>
                                        <option value="America/Ojinaga">(GMT-06:00) America/Ojinaga</option>
                                        <option value="America/Rainy_River">(GMT-06:00) America/Rainy_River</option>
                                        <option value="America/Rankin_Inlet">(GMT-06:00) America/Rankin_Inlet</option>
                                        <option value="America/Regina">(GMT-06:00) America/Regina</option>
                                        <option value="America/Resolute">(GMT-06:00) America/Resolute</option>
                                        <option value="America/Swift_Current">(GMT-06:00) America/Swift_Current</option>
                                        <option value="America/Tegucigalpa">(GMT-06:00) America/Tegucigalpa</option>
                                        <option value="America/Winnipeg">(GMT-06:00) America/Winnipeg</option>
                                        <option value="CST6CDT">(GMT-06:00) CST6CDT</option>
                                        <option value="Canada/Central">(GMT-06:00) Canada/Central</option>
                                        <option value="Canada/Saskatchewan">(GMT-06:00) Canada/Saskatchewan</option>
                                        <option value="Etc/GMT+6">(GMT-06:00) Etc/GMT+6</option>
                                        <option value="Mexico/General">(GMT-06:00) Mexico/General</option>
                                        <option value="Pacific/Galapagos">(GMT-06:00) Pacific/Galapagos</option>
                                        <option value="US/Central">(GMT-06:00) US/Central</option>
                                        <option value="US/Indiana-Starke">(GMT-06:00) US/Indiana-Starke</option>
                                        <option value="America/Atikokan">(GMT-05:00) America/Atikokan</option>
                                        <option value="America/Bogota">(GMT-05:00) America/Bogota</option>
                                        <option value="America/Cancun">(GMT-05:00) America/Cancun</option>
                                        <option value="America/Cayman">(GMT-05:00) America/Cayman</option>
                                        <option value="America/Coral_Harbour">(GMT-05:00) America/Coral_Harbour</option>
                                        <option value="America/Detroit">(GMT-05:00) America/Detroit</option>
                                        <option value="America/Eirunepe">(GMT-05:00) America/Eirunepe</option>
                                        <option value="America/Fort_Wayne">(GMT-05:00) America/Fort_Wayne</option>
                                        <option value="America/Grand_Turk">(GMT-05:00) America/Grand_Turk</option>
                                        <option value="America/Guayaquil">(GMT-05:00) America/Guayaquil</option>
                                        <option value="America/Havana">(GMT-05:00) America/Havana</option>
                                        <option value="America/Indiana/Indianapolis">(GMT-05:00)
                                            America/Indiana/Indianapolis</option>
                                        <option value="America/Indiana/Marengo">(GMT-05:00) America/Indiana/Marengo
                                        </option>
                                        <option value="America/Indiana/Petersburg">(GMT-05:00) America/Indiana/Petersburg
                                        </option>
                                        <option value="America/Indiana/Vevay">(GMT-05:00) America/Indiana/Vevay</option>
                                        <option value="America/Indiana/Vincennes">(GMT-05:00) America/Indiana/Vincennes
                                        </option>
                                        <option value="America/Indiana/Winamac">(GMT-05:00) America/Indiana/Winamac
                                        </option>
                                        <option value="America/Indianapolis">(GMT-05:00) America/Indianapolis</option>
                                        <option value="America/Iqaluit">(GMT-05:00) America/Iqaluit</option>
                                        <option value="America/Jamaica">(GMT-05:00) America/Jamaica</option>
                                        <option value="America/Kentucky/Louisville">(GMT-05:00) America/Kentucky/Louisville
                                        </option>
                                        <option value="America/Kentucky/Monticello">(GMT-05:00) America/Kentucky/Monticello
                                        </option>
                                        <option value="America/Lima">(GMT-05:00) America/Lima</option>
                                        <option value="America/Louisville">(GMT-05:00) America/Louisville</option>
                                        <option value="America/Montreal">(GMT-05:00) America/Montreal</option>
                                        <option value="America/Nassau">(GMT-05:00) America/Nassau</option>
                                        <option value="America/New_York">(GMT-05:00) America/New_York</option>
                                        <option value="America/Nipigon">(GMT-05:00) America/Nipigon</option>
                                        <option value="America/Panama">(GMT-05:00) America/Panama</option>
                                        <option value="America/Pangnirtung">(GMT-05:00) America/Pangnirtung</option>
                                        <option value="America/Port-au-Prince">(GMT-05:00) America/Port-au-Prince</option>
                                        <option value="America/Porto_Acre">(GMT-05:00) America/Porto_Acre</option>
                                        <option value="America/Rio_Branco">(GMT-05:00) America/Rio_Branco</option>
                                        <option value="America/Thunder_Bay">(GMT-05:00) America/Thunder_Bay</option>
                                        <option value="America/Toronto">(GMT-05:00) America/Toronto</option>
                                        <option value="Brazil/Acre">(GMT-05:00) Brazil/Acre</option>
                                        <option value="Canada/Eastern">(GMT-05:00) Canada/Eastern</option>
                                        <option value="Chile/EasterIsland">(GMT-05:00) Chile/EasterIsland</option>
                                        <option value="Cuba">(GMT-05:00) Cuba</option>
                                        <option value="EST">(GMT-05:00) EST</option>
                                        <option value="EST5EDT">(GMT-05:00) EST5EDT</option>
                                        <option value="Etc/GMT+5">(GMT-05:00) Etc/GMT+5</option>
                                        <option value="Jamaica">(GMT-05:00) Jamaica</option>
                                        <option value="Pacific/Easter">(GMT-05:00) Pacific/Easter</option>
                                        <option value="US/East-Indiana">(GMT-05:00) US/East-Indiana</option>
                                        <option value="US/Eastern">(GMT-05:00) US/Eastern</option>
                                        <option value="US/Michigan">(GMT-05:00) US/Michigan</option>
                                        <option value="America/Anguilla">(GMT-04:00) America/Anguilla</option>
                                        <option value="America/Antigua">(GMT-04:00) America/Antigua</option>
                                        <option value="America/Aruba">(GMT-04:00) America/Aruba</option>
                                        <option value="America/Barbados">(GMT-04:00) America/Barbados</option>
                                        <option value="America/Blanc-Sablon">(GMT-04:00) America/Blanc-Sablon</option>
                                        <option value="America/Boa_Vista">(GMT-04:00) America/Boa_Vista</option>
                                        <option value="America/Campo_Grande">(GMT-04:00) America/Campo_Grande</option>
                                        <option value="America/Caracas">(GMT-04:00) America/Caracas</option>
                                        <option value="America/Cuiaba">(GMT-04:00) America/Cuiaba</option>
                                        <option value="America/Curacao">(GMT-04:00) America/Curacao</option>
                                        <option value="America/Dominica">(GMT-04:00) America/Dominica</option>
                                        <option value="America/Glace_Bay">(GMT-04:00) America/Glace_Bay</option>
                                        <option value="America/Goose_Bay">(GMT-04:00) America/Goose_Bay</option>
                                        <option value="America/Grenada">(GMT-04:00) America/Grenada</option>
                                        <option value="America/Guadeloupe">(GMT-04:00) America/Guadeloupe</option>
                                        <option value="America/Guyana">(GMT-04:00) America/Guyana</option>
                                        <option value="America/Halifax">(GMT-04:00) America/Halifax</option>
                                        <option value="America/Kralendijk">(GMT-04:00) America/Kralendijk</option>
                                        <option value="America/La_Paz">(GMT-04:00) America/La_Paz</option>
                                        <option value="America/Lower_Princes">(GMT-04:00) America/Lower_Princes</option>
                                        <option value="America/Manaus">(GMT-04:00) America/Manaus</option>
                                        <option value="America/Marigot">(GMT-04:00) America/Marigot</option>
                                        <option value="America/Martinique">(GMT-04:00) America/Martinique</option>
                                        <option value="America/Moncton">(GMT-04:00) America/Moncton</option>
                                        <option value="America/Montserrat">(GMT-04:00) America/Montserrat</option>
                                        <option value="America/Port_of_Spain">(GMT-04:00) America/Port_of_Spain</option>
                                        <option value="America/Porto_Velho">(GMT-04:00) America/Porto_Velho</option>
                                        <option value="America/Puerto_Rico">(GMT-04:00) America/Puerto_Rico</option>
                                        <option value="America/Santo_Domingo">(GMT-04:00) America/Santo_Domingo</option>
                                        <option value="America/St_Barthelemy">(GMT-04:00) America/St_Barthelemy</option>
                                        <option value="America/St_Kitts">(GMT-04:00) America/St_Kitts</option>
                                        <option value="America/St_Lucia">(GMT-04:00) America/St_Lucia</option>
                                        <option value="America/St_Thomas">(GMT-04:00) America/St_Thomas</option>
                                        <option value="America/St_Vincent">(GMT-04:00) America/St_Vincent</option>
                                        <option value="America/Thule">(GMT-04:00) America/Thule</option>
                                        <option value="America/Tortola">(GMT-04:00) America/Tortola</option>
                                        <option value="America/Virgin">(GMT-04:00) America/Virgin</option>
                                        <option value="Atlantic/Bermuda">(GMT-04:00) Atlantic/Bermuda</option>
                                        <option value="Brazil/West">(GMT-04:00) Brazil/West</option>
                                        <option value="Canada/Atlantic">(GMT-04:00) Canada/Atlantic</option>
                                        <option value="Etc/GMT+4">(GMT-04:00) Etc/GMT+4</option>
                                        <option value="America/St_Johns">(GMT-03:30) America/St_Johns</option>
                                        <option value="Canada/Newfoundland">(GMT-03:30) Canada/Newfoundland</option>
                                        <option value="America/Araguaina">(GMT-03:00) America/Araguaina</option>
                                        <option value="America/Argentina/Buenos_Aires">(GMT-03:00)
                                            America/Argentina/Buenos_Aires</option>
                                        <option value="America/Argentina/Catamarca">(GMT-03:00) America/Argentina/Catamarca
                                        </option>
                                        <option value="America/Argentina/ComodRivadavia">(GMT-03:00)
                                            America/Argentina/ComodRivadavia</option>
                                        <option value="America/Argentina/Cordoba">(GMT-03:00) America/Argentina/Cordoba
                                        </option>
                                        <option value="America/Argentina/Jujuy">(GMT-03:00) America/Argentina/Jujuy
                                        </option>
                                        <option value="America/Argentina/La_Rioja">(GMT-03:00) America/Argentina/La_Rioja
                                        </option>
                                        <option value="America/Argentina/Mendoza">(GMT-03:00) America/Argentina/Mendoza
                                        </option>
                                        <option value="America/Argentina/Rio_Gallegos">(GMT-03:00)
                                            America/Argentina/Rio_Gallegos</option>
                                        <option value="America/Argentina/Salta">(GMT-03:00) America/Argentina/Salta
                                        </option>
                                        <option value="America/Argentina/San_Juan">(GMT-03:00) America/Argentina/San_Juan
                                        </option>
                                        <option value="America/Argentina/San_Luis">(GMT-03:00) America/Argentina/San_Luis
                                        </option>
                                        <option value="America/Argentina/Tucuman">(GMT-03:00) America/Argentina/Tucuman
                                        </option>
                                        <option value="America/Argentina/Ushuaia">(GMT-03:00) America/Argentina/Ushuaia
                                        </option>
                                        <option value="America/Asuncion">(GMT-03:00) America/Asuncion</option>
                                        <option value="America/Bahia">(GMT-03:00) America/Bahia</option>
                                        <option value="America/Belem">(GMT-03:00) America/Belem</option>
                                        <option value="America/Buenos_Aires">(GMT-03:00) America/Buenos_Aires</option>
                                        <option value="America/Catamarca">(GMT-03:00) America/Catamarca</option>
                                        <option value="America/Cayenne">(GMT-03:00) America/Cayenne</option>
                                        <option value="America/Cordoba">(GMT-03:00) America/Cordoba</option>
                                        <option value="America/Fortaleza">(GMT-03:00) America/Fortaleza</option>
                                        <option value="America/Jujuy">(GMT-03:00) America/Jujuy</option>
                                        <option value="America/Maceio">(GMT-03:00) America/Maceio</option>
                                        <option value="America/Mendoza">(GMT-03:00) America/Mendoza</option>
                                        <option value="America/Miquelon">(GMT-03:00) America/Miquelon</option>
                                        <option value="America/Montevideo">(GMT-03:00) America/Montevideo</option>
                                        <option value="America/Paramaribo">(GMT-03:00) America/Paramaribo</option>
                                        <option value="America/Punta_Arenas">(GMT-03:00) America/Punta_Arenas</option>
                                        <option value="America/Recife">(GMT-03:00) America/Recife</option>
                                        <option value="America/Rosario">(GMT-03:00) America/Rosario</option>
                                        <option value="America/Santarem">(GMT-03:00) America/Santarem</option>
                                        <option value="America/Santiago">(GMT-03:00) America/Santiago</option>
                                        <option value="America/Sao_Paulo">(GMT-03:00) America/Sao_Paulo</option>
                                        <option value="Antarctica/Palmer">(GMT-03:00) Antarctica/Palmer</option>
                                        <option value="Antarctica/Rothera">(GMT-03:00) Antarctica/Rothera</option>
                                        <option value="Atlantic/Stanley">(GMT-03:00) Atlantic/Stanley</option>
                                        <option value="Brazil/East">(GMT-03:00) Brazil/East</option>
                                        <option value="Chile/Continental">(GMT-03:00) Chile/Continental</option>
                                        <option value="Etc/GMT+3">(GMT-03:00) Etc/GMT+3</option>
                                        <option value="America/Godthab">(GMT-02:00) America/Godthab</option>
                                        <option value="America/Noronha">(GMT-02:00) America/Noronha</option>
                                        <option value="America/Nuuk">(GMT-02:00) America/Nuuk</option>
                                        <option value="Atlantic/South_Georgia">(GMT-02:00) Atlantic/South_Georgia</option>
                                        <option value="Brazil/DeNoronha">(GMT-02:00) Brazil/DeNoronha</option>
                                        <option value="Etc/GMT+2">(GMT-02:00) Etc/GMT+2</option>
                                        <option value="America/Scoresbysund">(GMT-01:00) America/Scoresbysund</option>
                                        <option value="Atlantic/Azores">(GMT-01:00) Atlantic/Azores</option>
                                        <option value="Atlantic/Cape_Verde">(GMT-01:00) Atlantic/Cape_Verde</option>
                                        <option value="Etc/GMT+1">(GMT-01:00) Etc/GMT+1</option>
                                        <option value="Africa/Abidjan">(GMT) Africa/Abidjan</option>
                                        <option value="Africa/Accra">(GMT) Africa/Accra</option>
                                        <option value="Africa/Bamako">(GMT) Africa/Bamako</option>
                                        <option value="Africa/Banjul">(GMT) Africa/Banjul</option>
                                        <option value="Africa/Bissau">(GMT) Africa/Bissau</option>
                                        <option value="Africa/Conakry">(GMT) Africa/Conakry</option>
                                        <option value="Africa/Dakar">(GMT) Africa/Dakar</option>
                                        <option value="Africa/Freetown">(GMT) Africa/Freetown</option>
                                        <option value="Africa/Lome">(GMT) Africa/Lome</option>
                                        <option value="Africa/Monrovia">(GMT) Africa/Monrovia</option>
                                        <option value="Africa/Nouakchott">(GMT) Africa/Nouakchott</option>
                                        <option value="Africa/Ouagadougou">(GMT) Africa/Ouagadougou</option>
                                        <option value="Africa/Sao_Tome">(GMT) Africa/Sao_Tome</option>
                                        <option value="Africa/Timbuktu">(GMT) Africa/Timbuktu</option>
                                        <option value="America/Danmarkshavn">(GMT) America/Danmarkshavn</option>
                                        <option value="Antarctica/Troll">(GMT) Antarctica/Troll</option>
                                        <option value="Atlantic/Canary">(GMT) Atlantic/Canary</option>
                                        <option value="Atlantic/Faeroe">(GMT) Atlantic/Faeroe</option>
                                        <option value="Atlantic/Faroe">(GMT) Atlantic/Faroe</option>
                                        <option value="Atlantic/Madeira">(GMT) Atlantic/Madeira</option>
                                        <option value="Atlantic/Reykjavik">(GMT) Atlantic/Reykjavik</option>
                                        <option value="Atlantic/St_Helena">(GMT) Atlantic/St_Helena</option>
                                        <option value="Eire">(GMT) Eire</option>
                                        <option value="Etc/GMT">(GMT) Etc/GMT</option>
                                        <option value="Etc/GMT+0">(GMT) Etc/GMT+0</option>
                                        <option value="Etc/GMT-0">(GMT) Etc/GMT-0</option>
                                        <option value="Etc/GMT0">(GMT) Etc/GMT0</option>
                                        <option value="Etc/Greenwich">(GMT) Etc/Greenwich</option>
                                        <option value="Etc/UCT">(GMT) Etc/UCT</option>
                                        <option value="Etc/UTC">(GMT) Etc/UTC</option>
                                        <option value="Etc/Universal">(GMT) Etc/Universal</option>
                                        <option value="Etc/Zulu">(GMT) Etc/Zulu</option>
                                        <option value="Europe/Belfast">(GMT) Europe/Belfast</option>
                                        <option value="Europe/Dublin">(GMT) Europe/Dublin</option>
                                        <option value="Europe/Guernsey">(GMT) Europe/Guernsey</option>
                                        <option value="Europe/Isle_of_Man">(GMT) Europe/Isle_of_Man</option>
                                        <option value="Europe/Jersey">(GMT) Europe/Jersey</option>
                                        <option value="Europe/Lisbon">(GMT) Europe/Lisbon</option>
                                        <option value="Europe/London">(GMT) Europe/London</option>
                                        <option value="GB">(GMT) GB</option>
                                        <option value="GB-Eire">(GMT) GB-Eire</option>
                                        <option value="GMT">(GMT) GMT</option>
                                        <option value="GMT+0">(GMT) GMT+0</option>
                                        <option value="GMT-0">(GMT) GMT-0</option>
                                        <option value="GMT0">(GMT) GMT0</option>
                                        <option value="Greenwich">(GMT) Greenwich</option>
                                        <option value="Iceland">(GMT) Iceland</option>
                                        <option value="Portugal">(GMT) Portugal</option>
                                        <option value="UCT">(GMT) UCT</option>
                                        <option value="UTC">(GMT) UTC</option>
                                        <option value="Universal">(GMT) Universal</option>
                                        <option value="WET">(GMT) WET</option>
                                        <option value="Zulu">(GMT) Zulu</option>
                                        <option value="Africa/Algiers">(GMT+01:00) Africa/Algiers</option>
                                        <option value="Africa/Bangui">(GMT+01:00) Africa/Bangui</option>
                                        <option value="Africa/Brazzaville">(GMT+01:00) Africa/Brazzaville</option>
                                        <option value="Africa/Casablanca">(GMT+01:00) Africa/Casablanca</option>
                                        <option value="Africa/Ceuta">(GMT+01:00) Africa/Ceuta</option>
                                        <option value="Africa/Douala">(GMT+01:00) Africa/Douala</option>
                                        <option value="Africa/El_Aaiun">(GMT+01:00) Africa/El_Aaiun</option>
                                        <option value="Africa/Kinshasa">(GMT+01:00) Africa/Kinshasa</option>
                                        <option value="Africa/Lagos">(GMT+01:00) Africa/Lagos</option>
                                        <option value="Africa/Libreville">(GMT+01:00) Africa/Libreville</option>
                                        <option value="Africa/Luanda">(GMT+01:00) Africa/Luanda</option>
                                        <option value="Africa/Malabo">(GMT+01:00) Africa/Malabo</option>
                                        <option value="Africa/Ndjamena">(GMT+01:00) Africa/Ndjamena</option>
                                        <option value="Africa/Niamey">(GMT+01:00) Africa/Niamey</option>
                                        <option value="Africa/Porto-Novo">(GMT+01:00) Africa/Porto-Novo</option>
                                        <option value="Africa/Tunis">(GMT+01:00) Africa/Tunis</option>
                                        <option value="Arctic/Longyearbyen">(GMT+01:00) Arctic/Longyearbyen</option>
                                        <option value="Atlantic/Jan_Mayen">(GMT+01:00) Atlantic/Jan_Mayen</option>
                                        <option value="CET">(GMT+01:00) CET</option>
                                        <option value="Etc/GMT-1">(GMT+01:00) Etc/GMT-1</option>
                                        <option value="Europe/Amsterdam">(GMT+01:00) Europe/Amsterdam</option>
                                        <option value="Europe/Andorra">(GMT+01:00) Europe/Andorra</option>
                                        <option value="Europe/Belgrade">(GMT+01:00) Europe/Belgrade</option>
                                        <option value="Europe/Berlin">(GMT+01:00) Europe/Berlin</option>
                                        <option value="Europe/Bratislava">(GMT+01:00) Europe/Bratislava</option>
                                        <option value="Europe/Brussels">(GMT+01:00) Europe/Brussels</option>
                                        <option value="Europe/Budapest">(GMT+01:00) Europe/Budapest</option>
                                        <option value="Europe/Busingen">(GMT+01:00) Europe/Busingen</option>
                                        <option value="Europe/Copenhagen">(GMT+01:00) Europe/Copenhagen</option>
                                        <option value="Europe/Gibraltar">(GMT+01:00) Europe/Gibraltar</option>
                                        <option value="Europe/Ljubljana">(GMT+01:00) Europe/Ljubljana</option>
                                        <option value="Europe/Luxembourg">(GMT+01:00) Europe/Luxembourg</option>
                                        <option value="Europe/Madrid">(GMT+01:00) Europe/Madrid</option>
                                        <option value="Europe/Malta">(GMT+01:00) Europe/Malta</option>
                                        <option value="Europe/Monaco">(GMT+01:00) Europe/Monaco</option>
                                        <option value="Europe/Oslo">(GMT+01:00) Europe/Oslo</option>
                                        <option value="Europe/Paris">(GMT+01:00) Europe/Paris</option>
                                        <option value="Europe/Podgorica">(GMT+01:00) Europe/Podgorica</option>
                                        <option value="Europe/Prague">(GMT+01:00) Europe/Prague</option>
                                        <option value="Europe/Rome">(GMT+01:00) Europe/Rome</option>
                                        <option value="Europe/San_Marino">(GMT+01:00) Europe/San_Marino</option>
                                        <option value="Europe/Sarajevo">(GMT+01:00) Europe/Sarajevo</option>
                                        <option value="Europe/Skopje">(GMT+01:00) Europe/Skopje</option>
                                        <option value="Europe/Stockholm">(GMT+01:00) Europe/Stockholm</option>
                                        <option value="Europe/Tirane">(GMT+01:00) Europe/Tirane</option>
                                        <option value="Europe/Vaduz">(GMT+01:00) Europe/Vaduz</option>
                                        <option value="Europe/Vatican">(GMT+01:00) Europe/Vatican</option>
                                        <option value="Europe/Vienna">(GMT+01:00) Europe/Vienna</option>
                                        <option value="Europe/Warsaw">(GMT+01:00) Europe/Warsaw</option>
                                        <option value="Europe/Zagreb">(GMT+01:00) Europe/Zagreb</option>
                                        <option value="Europe/Zurich">(GMT+01:00) Europe/Zurich</option>
                                        <option value="MET">(GMT+01:00) MET</option>
                                        <option value="Poland">(GMT+01:00) Poland</option>
                                        <option value="Africa/Blantyre">(GMT+02:00) Africa/Blantyre</option>
                                        <option value="Africa/Bujumbura">(GMT+02:00) Africa/Bujumbura</option>
                                        <option value="Africa/Cairo">(GMT+02:00) Africa/Cairo</option>
                                        <option value="Africa/Gaborone">(GMT+02:00) Africa/Gaborone</option>
                                        <option value="Africa/Harare">(GMT+02:00) Africa/Harare</option>
                                        <option value="Africa/Johannesburg">(GMT+02:00) Africa/Johannesburg</option>
                                        <option value="Africa/Juba">(GMT+02:00) Africa/Juba</option>
                                        <option value="Africa/Khartoum">(GMT+02:00) Africa/Khartoum</option>
                                        <option value="Africa/Kigali">(GMT+02:00) Africa/Kigali</option>
                                        <option value="Africa/Lubumbashi">(GMT+02:00) Africa/Lubumbashi</option>
                                        <option value="Africa/Lusaka">(GMT+02:00) Africa/Lusaka</option>
                                        <option value="Africa/Maputo">(GMT+02:00) Africa/Maputo</option>
                                        <option value="Africa/Maseru">(GMT+02:00) Africa/Maseru</option>
                                        <option value="Africa/Mbabane">(GMT+02:00) Africa/Mbabane</option>
                                        <option value="Africa/Tripoli">(GMT+02:00) Africa/Tripoli</option>
                                        <option value="Africa/Windhoek">(GMT+02:00) Africa/Windhoek</option>
                                        <option value="Asia/Beirut">(GMT+02:00) Asia/Beirut</option>
                                        <option value="Asia/Famagusta">(GMT+02:00) Asia/Famagusta</option>
                                        <option value="Asia/Gaza">(GMT+02:00) Asia/Gaza</option>
                                        <option value="Asia/Hebron">(GMT+02:00) Asia/Hebron</option>
                                        <option value="Asia/Jerusalem">(GMT+02:00) Asia/Jerusalem</option>
                                        <option value="Asia/Nicosia">(GMT+02:00) Asia/Nicosia</option>
                                        <option value="Asia/Tel_Aviv">(GMT+02:00) Asia/Tel_Aviv</option>
                                        <option value="EET">(GMT+02:00) EET</option>
                                        <option value="Egypt">(GMT+02:00) Egypt</option>
                                        <option value="Etc/GMT-2">(GMT+02:00) Etc/GMT-2</option>
                                        <option value="Europe/Athens">(GMT+02:00) Europe/Athens</option>
                                        <option value="Europe/Bucharest">(GMT+02:00) Europe/Bucharest</option>
                                        <option value="Europe/Chisinau">(GMT+02:00) Europe/Chisinau</option>
                                        <option value="Europe/Helsinki">(GMT+02:00) Europe/Helsinki</option>
                                        <option value="Europe/Kaliningrad">(GMT+02:00) Europe/Kaliningrad</option>
                                        <option value="Europe/Kiev">(GMT+02:00) Europe/Kiev</option>
                                        <option value="Europe/Kyiv">(GMT+02:00) Europe/Kyiv</option>
                                        <option value="Europe/Mariehamn">(GMT+02:00) Europe/Mariehamn</option>
                                        <option value="Europe/Nicosia">(GMT+02:00) Europe/Nicosia</option>
                                        <option value="Europe/Riga">(GMT+02:00) Europe/Riga</option>
                                        <option value="Europe/Sofia">(GMT+02:00) Europe/Sofia</option>
                                        <option value="Europe/Tallinn">(GMT+02:00) Europe/Tallinn</option>
                                        <option value="Europe/Tiraspol">(GMT+02:00) Europe/Tiraspol</option>
                                        <option value="Europe/Uzhgorod">(GMT+02:00) Europe/Uzhgorod</option>
                                        <option value="Europe/Vilnius">(GMT+02:00) Europe/Vilnius</option>
                                        <option value="Europe/Zaporozhye">(GMT+02:00) Europe/Zaporozhye</option>
                                        <option value="Israel">(GMT+02:00) Israel</option>
                                        <option value="Libya">(GMT+02:00) Libya</option>
                                        <option value="Africa/Addis_Ababa">(GMT+03:00) Africa/Addis_Ababa</option>
                                        <option value="Africa/Asmara">(GMT+03:00) Africa/Asmara</option>
                                        <option value="Africa/Asmera">(GMT+03:00) Africa/Asmera</option>
                                        <option value="Africa/Dar_es_Salaam">(GMT+03:00) Africa/Dar_es_Salaam</option>
                                        <option value="Africa/Djibouti">(GMT+03:00) Africa/Djibouti</option>
                                        <option value="Africa/Kampala">(GMT+03:00) Africa/Kampala</option>
                                        <option value="Africa/Mogadishu">(GMT+03:00) Africa/Mogadishu</option>
                                        <option value="Africa/Nairobi">(GMT+03:00) Africa/Nairobi</option>
                                        <option value="Antarctica/Syowa">(GMT+03:00) Antarctica/Syowa</option>
                                        <option value="Asia/Aden">(GMT+03:00) Asia/Aden</option>
                                        <option value="Asia/Amman">(GMT+03:00) Asia/Amman</option>
                                        <option value="Asia/Baghdad">(GMT+03:00) Asia/Baghdad</option>
                                        <option value="Asia/Bahrain">(GMT+03:00) Asia/Bahrain</option>
                                        <option value="Asia/Damascus">(GMT+03:00) Asia/Damascus</option>
                                        <option value="Asia/Istanbul">(GMT+03:00) Asia/Istanbul</option>
                                        <option value="Asia/Kuwait">(GMT+03:00) Asia/Kuwait</option>
                                        <option value="Asia/Qatar">(GMT+03:00) Asia/Qatar</option>
                                        <option value="Asia/Riyadh">(GMT+03:00) Asia/Riyadh</option>
                                        <option value="Etc/GMT-3">(GMT+03:00) Etc/GMT-3</option>
                                        <option value="Europe/Istanbul">(GMT+03:00) Europe/Istanbul</option>
                                        <option value="Europe/Kirov">(GMT+03:00) Europe/Kirov</option>
                                        <option value="Europe/Minsk">(GMT+03:00) Europe/Minsk</option>
                                        <option value="Europe/Moscow">(GMT+03:00) Europe/Moscow</option>
                                        <option value="Europe/Simferopol">(GMT+03:00) Europe/Simferopol</option>
                                        <option value="Europe/Volgograd">(GMT+03:00) Europe/Volgograd</option>
                                        <option value="Indian/Antananarivo">(GMT+03:00) Indian/Antananarivo</option>
                                        <option value="Indian/Comoro">(GMT+03:00) Indian/Comoro</option>
                                        <option value="Indian/Mayotte">(GMT+03:00) Indian/Mayotte</option>
                                        <option value="Turkey">(GMT+03:00) Turkey</option>
                                        <option value="W-SU">(GMT+03:00) W-SU</option>
                                        <option value="Asia/Tehran">(GMT+03:30) Asia/Tehran</option>
                                        <option value="Iran">(GMT+03:30) Iran</option>
                                        <option value="Asia/Baku">(GMT+04:00) Asia/Baku</option>
                                        <option value="Asia/Dubai">(GMT+04:00) Asia/Dubai</option>
                                        <option value="Asia/Muscat">(GMT+04:00) Asia/Muscat</option>
                                        <option value="Asia/Tbilisi">(GMT+04:00) Asia/Tbilisi</option>
                                        <option value="Asia/Yerevan">(GMT+04:00) Asia/Yerevan</option>
                                        <option value="Etc/GMT-4">(GMT+04:00) Etc/GMT-4</option>
                                        <option value="Europe/Astrakhan">(GMT+04:00) Europe/Astrakhan</option>
                                        <option value="Europe/Samara">(GMT+04:00) Europe/Samara</option>
                                        <option value="Europe/Saratov">(GMT+04:00) Europe/Saratov</option>
                                        <option value="Europe/Ulyanovsk">(GMT+04:00) Europe/Ulyanovsk</option>
                                        <option value="Indian/Mahe">(GMT+04:00) Indian/Mahe</option>
                                        <option value="Indian/Mauritius">(GMT+04:00) Indian/Mauritius</option>
                                        <option value="Indian/Reunion">(GMT+04:00) Indian/Reunion</option>
                                        <option value="Asia/Kabul">(GMT+04:30) Asia/Kabul</option>
                                        <option value="Antarctica/Mawson">(GMT+05:00) Antarctica/Mawson</option>
                                        <option value="Asia/Aqtau">(GMT+05:00) Asia/Aqtau</option>
                                        <option value="Asia/Aqtobe">(GMT+05:00) Asia/Aqtobe</option>
                                        <option value="Asia/Ashgabat">(GMT+05:00) Asia/Ashgabat</option>
                                        <option value="Asia/Ashkhabad">(GMT+05:00) Asia/Ashkhabad</option>
                                        <option value="Asia/Atyrau">(GMT+05:00) Asia/Atyrau</option>
                                        <option value="Asia/Dushanbe">(GMT+05:00) Asia/Dushanbe</option>
                                        <option value="Asia/Karachi">(GMT+05:00) Asia/Karachi</option>
                                        <option value="Asia/Oral">(GMT+05:00) Asia/Oral</option>
                                        <option value="Asia/Qyzylorda">(GMT+05:00) Asia/Qyzylorda</option>
                                        <option value="Asia/Samarkand">(GMT+05:00) Asia/Samarkand</option>
                                        <option value="Asia/Tashkent">(GMT+05:00) Asia/Tashkent</option>
                                        <option value="Asia/Yekaterinburg">(GMT+05:00) Asia/Yekaterinburg</option>
                                        <option value="Etc/GMT-5">(GMT+05:00) Etc/GMT-5</option>
                                        <option value="Indian/Kerguelen">(GMT+05:00) Indian/Kerguelen</option>
                                        <option value="Indian/Maldives">(GMT+05:00) Indian/Maldives</option>
                                        <option value="Asia/Calcutta">(GMT+05:30) Asia/Calcutta</option>
                                        <option value="Asia/Colombo">(GMT+05:30) Asia/Colombo</option>
                                        <option value="Asia/Kolkata">(GMT+05:30) Asia/Kolkata</option>
                                        <option value="Asia/Kathmandu">(GMT+05:45) Asia/Kathmandu</option>
                                        <option value="Asia/Katmandu">(GMT+05:45) Asia/Katmandu</option>
                                        <option value="Antarctica/Vostok">(GMT+06:00) Antarctica/Vostok</option>
                                        <option value="Asia/Almaty">(GMT+06:00) Asia/Almaty</option>
                                        <option value="Asia/Bishkek">(GMT+06:00) Asia/Bishkek</option>
                                        <option value="Asia/Dacca">(GMT+06:00) Asia/Dacca</option>
                                        <option value="Asia/Dhaka">(GMT+06:00) Asia/Dhaka</option>
                                        <option value="Asia/Kashgar">(GMT+06:00) Asia/Kashgar</option>
                                        <option value="Asia/Omsk">(GMT+06:00) Asia/Omsk</option>
                                        <option value="Asia/Qostanay">(GMT+06:00) Asia/Qostanay</option>
                                        <option value="Asia/Thimbu">(GMT+06:00) Asia/Thimbu</option>
                                        <option value="Asia/Thimphu">(GMT+06:00) Asia/Thimphu</option>
                                        <option value="Asia/Urumqi">(GMT+06:00) Asia/Urumqi</option>
                                        <option value="Etc/GMT-6">(GMT+06:00) Etc/GMT-6</option>
                                        <option value="Indian/Chagos">(GMT+06:00) Indian/Chagos</option>
                                        <option value="Asia/Rangoon">(GMT+06:30) Asia/Rangoon</option>
                                        <option value="Asia/Yangon">(GMT+06:30) Asia/Yangon</option>
                                        <option value="Indian/Cocos">(GMT+06:30) Indian/Cocos</option>
                                        <option value="Antarctica/Davis">(GMT+07:00) Antarctica/Davis</option>
                                        <option value="Asia/Bangkok">(GMT+07:00) Asia/Bangkok</option>
                                        <option value="Asia/Barnaul">(GMT+07:00) Asia/Barnaul</option>
                                        <option value="Asia/Ho_Chi_Minh">(GMT+07:00) Asia/Ho_Chi_Minh</option>
                                        <option value="Asia/Hovd">(GMT+07:00) Asia/Hovd</option>
                                        <option value="Asia/Jakarta">(GMT+07:00) Asia/Jakarta</option>
                                        <option value="Asia/Krasnoyarsk">(GMT+07:00) Asia/Krasnoyarsk</option>
                                        <option value="Asia/Novokuznetsk">(GMT+07:00) Asia/Novokuznetsk</option>
                                        <option value="Asia/Novosibirsk">(GMT+07:00) Asia/Novosibirsk</option>
                                        <option value="Asia/Phnom_Penh">(GMT+07:00) Asia/Phnom_Penh</option>
                                        <option value="Asia/Pontianak">(GMT+07:00) Asia/Pontianak</option>
                                        <option value="Asia/Saigon">(GMT+07:00) Asia/Saigon</option>
                                        <option value="Asia/Tomsk">(GMT+07:00) Asia/Tomsk</option>
                                        <option value="Asia/Vientiane">(GMT+07:00) Asia/Vientiane</option>
                                        <option value="Etc/GMT-7">(GMT+07:00) Etc/GMT-7</option>
                                        <option value="Indian/Christmas">(GMT+07:00) Indian/Christmas</option>
                                        <option value="Asia/Brunei">(GMT+08:00) Asia/Brunei</option>
                                        <option value="Asia/Choibalsan">(GMT+08:00) Asia/Choibalsan</option>
                                        <option value="Asia/Chongqing">(GMT+08:00) Asia/Chongqing</option>
                                        <option value="Asia/Chungking">(GMT+08:00) Asia/Chungking</option>
                                        <option value="Asia/Harbin">(GMT+08:00) Asia/Harbin</option>
                                        <option value="Asia/Hong_Kong">(GMT+08:00) Asia/Hong_Kong</option>
                                        <option value="Asia/Irkutsk">(GMT+08:00) Asia/Irkutsk</option>
                                        <option value="Asia/Kuala_Lumpur">(GMT+08:00) Asia/Kuala_Lumpur</option>
                                        <option value="Asia/Kuching">(GMT+08:00) Asia/Kuching</option>
                                        <option value="Asia/Macao">(GMT+08:00) Asia/Macao</option>
                                        <option value="Asia/Macau">(GMT+08:00) Asia/Macau</option>
                                        <option value="Asia/Makassar">(GMT+08:00) Asia/Makassar</option>
                                        <option value="Asia/Manila">(GMT+08:00) Asia/Manila</option>
                                        <option value="Asia/Shanghai">(GMT+08:00) Asia/Shanghai</option>
                                        <option value="Asia/Singapore">(GMT+08:00) Asia/Singapore</option>
                                        <option value="Asia/Taipei">(GMT+08:00) Asia/Taipei</option>
                                        <option value="Asia/Ujung_Pandang">(GMT+08:00) Asia/Ujung_Pandang</option>
                                        <option value="Asia/Ulaanbaatar">(GMT+08:00) Asia/Ulaanbaatar</option>
                                        <option value="Asia/Ulan_Bator">(GMT+08:00) Asia/Ulan_Bator</option>
                                        <option value="Australia/Perth">(GMT+08:00) Australia/Perth</option>
                                        <option value="Australia/West">(GMT+08:00) Australia/West</option>
                                        <option value="Etc/GMT-8">(GMT+08:00) Etc/GMT-8</option>
                                        <option value="Hongkong">(GMT+08:00) Hongkong</option>
                                        <option value="PRC">(GMT+08:00) PRC</option>
                                        <option value="ROC">(GMT+08:00) ROC</option>
                                        <option value="Singapore">(GMT+08:00) Singapore</option>
                                        <option value="Australia/Eucla">(GMT+08:45) Australia/Eucla</option>
                                        <option value="Asia/Chita">(GMT+09:00) Asia/Chita</option>
                                        <option value="Asia/Dili">(GMT+09:00) Asia/Dili</option>
                                        <option value="Asia/Jayapura">(GMT+09:00) Asia/Jayapura</option>
                                        <option value="Asia/Khandyga">(GMT+09:00) Asia/Khandyga</option>
                                        <option value="Asia/Pyongyang">(GMT+09:00) Asia/Pyongyang</option>
                                        <option value="Asia/Seoul">(GMT+09:00) Asia/Seoul</option>
                                        <option value="Asia/Tokyo">(GMT+09:00) Asia/Tokyo</option>
                                        <option value="Asia/Yakutsk">(GMT+09:00) Asia/Yakutsk</option>
                                        <option value="Etc/GMT-9">(GMT+09:00) Etc/GMT-9</option>
                                        <option value="Japan">(GMT+09:00) Japan</option>
                                        <option value="Pacific/Palau">(GMT+09:00) Pacific/Palau</option>
                                        <option value="ROK">(GMT+09:00) ROK</option>
                                        <option value="Australia/Darwin">(GMT+09:30) Australia/Darwin</option>
                                        <option value="Australia/North">(GMT+09:30) Australia/North</option>
                                        <option value="Antarctica/DumontDUrville">(GMT+10:00) Antarctica/DumontDUrville
                                        </option>
                                        <option value="Asia/Ust-Nera">(GMT+10:00) Asia/Ust-Nera</option>
                                        <option value="Asia/Vladivostok">(GMT+10:00) Asia/Vladivostok</option>
                                        <option value="Australia/Brisbane">(GMT+10:00) Australia/Brisbane</option>
                                        <option value="Australia/Lindeman">(GMT+10:00) Australia/Lindeman</option>
                                        <option value="Australia/Queensland">(GMT+10:00) Australia/Queensland</option>
                                        <option value="Etc/GMT-10">(GMT+10:00) Etc/GMT-10</option>
                                        <option value="Pacific/Chuuk">(GMT+10:00) Pacific/Chuuk</option>
                                        <option value="Pacific/Guam">(GMT+10:00) Pacific/Guam</option>
                                        <option value="Pacific/Port_Moresby">(GMT+10:00) Pacific/Port_Moresby</option>
                                        <option value="Pacific/Saipan">(GMT+10:00) Pacific/Saipan</option>
                                        <option value="Pacific/Truk">(GMT+10:00) Pacific/Truk</option>
                                        <option value="Pacific/Yap">(GMT+10:00) Pacific/Yap</option>
                                        <option value="Australia/Adelaide">(GMT+10:30) Australia/Adelaide</option>
                                        <option value="Australia/Broken_Hill">(GMT+10:30) Australia/Broken_Hill</option>
                                        <option value="Australia/South">(GMT+10:30) Australia/South</option>
                                        <option value="Australia/Yancowinna">(GMT+10:30) Australia/Yancowinna</option>
                                        <option value="Antarctica/Casey">(GMT+11:00) Antarctica/Casey</option>
                                        <option value="Antarctica/Macquarie">(GMT+11:00) Antarctica/Macquarie</option>
                                        <option value="Asia/Magadan">(GMT+11:00) Asia/Magadan</option>
                                        <option value="Asia/Sakhalin">(GMT+11:00) Asia/Sakhalin</option>
                                        <option value="Asia/Srednekolymsk">(GMT+11:00) Asia/Srednekolymsk</option>
                                        <option value="Australia/ACT">(GMT+11:00) Australia/ACT</option>
                                        <option value="Australia/Canberra">(GMT+11:00) Australia/Canberra</option>
                                        <option value="Australia/Currie">(GMT+11:00) Australia/Currie</option>
                                        <option value="Australia/Hobart">(GMT+11:00) Australia/Hobart</option>
                                        <option value="Australia/LHI">(GMT+11:00) Australia/LHI</option>
                                        <option value="Australia/Lord_Howe">(GMT+11:00) Australia/Lord_Howe</option>
                                        <option value="Australia/Melbourne">(GMT+11:00) Australia/Melbourne</option>
                                        <option value="Australia/NSW">(GMT+11:00) Australia/NSW</option>
                                        <option value="Australia/Sydney">(GMT+11:00) Australia/Sydney</option>
                                        <option value="Australia/Tasmania">(GMT+11:00) Australia/Tasmania</option>
                                        <option value="Australia/Victoria">(GMT+11:00) Australia/Victoria</option>
                                        <option value="Etc/GMT-11">(GMT+11:00) Etc/GMT-11</option>
                                        <option value="Pacific/Bougainville">(GMT+11:00) Pacific/Bougainville</option>
                                        <option value="Pacific/Efate">(GMT+11:00) Pacific/Efate</option>
                                        <option value="Pacific/Guadalcanal">(GMT+11:00) Pacific/Guadalcanal</option>
                                        <option value="Pacific/Kosrae">(GMT+11:00) Pacific/Kosrae</option>
                                        <option value="Pacific/Noumea">(GMT+11:00) Pacific/Noumea</option>
                                        <option value="Pacific/Pohnpei">(GMT+11:00) Pacific/Pohnpei</option>
                                        <option value="Pacific/Ponape">(GMT+11:00) Pacific/Ponape</option>
                                        <option value="Asia/Anadyr">(GMT+12:00) Asia/Anadyr</option>
                                        <option value="Asia/Kamchatka">(GMT+12:00) Asia/Kamchatka</option>
                                        <option value="Etc/GMT-12">(GMT+12:00) Etc/GMT-12</option>
                                        <option value="Kwajalein">(GMT+12:00) Kwajalein</option>
                                        <option value="Pacific/Fiji">(GMT+12:00) Pacific/Fiji</option>
                                        <option value="Pacific/Funafuti">(GMT+12:00) Pacific/Funafuti</option>
                                        <option value="Pacific/Kwajalein">(GMT+12:00) Pacific/Kwajalein</option>
                                        <option value="Pacific/Majuro">(GMT+12:00) Pacific/Majuro</option>
                                        <option value="Pacific/Nauru">(GMT+12:00) Pacific/Nauru</option>
                                        <option value="Pacific/Norfolk">(GMT+12:00) Pacific/Norfolk</option>
                                        <option value="Pacific/Tarawa">(GMT+12:00) Pacific/Tarawa</option>
                                        <option value="Pacific/Wake">(GMT+12:00) Pacific/Wake</option>
                                        <option value="Pacific/Wallis">(GMT+12:00) Pacific/Wallis</option>
                                        <option value="Antarctica/McMurdo">(GMT+13:00) Antarctica/McMurdo</option>
                                        <option value="Antarctica/South_Pole">(GMT+13:00) Antarctica/South_Pole</option>
                                        <option value="Etc/GMT-13">(GMT+13:00) Etc/GMT-13</option>
                                        <option value="NZ">(GMT+13:00) NZ</option>
                                        <option value="Pacific/Apia">(GMT+13:00) Pacific/Apia</option>
                                        <option value="Pacific/Auckland">(GMT+13:00) Pacific/Auckland</option>
                                        <option value="Pacific/Enderbury">(GMT+13:00) Pacific/Enderbury</option>
                                        <option value="Pacific/Fakaofo">(GMT+13:00) Pacific/Fakaofo</option>
                                        <option value="Pacific/Kanton">(GMT+13:00) Pacific/Kanton</option>
                                        <option value="Pacific/Tongatapu">(GMT+13:00) Pacific/Tongatapu</option>
                                        <option value="NZ-CHAT">(GMT+13:45) NZ-CHAT</option>
                                        <option value="Pacific/Chatham">(GMT+13:45) Pacific/Chatham</option>
                                        <option value="Etc/GMT-14">(GMT+14:00) Etc/GMT-14</option>
                                        <option value="Pacific/Kiritimati">(GMT+14:00) Pacific/Kiritimati</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35 position-relative">
                                    <label>{{ translate('Date Format') }}</label>
                                    <select class="form-control custom-select" name="date_format" id="date_format"
                                        required="required">
                                        <option value="M j, Y"
                                            {{ old('date_format', get_setting('date_format')) == 'M j, Y' ? 'selected' : '' }}>
                                            Oct 30, 2023</option>
                                        <option value="Y-m-d"
                                            {{ old('date_format', get_setting('date_format')) == 'Y-m-d' ? 'selected' : '' }}>
                                            2023-10-30</option>
                                        <option value="d-m-Y"
                                            {{ old('date_format', get_setting('date_format')) == 'd-m-Y' ? 'selected' : '' }}>
                                            30-10-2023</option>
                                        <option value="d/m/Y"
                                            {{ old('date_format', get_setting('date_format')) == 'd/m/Y' ? 'selected' : '' }}>
                                            30/10/2023 </option>
                                        <option value="m/d/Y"
                                            {{ old('date_format', get_setting('date_format')) == 'm/d/Y' ? 'selected' : '' }}>
                                            10/30/2023 </option>
                                        <option value="m.d.Y"
                                            {{ old('date_format', get_setting('date_format')) == 'm.d.Y' ? 'selected' : '' }}>
                                            10.30.2023 </option>
                                        <option value="j, n, Y"
                                            {{ old('date_format', get_setting('date_format')) == 'j, n, Y' ? 'selected' : '' }}>
                                            30, 10, 2023 </option>
                                        <option value="F j, Y"
                                            {{ old('date_format', get_setting('date_format')) == 'F j, Y' ? 'selected' : '' }}>
                                            October 30, 2023 </option>
                                        <option value="M j, Y"
                                            {{ old('date_format', get_setting('date_format')) == 'M j, Y' ? 'selected' : '' }}>
                                            Oct 30, 2023</option>
                                        <option value="j M, Y"
                                            {{ old('date_format', get_setting('date_format')) == 'j M, Y' ? 'selected' : '' }}>
                                            30 Oct, 2023</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Commission from Merchant') }}</label>
                                    <input type="text" name="merchant_commission"
                                        value="{{ old('merchant_commission', get_setting('merchant_commission')) }}"
                                        placeholder="{{ translate('Commission from Merchant') }}"
                                        aria-label="Commission from Merchant" aria-describedby="merchant_commission">
                                    <span class="form-inner-text" id="merchant_commission">%</span>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="payment-method-header">
                                    <label>{{ translate('Email Verification (Merchant)') }}</label>
                                    <div class="pmt-active-inactive">
                                        <button
                                            class="eg-btn  {{ get_setting('merchant_email_verification') == 1 ? 'green-light--btn ' : 'red-light--btn ' }}">
                                            {{ get_setting('merchant_email_verification') == 1 ? 'Active' : 'Deactivate' }}
                                        </button>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="merchant_email_verification"
                                                {{ old('merchant_email_verification', get_setting('merchant_email_verification')) == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="payment-method-header">
                                    <label>{{ translate('Email Verification (Customer)') }}</label>
                                    <div class="pmt-active-inactive">
                                        <button
                                            class="eg-btn  {{ get_setting('customer_email_verification') == 1 ? 'green-light--btn ' : 'red-light--btn ' }}">
                                            {{ get_setting('customer_email_verification') == 1 ? 'Active' : 'Deactivate' }}
                                        </button>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                name="customer_email_verification"
                                                {{ old('customer_email_verification', get_setting('customer_email_verification')) == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Invoice Logo') }}</label>
                                    <input type="file" name="invoice_logo" class="form-control">
                                    @if (get_setting('invoice_logo'))
                                        <img class="mt-2" src="{{ asset('assets/logo/' . get_setting('invoice_logo')) }}"
                                            alt="Invoice Logo" width="100">
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-setting" role="tabpanel" aria-labelledby="v-pills-setting-tab">

                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-12">
                                <button type="button" class="eg-btn btn--primary back-btn float-end"
                                    data-bs-toggle="modal" data-bs-target="#testMail"><img
                                        src="{{ asset('backend/images/icons/add-icon.svg') }}" alt="Test Mail">
                                    {{ translate('Test Mail') }}</button>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Driver') }}</label>
                                    <select class="js-example-basic-single" name="mail_driver">
                                        <option value="">{{ translate('Select Option') }}</option>
                                        <option value="smtp"
                                            {{ old('mail_driver', get_setting('mail_driver')) == 'smtp' ? 'selected' : '' }}>
                                            smtp</option>
                                        <option value="sendmail"
                                            {{ old('mail_driver', get_setting('mail_driver')) == 'sendmail' ? 'selected' : '' }}>
                                            sendmail</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Host') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('mail_host', get_setting('mail_host')) }}" name="mail_host"
                                        placeholder="{{ translate('Host') }}">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Port') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('mail_port', get_setting('mail_port')) }}" name="mail_port"
                                        placeholder="{{ translate('Port') }}">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('From Address') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('mail_from_address', get_setting('mail_from_address')) }}"
                                        name="mail_from_address" placeholder="{{ translate('From Address') }}">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('From Name') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('mail_from_name', get_setting('mail_from_name')) }}"
                                        name="mail_from_name" placeholder="{{ translate('From Name') }}">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Encryption') }}</label>
                                    <input type="text" class="form-control"
                                        value="{{ old('mail_encryption', get_setting('mail_encryption')) }}"
                                        name="mail_encryption" placeholder="{{ translate('Encryption') }}">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Username') }}</label>
                                    <input type="text" autocomplete="off" class="form-control"
                                        value="{{ old('mail_username', get_setting('mail_username')) }}"
                                        name="mail_username" placeholder="{{ translate('Username') }}">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="form-inner mb-35">
                                    <label>{{ translate('Password') }}</label>
                                    <input type="text" autocomplete="off" class="form-control"
                                        value="{{ old('mail_password', get_setting('mail_password')) }}"
                                        name="mail_password" placeholder="{{ translate('Password') }}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-recaptcha" role="tabpanel"
                    aria-labelledby="v-pills-recaptcha-tab">
                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-4 mb-35">
                                <div class="row">
                                    <label class="col-sm-2"><b>{{ translate('Enabled/Disabled') }}</b></label>
                                    <div class="form-check form-switch col-sm-10">
                                        <input class="form-check-input" value="1" name="google_recapcha_check"
                                            {{ get_setting('google_recapcha_check') == 1 ? 'checked' : '' }}
                                            type="checkbox">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Recaptcha Key') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('recaptcha_key', get_setting('recaptcha_key')) }}"
                                            name="recaptcha_key" placeholder="{{ translate('Recaptcha Key') }}">
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-inner mb-35">
                                        <label>{{ translate('Recaptcha Secret') }}</label>
                                        <input type="text" class="form-control"
                                            value="{{ old('recaptcha_secret', get_setting('recaptcha_secret')) }}"
                                            name="recaptcha_secret" placeholder="{{ translate('Recaptcha Secret') }}">
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-tawk" role="tabpanel" aria-labelledby="v-pills-tawk-tab">
                    <div class="eg-card product-card">
                        <div class="row">
                            <div class="col-xl-4 mb-35">
                                <div class="row">
                                    <label class="col-sm-2"><b>{{ translate('Enabled/Disabled') }}</b></label>
                                    <div class="form-check form-switch col-sm-10">
                                        <input class="form-check-input" value="1" name="tawk_enabled"
                                            {{ get_setting('tawk_enabled') == 1 ? 'checked' : '' }} type="checkbox"
                                            id="flexSwitchCheckProduct18">
                                    </div>

                                </div>
                            </div>
                            <div class="col-xl-12">
                                <label class="col-sm-2 mb-2"><b>{{ translate('Tawk Embed Url') }}</b></label>
                                <div class="form-inner mb-35">
                                    <input type="text" value="{{ get_setting('tawk_code') }}" name="tawk_code">
                                </div>
                                <p> <a href="https://www.tawk.to/" target="_blank"> <b>
                                            {{ translate('Go to Tawk') }}</b> </a></p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-system-info" role="tabpanel"
                    aria-labelledby="v-pills-system-info-tab">
                    <div class="eg-card product-card">
                        <div class="system-information">
                            <table class="eg-table">
                                <tbody>
                                    <tr>
                                        <td><strong>{{ translate('PHP Version') }}</strong></td>
                                        <td> {{ phpversion() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ translate('Laravel Version') }}</strong></td>
                                        <td>{{ app()->version() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ translate('Server Software') }}</strong></td>
                                        <td>LiteSpeed</td>
                                    </tr>
                                    <tr>

                                        <td><strong>{{ translate('Server IP Address') }}</strong></td>
                                        <td>{{ $_SERVER['REMOTE_ADDR'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ translate('Server Protocol') }}</strong></td>
                                        <td>{{ $_SERVER['SERVER_PROTOCOL'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ translate('HTTP Host') }}</strong></td>
                                        <td>{{ env('DB_HOST') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ translate('Database Port') }}</strong></td>
                                        <td>{{ env('DB_PORT') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong> {{ translate('App Environment') }} </strong></td>
                                        <td>{{ Config::get('app.env') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ translate('App Debug') }}</strong></td>
                                        <td>{{ Config::get('app.debug') == 1 ? 'true' : 'false' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ translate('Timezone') }}</strong></td>
                                        <td>{{ Config::get('app.timezone') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <div class="button-group mt-15">
                    <input type="submit" class="eg-btn btn--green medium-btn me-3" value="{{ 'Update' }}">
                </div>
            </div>
        </div>
    </form>
    <input type="hidden" value="{{ get_setting('time_zone') }}" id="timezoneValue">
    @include('backend.backend_setting.modal')
@endsection
