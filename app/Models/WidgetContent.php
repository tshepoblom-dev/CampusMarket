<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WidgetContent extends Model
{
    use HasFactory;

    protected $casts = [
        'widget_content' => 'array',
    ];


    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $widgetTranslations = $this->widgetTranslations->where('lang', $lang)->first();
        return $widgetTranslations != null ? $widgetTranslations->$field : $this->$field;
    }

    public function widgetTranslations(){
    	return $this->hasMany(WidgetContentTranslation::class);
    }



    /**
     * Get the Widget content by unique form Id
     */
    public static function getSingleWidgetContent($cardId='')
    {
        $singleWidgets= WidgetContent::where(['ui_card_number'=>$cardId])->first();
        if ($singleWidgets){
            return $singleWidgets;
        }else{
            return new WidgetContent;
        }
    }

    public function widget() {
        return $this->belongsTo(Widget::class, 'widget_slug', 'widget_slug');

    }

}
