@php
    $funFactsDataItem = [];
    if (isset($singelWidgetData->widget_content)) {
        $funFactsDataItem = $singelWidgetData->getTranslation("widget_content");
    }
@endphp
<!-- =============== counter-section start =============== -->
@include('frontend.template-'.$templateId.'.partials.fun_facts_section')

<!-- =============== counter-section end =============== -->
