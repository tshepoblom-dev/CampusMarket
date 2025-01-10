<?php

namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected  $guarded =['id'];

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $menuTranslations = $this->menuTranslations->where('lang', $lang)->first();
        return $menuTranslations != null ? $menuTranslations->$field : $this->$field;
    }

    public function menuTranslations()
    {
        return $this->hasMany(MenuTranslation::class);
    }

}
