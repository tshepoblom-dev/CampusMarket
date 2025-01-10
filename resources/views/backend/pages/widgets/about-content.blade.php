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
               @php
                     $widgetContents= $widgetContent->getTranslation("widget_content",$lang);
               @endphp
             <div class="accordion-body">
                 <form enctype="multipart/form-data" data-action="{{ route('pages.widget.save') }}" class="form"
                     method="POST">
                     @csrf

                     <input type="hidden" name="ui_card_number" value="{{ $widgetContent->ui_card_number }}">
                     <input type="hidden" name="page_id" value="{{ $widgetContent->page_id }}">
                     <input type="hidden" name="widget_slug" class="widget-slug" value="{{ $widgetContent->widget_slug }}">
                     <div class="row">
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Title') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Enter Title') }}"
                                     name="content[0][about_content_title]"
                                     value="{{ isset($widgetContents['about_content_title']) ? $widgetContents['about_content_title'] : '' }}">
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-inner">
                                 <label> {{ translate('Sub Title') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Enter Sub Title') }}"
                                     name="content[0][about_content_sub_title]"
                                     value="{{ isset($widgetContents['about_content_sub_title']) ? $widgetContents['about_content_sub_title'] : '' }}">
                             </div>
                         </div>

                         <div class="col-sm-4 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Image') }}</label>
                                 <div class="d-flex">
                                     <input class="form-control  widget-image-upload " type="file" id="formFile"
                                         name="image" data-folder="/uploads/about_content/">

                                     <input type="hidden" name="content[0][img]" id="old_file"
                                         value="{{ isset($widgetContent->widget_content['img']) ? $widgetContent->widget_content['img'] : '' }}">

                                     @if (isset($widgetContent->widget_content['img']))
                                         <img src="{{ asset('uploads/about_content/' . $widgetContent->widget_content['img']) }}" width="50px" height="50px">
                                     @endif

                                 </div>

                             </div>
                         </div>
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner ">
                                 <label>{{ translate('Total Raised') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Total Raised') }}" name="content[0][total_raised]"
                                     value="{{ isset($widgetContents['total_raised']) ? $widgetContents['total_raised'] : '' }}">
                             </div>
                         </div>
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner ">
                                 <label>{{ translate('Button Text') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Button Text') }}"
                                     name="content[0][about_content_btn_text]"
                                     value="{{ isset($widgetContents['about_content_btn_text']) ? $widgetContents['about_content_btn_text'] : '' }}">
                             </div>
                         </div>
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Button Url') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Button Url') }}"
                                     name="content[0][about_content_btn_url]"
                                     value="{{ isset($widgetContents['about_content_btn_url']) ? $widgetContents['about_content_btn_url'] : '' }}">
                             </div>
                         </div>
                         <div class="col-sm-12 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Description') }}</label>
                                 @php
                                 $contentDescript= isset($widgetContents['about_content_descriptions']) ?   $widgetContents['about_content_descriptions']  : '';
                                 $contentDescript=  html_entity_decode($contentDescript);
                                 $contentDescript=  prelaceScript($contentDescript);
                               @endphp

                                 <textarea class="summernote" name="content[0][about_content_descriptions]"> {{clean($contentDescript)}}  </textarea>
                             </div>
                         </div>

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
                 <form enctype="multipart/form-data" data-action="{{ route('pages.widget.save') }}" class="form"
                     method="POST">
                     @csrf

                     <input type="hidden" name="ui_card_number" value="{{ $randomId }}">
                     <input type="hidden" name="page_id" value="{{ $pageId }}">
                     <input type="hidden" name="widget_slug" class="widget-slug" value="{{ $slug }}">

                     <div class="row">
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Title') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Enter Title') }}"
                                     name="content[0][about_content_title]">
                             </div>
                         </div>
                         <div class="col-sm-4">
                             <div class="form-inner">
                                 <label> {{ translate('Sub Title') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Enter Sub Title') }}"
                                     name="content[0][about_content_sub_title]">
                             </div>
                         </div>

                         <div class="col-sm-4 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Image') }}</label>
                                 <div class="d-flex">
                                     <input class="form-control  widget-image-upload " type="file" id="formFile"
                                         name="image" data-folder="/uploads/about_content/">
                                     <input type="hidden" name="content[0][img]" id="old_file">



                                 </div>

                             </div>
                         </div>
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner ">
                                 <label>{{ translate('Total Raised') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Total Raised') }}" name="content[0][total_raised]">
                             </div>
                         </div>
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner ">
                                 <label>{{ translate('Button Text') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Button Text') }}"
                                     name="content[0][about_content_btn_text]">
                             </div>
                         </div>
                         <div class="col-sm-4 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Button Url') }}</label>
                                 <input type="text" class="username-input"
                                     placeholder="{{ translate('Button Url') }}"
                                     name="content[0][about_content_btn_url]">
                             </div>
                         </div>
                         <div class="col-sm-12 mb-2">
                             <div class="form-inner">
                                 <label>{{ translate('Description') }}</label>
                                 <textarea class="summernote" name="content[0][about_content_descriptions]">   </textarea>
                             </div>
                         </div>
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
