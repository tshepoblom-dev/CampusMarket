<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $menuItemTranslations = $this->menuItemTranslations->where('lang', $lang)->first();
        return $menuItemTranslations != null ? $menuItemTranslations->$field : $this->$field;
    }

    public function menuItemTranslations(){
    	return $this->hasMany(MenuItemTranslation::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order', 'asc');
    }


    public function childrens()
    {
        return $this->children()->with('childrens');
    }

    public function menus()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }


     public function page(){
         return $this->belongsTo(Page::class, 'slug', 'page_slug');
     }
     public function category(){
         return $this->belongsTo(Category::class, 'slug', 'slug');
     }
     public function blog(){
         return $this->belongsTo(Blog::class, 'slug', 'slug');
     }


}
