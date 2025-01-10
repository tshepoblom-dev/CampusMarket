@if(@isset($widgetContent))
 <div class="sortable-item accordion-item allowPrimary" data-code="{{$widgetContent->ui_card_number}}">
    <div class="accordion-header">
        <div class="section-name"> {{$widgetContent->widget?->widget_name}}
            <div class="collapsed d-flex">
                <div class="form-check form-switch me-2">
                    <input class="form-check-input status-change"  data-action="{{route('pages.widget.status.change',$widgetContent->id )}}"   {{$widgetContent->status==1 ? 'checked' :"" }} type="checkbox" role="switch" id="{{$widgetContent->id}}">
                    <label class="form-check-label d-none" for="{{$widgetContent->id}}"> </label>
                </div>

                <div class="collapsed-action-btn edit-action action-icon me-2">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="action-icon delete-action" data-id="{{$widgetContent->id}}">
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
            <form enctype="multipart/form-data" data-action="{{route('pages.widget.save')}}" class="form" method="POST">
                @csrf

                <input type="hidden" name="ui_card_number" value="{{$widgetContent->ui_card_number}}">
                <input type="hidden" name="page_id" value="{{$widgetContent->page_id}}">
                <input type="hidden" name="widget_slug" class="widget-slug" value="{{$widgetContent->widget_slug}}">
                <div class="row">
                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Display Per Page')}}</label>
                            <input type="text" class="username-input"
                                    placeholder="{{translate('Display Per Page')}}"
                                    name="content[0][display_per_page]"
                                    value="{{isset($widgetContents['display_per_page'])? $widgetContents['display_per_page'] :''}}">
                        </div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Order By')}}</label>
                            <select class="js-example-basic-single" name="content[0][storted_by]">
                                <option disabled>{{translate('Select Option')}}</option>
                                <option value="desc" {{isset($widgetContents['storted_by']) && $widgetContents['storted_by']=='desc'? 'selected':''}}>{{translate('Descending')}}</option>
                                <option value="asc" {{isset($widgetContents['storted_by']) && $widgetContents['storted_by']=='asc'? 'selected':''}}> {{translate('Ascending')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Product Type')}}</label>
                            <select class="js-example-basic-single" name="content[0][product_type]" required>
                                <option selected disabled>{{translate('Select Product Type')}}</option>
                                <option value="all" {{isset($widgetContents['product_type']) && $widgetContents['product_type']=='all'? 'selected':''}}>{{translate('All')}}</option>
                                <option value="auction" {{isset($widgetContents['product_type']) && $widgetContents['product_type']=='auction'? 'selected':''}}>{{translate('Auction')}}</option>
                                <option value="direct" {{isset($widgetContents['product_type']) && $widgetContents['product_type']=='direct'? 'selected':''}}>{{translate('Direct')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Enable Sidebar')}}</label>
                            <select class="js-example-basic-single" name="content[0][sidebar_enable]" required>
                                <option selected disabled>{{translate('Select Option')}}</option>
                                <option value="yes" {{isset($widgetContents['sidebar_enable']) && $widgetContents['sidebar_enable']=='yes'? 'selected':''}}>{{translate('Yes')}}</option>
                                <option value="no" {{isset($widgetContents['sidebar_enable']) && $widgetContents['sidebar_enable']=='no'? 'selected':''}}>{{translate('No')}}</option>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="button-area text-end">
                    <button type="submit" class="eg-btn btn--green medium-btn shadow"
                        >{{translate('Update')}}</button>
                </div>
            </form>
        </div>
    </div>

</div>

 @else

 <div class="sortable-item accordion-item allowPrimary" data-code="{{$randomId}}">
    <div class="accordion-header" id="herosection">
        <div class="section-name" > {{$widgetName}}
            <div class="collapsed d-flex">
                <div class="form-check form-switch me-2">
                    <input class="form-check-input status-change"  data-action="{{route('pages.widget.status.change',$randomId )}}"  checked  type="checkbox" role="switch" id="{{$randomId}}">
                    <label class="form-check-label d-none" for="{{$randomId}}"> </label>
                </div>
                <div class="collapsed-action-btn edit-action action-icon me-2">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="action-icon delete-action" data-id="{{$randomId}}">
                    <i class="bi bi-trash"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-collapse collapse show">
        <div class="accordion-body">
            <form enctype="multipart/form-data"  data-action="{{route('pages.widget.save')}}" class="form" method="POST">
                @csrf

                <input type="hidden" name="ui_card_number" value="{{$randomId}}">
                <input type="hidden" name="page_id" value="{{$pageId}}">
                <input type="hidden" name="widget_slug" class="widget-slug" value="{{$slug}}">

                <div class="row">
                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Display Per Page')}}</label>
                            <input type="text" class="username-input" placeholder="{{translate('Display Per Page')}}"
                             name="content[0][display_per_page]"
                             value="9"
                             >
                        </div>
                    </div>



                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Order By')}}</label>
                            <select class="js-example-basic-single" name="content[0][storted_by]">
                                <option disabled>{{translate('Select Option')}}</option>
                                <option value="desc" selected>{{translate('Descending')}}</option>
                                <option value="asc">{{translate('Ascending')}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Product Type')}}</label>
                            <select class="js-example-basic-single" name="content[0][product_type]" required>
                                <option disabled>{{translate('Select Product Type')}}</option>
                                <option value="all" selected>{{translate('All')}}</option>
                                <option value="auction" selected>{{translate('Auction')}}</option>
                                <option value="direct">{{translate('Direct')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <div class="form-inner">
                            <label> {{translate('Enable Sidebar')}}</label>
                            <select class="js-example-basic-single" name="content[0][sidebar_enable]" required>
                                <option  disabled>{{translate('Select Option')}}</option>
                                <option value="yes" selected>{{translate('Yes')}}</option>
                                <option value="no">{{translate('No')}}</option>
                            </select>
                        </div>
                    </div>


                </div>

                <div class="button-area text-end">
                    <button type="submit" class="eg-btn btn--green medium-btn shadow"
                        >{{translate('Save')}}</button>
                </div>
            </form>
        </div>
    </div>

</div>
 @endif
