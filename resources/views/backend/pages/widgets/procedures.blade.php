@if (@isset($widgetContent))
    <div class="sortable-item accordion-item allowPrimary" data-code="{{ $widgetContent->ui_card_number }}">
        <div class="accordion-header">
            <div class="section-name"> {{ $widgetContent->widget?->widget_name }}
                <div class="collapsed d-flex">
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input status-change"
                            data-action="{{ route('pages.widget.status.change', $widgetContent->id) }}"
                            {{ $widgetContent->status == 1 ? 'checked' : '' }} type="checkbox" role="switch"
                            id="{{ $widgetContent->id }}">
                        <label class="form-check-label d-none" for="{{ $widgetContent->id }}"> </label>
                    </div>

                    <div class="collapsed-action-btn edit-action action-icon me-2">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div class="action-icon delete-action" data-id="{{ $widgetContent->id }}">
                        <i class="bi bi-trash"></i>
                    </div>

                </div>
            </div>
        </div>


        <div class="accordion-collapse collapse ">
            <div class="accordion-body">
                @php
                $widgetContents= $widgetContent->getTranslation("widget_content",$lang);
               @endphp
                <form enctype="multipart/form-data" data-action="{{ route('pages.widget.save') }}" class="form"
                    method="POST">
                    @csrf

                    <input type="hidden" name="ui_card_number" value="{{ $widgetContent->ui_card_number }}">
                    <input type="hidden" name="page_id" value="{{ $widgetContent->page_id }}">
                    <input type="hidden" name="widget_slug" class="widget-slug"
                        value="{{ $widgetContent->widget_slug }}">

                    <div class="procedures-area">
                        @if (isset($widgetContents['procedures']))

                            @php
                                $count = 0;
                            @endphp

                            @foreach ($widgetContents['procedures'] as $key => $procedure)
                                @php

                                    $count++;
                                @endphp
                                <div class="row align-items-center content">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-sm-5 mb-2">
                                                <div class="form-inner">

                                                    <label>{{ translate('Name') }}</label>
                                                    <input type="text" class="username-input"
                                                        placeholder="{{ translate('Enter Name') }}"
                                                        name="content[0][procedures][{{ $count }}][name]"
                                                        value="{{ isset($procedure['name']) ? $procedure['name'] : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-7 mb-2">
                                                <div class="form-inner">
                                                    <label>{{ translate('Image') }}</label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="file" class="username-input widget-image-upload"
                                                            name="image" data-folder="/uploads/procedures/">

                                                        <input type="hidden"
                                                            name="content[0][procedures][{{ $count }}][img]"
                                                            id="old_file"
                                                            value="{{ isset($procedure['img']) ? $procedure['img'] : '' }}">

                                                        @if (isset($procedure['img']))
                                                            <div class="ms-2">
                                                                <img height="50" width="auto"
                                                                    src="{{ asset('uploads/procedures/' . $procedure['img']) }}"
                                                                    alt="">
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="col-sm-5 mb-2">
                                                <div class="form-inner">
                                                    <label>{{ translate('Button Text') }}</label>
                                                    <input type="text" class="username-input"
                                                        placeholder="{{ translate('Enter Button Text') }}"
                                                        name="content[0][procedures][{{ $count }}][button_text]"
                                                        value="{{ isset($procedure['button_text']) ? $procedure['button_text'] : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-7 mb-2">
                                                <div class="form-inner">
                                                    <label>{{ translate('Button Url') }}</label>
                                                    <input type="text" class="username-input"
                                                        placeholder="{{ translate('Button Url') }}"
                                                        name="content[0][procedures][{{ $count }}][button_url]"
                                                        value="{{ isset($procedure['button_url']) ? $procedure['button_url'] : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-4">
                                                <div class="form-inner">
                                                    <label>{{ translate('Description') }}</label>
                                                    <textarea rows="6" name="content[0][procedures][{{ $count }}][description]"> {{ isset($procedure['description']) ? $procedure['description'] : '' }}  </textarea>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-sm-1 text-center">
                                        <button class="remove-information remove text-danger border-0">
                                            <i class="bi  bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="add-row">
                        <button type="button" class="add-procedures-btn eg-btn btn--primary back-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                        </button>
                    </div>
                    <div class="button-area text-end">
                        <button type="submit"
                            class="eg-btn btn--green medium-btn shadow">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@else
    <div class="sortable-item accordion-item allowPrimary" data-code="{{ $randomId }}">
        <div class="accordion-header" id="herosection">
            <div class="section-name"> {{ $widgetName }}
                <div class="collapsed d-flex">
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input status-change"
                            data-action="{{ route('pages.widget.status.change', $randomId) }}" checked
                            type="checkbox" role="switch" id="{{ $randomId }}">
                        <label class="form-check-label d-none" for="{{ $randomId }}"> </label>
                    </div>
                    <div class="collapsed-action-btn edit-action action-icon me-2">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div class="action-icon delete-action" data-id="{{ $randomId }}">
                        <i class="bi bi-trash"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-collapse collapse show">
            <div class="accordion-body">
                <form eenctype="multipart/form-data" data-action="{{ route('pages.widget.save') }}" class="form"
                    method="POST">
                    @csrf

                    <input type="hidden" name="ui_card_number" value="{{ $randomId }}">
                    <input type="hidden" name="page_id" value="{{ $pageId }}">
                    <input type="hidden" name="widget_slug" class="widget-slug" value="{{ $slug }}">
                    <div class="procedures-area">

                    </div>
                    <div class="add-row">
                        <button type="button" class="add-procedures-btn eg-btn btn--primary back-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>
                        </button>
                    </div>


                    <div class="button-area text-end">
                        <button type="submit"
                            class="eg-btn btn--green medium-btn shadow">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endif
