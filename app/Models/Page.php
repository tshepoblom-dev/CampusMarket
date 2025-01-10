<?php

namespace App\Models;

use App\Models\WidgetContent;
use App\Models\PageTranslation;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    protected $casts = [
        'meta_keyward' => 'array',
    ];



    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $pageTranslations = $this->pageTranslations->where('lang', $lang)->first();
        return $pageTranslations != null ? $pageTranslations->$field : $this->$field;
    }

    public function pageTranslations(){
    	return $this->hasMany(PageTranslation::class);
    }


    public static function getSingleWidgets($slugName)
    {
       $singleWidgets= Widget::where(['widget_slug'=>$slugName])->first();
       return $singleWidgets;
    }

    /**
     * Get the options associated with the user.
     */
    public static function getSinglePageById($id)
    {
        $singlePage   =self::where(['id'=>$id])->first();
        return $singlePage;
    }

    public function widgetContents()  {
        return $this->hasMany(WidgetContent::class, 'page_id', 'id')->orderBy('position', 'ASC');
    }


}
