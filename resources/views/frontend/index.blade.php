@extends('frontend.template-'.$templateId.'.partials.master')

@section('content')


    @if(isset($is_bread_crumb))
       @if ($is_bread_crumb==1)
       @include('frontend.template-'.$templateId.'.breadcrumb.breadcrumb',['slugName'=>$params,'title'=>$title])
       @endif
    @endif

    @if($activeWidgets)
        @foreach($activeWidgets as $key=>$item)
            @php
                $where = array('ui_card_number' => $item->ui_card_number);
                $singelWidgetData=\App\Models\WidgetContent::where($where)->first();
            @endphp
            @include('frontend.template-'.$templateId.'.'.$singelWidgetData->widget_slug,['singelWidgetData'=>$singelWidgetData,'params'=>$params,'templateId'=>$templateId])
        @endforeach
    @endif
@endsection
