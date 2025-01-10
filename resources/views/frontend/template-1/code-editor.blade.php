@php
    $editorContent ="";
    if (isset($singelWidgetData->widget_content)) {
        $editorContent = $singelWidgetData->getTranslation("widget_content");
    }
@endphp
<div class="page-content-area pt-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="banner-content">
                    <p>
                        @php
                          $content=  isset($editorContent['content']) ? $editorContent['content'] : 'test';

                        @endphp

                        {!! clean($content) !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ========== Inner Banner end============= -->
